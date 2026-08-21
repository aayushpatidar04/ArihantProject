<?php

namespace App\Services;

use App\Models\EventRegistration;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentGatewayService
{
    protected string $merchantId;
    protected string $password;
    protected ?string $productId;
    protected string $payUrl;

    protected string $aesRequestKey;
    protected string $aesRequestSalt;
    protected string $aesResponseKey;
    protected string $aesResponseSalt;

    public function __construct()
    {
        $this->merchantId       = config('services.atom.merchant_id');
        $this->password         = config('services.atom.password');
        $this->productId        = config('services.atom.product_id');
        $this->payUrl           = config('services.atom.pay_url');

        $this->aesRequestKey    = config('services.atom.aes_request_key');
        $this->aesRequestSalt   = config('services.atom.aes_request_salt');
        $this->aesResponseKey   = config('services.atom.aes_response_key');
        $this->aesResponseSalt  = config('services.atom.aes_response_salt');
    }

    public function createOrder(EventRegistration $registration): ?array
    {
        $amount     = $registration->is_existing_client ? '10.00' : '10.00';
        $merchTxnId = 'ARI' . $registration->id . now()->format('His') . strtoupper(Str::random(3));

        // Format phone with 91 prefix for Atom
        $phone = preg_replace('/\D/', '', $registration->phone);
        if (strlen($phone) === 10) {
            $phone = '91' . $phone;
        }

        $payload = [
            'payInstrument' => [
                'headDetails' => [
                    'version'  => 'OTSv1.1',
                    'api'      => 'AUTH',
                    'platform' => 'FLASH',
                ],
                'merchDetails' => [
                    'merchTxnId'   => $merchTxnId,
                    'merchTxnDate' => now()->format('Y-m-d H:i:s'),
                ],
                'payDetails' => [
                    'amount'      => $amount,
                    'txnCurrency' => 'INR',
                    'product'     => $this->productId ?? 'EVENT',
                ],
                'custDetails' => [
                    'custName'   => $registration->full_name,  // ← ADD THIS
                    'custEmail'  => $registration->email,
                    'custMobile' => $phone,  // ← NOW: 919167019749 format
                ],
                'extras' => [
                    'udf1' => $registration->registration_number,
                    'udf2' => (string) $registration->id,
                    'udf3' => $registration->is_existing_client ? 'existing' : 'new',
                ],
                "PayModeSpecificData" => [
                    "subChannel" => "BQ"
                ],
            ],
        ];

        $atomTokenId = $this->createTokenId($payload);

        if (!$atomTokenId) {
            Log::error('Atom token generation failed for registration ' . $registration->id);
            return null;
        }

        Payment::create([
            'event_registration_id' => $registration->id,
            'gateway'               => 'atom',
            'merch_txn_id'          => $merchTxnId,
            'atom_token_id'         => $atomTokenId,
            'amount'                => $amount,
            'currency'              => 'INR',
            'status'                => 'created',
        ]);

        $returnUrl = route('payment.callback', Auth::id());

        Log::info('Atom order created', [
            'merchTxnId'  => $merchTxnId,
            'atomTokenId' => substr($atomTokenId, 0, 20) . '...',
            'returnUrl'   => $returnUrl,
        ]);

        return [
            'atomTokenId' => $atomTokenId,
            'merchTxnId'  => $merchTxnId,
            'merchId'     => $this->merchantId,
            'custEmail'   => $registration->email,
            'custMobile'  => $registration->phone,
            'returnUrl'   => $returnUrl,
            'jsCdn'       => config('services.atom.js_cdn'),
            'amount'      => $amount,
            'env'         => app()->isProduction() ? 'prod' : 'uat', // auto-detect
        ];
    }

    protected function createTokenId(array $data): ?string
    {
        $data['payInstrument']['merchDetails']['merchId']    = $this->merchantId;
        $data['payInstrument']['merchDetails']['password'] = $this->password;

        $jsonData = json_encode($data);
        $encData  = $this->encrypt($jsonData);

        Log::info('Atom token request', [
            'url'     => $this->payUrl,
            'payload' => $jsonData,
        ]);

        $response = Http::asForm()->post($this->payUrl, [
            'encData' => $encData,
            'merchId' => $this->merchantId,
        ]);

        $body = $response->body();
        Log::info('Atom token raw response', ['body' => $body, 'http_status' => $response->status()]);

        // Sometimes Atom returns JSON error directly
        $jsonResp = json_decode($body, true);
        if (isset($jsonResp['txnMessage']) && $jsonResp['txnMessage'] === 'FAILED') {
            Log::error('Atom token API error', $jsonResp);
            return null;
        }

        // Parse form-encoded response: merchId=...&encData=...
        parse_str($body, $parsed);
        $encResp = $parsed['encData'] ?? null;

        if (!$encResp) {
            // Fallback parsing
            $parts = explode('&', $body);
            foreach ($parts as $part) {
                if (str_starts_with($part, 'encData=')) {
                    $encResp = substr($part, 8);
                    break;
                }
            }
        }

        if (!$encResp) {
            Log::error('Atom token: no encData found in response', ['body' => $body]);
            return null;
        }

        $decrypted = $this->decrypt($encResp);

        Log::info('Atom token decrypted', ['decrypted' => $decrypted]);

        if (!is_array($decrypted)) {
            Log::error('Atom token decryption returned non-array');
            return null;
        }

        $txnStatusCode = $decrypted['responseDetails']['txnStatusCode'] ?? $decrypted['txnStatusCode'] ?? null;

        if ($txnStatusCode !== 'OTS0000') {
            Log::error('Atom token creation declined', [
                'txnStatusCode' => $txnStatusCode,
                'txnMessage'    => $decrypted['responseDetails']['txnMessage'] ?? $decrypted['txnMessage'] ?? 'unknown',
            ]);
            return null;
        }

        // atomTokenId might be at root or nested
        $atomTokenId = $decrypted['atomTokenId']
            ?? $decrypted['responseDetails']['atomTokenId']
            ?? null;

        if (!$atomTokenId) {
            Log::error('Atom token: atomTokenId missing in decrypted response', $decrypted);
        }

        return $atomTokenId;
    }

    public function decryptCallback(array $payload): ?array
    {
        $encData = $payload['encData'] ?? null;
        if (!$encData) {
            Log::warning('Atom callback: no encData present', ['payload' => $payload]);
            return null;
        }
        return $this->decrypt($encData);
    }

    public function verifySignature(array $payload): bool
    {
        $data = $this->decryptCallback($payload);
        if (!$data) return false;
        return ($data['f_code'] ?? '') === 'Ok';
    }

    public function encrypt(string $data): string
    {
        $method = 'AES-256-CBC';
        $iv     = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
        $IVbytes = implode('', array_map('chr', $iv));

        $key  = mb_convert_encoding($this->aesRequestKey, 'UTF-8');
        $salt = mb_convert_encoding($this->aesRequestSalt, 'UTF-8');
        $hash = openssl_pbkdf2($key, $salt, 256, 65536, 'sha512');

        $encrypted = openssl_encrypt($data, $method, $hash, OPENSSL_RAW_DATA, $IVbytes);
        return bin2hex($encrypted);
    }

    public function decrypt(string $data): ?array
    {
        $raw = hex2bin($data);
        if ($raw === false) {
            Log::error('Atom decrypt: hex2bin failed');
            return null;
        }

        $method = 'AES-256-CBC';
        $iv     = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
        $IVbytes = implode('', array_map('chr', $iv));

        $key  = mb_convert_encoding($this->aesResponseKey, 'UTF-8');
        $salt = mb_convert_encoding($this->aesResponseSalt, 'UTF-8');
        $hash = openssl_pbkdf2($key, $salt, 256, 65536, 'sha512');

        $decrypted = openssl_decrypt($raw, $method, $hash, OPENSSL_RAW_DATA, $IVbytes);

        if ($decrypted === false) {
            Log::error('Atom decrypt: openssl_decrypt failed');
            return null;
        }

        $json = json_decode($decrypted, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Atom decrypt: JSON decode failed', ['raw' => $decrypted]);
            return null;
        }

        return $json;
    }
}