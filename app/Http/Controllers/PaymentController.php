<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\EventRegistration;
use App\Services\PaymentGatewayService;
use App\Services\QrCodeService;
use App\Services\WhatsAppService;
use App\Services\EmailService;
use App\Services\LeadScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentGatewayService $payment,
        protected QrCodeService $qr,
        protected WhatsAppService $whatsapp,
        protected EmailService $email,
        protected LeadScoringService $leadScore,
    ) {}

    /**
     * Atom server-to-server webhook.
     * Configure this in Atom dashboard as your webhook URL.
     * URL: POST https://yourdomain.com/webhook/atom
     */
    public function atomWebhook(Request $request)
    {
        $payload = $request->all();
        Log::info('Atom webhook received', ['payload' => $payload]);

        $decrypted = $this->payment->decryptCallback($payload);

        if (!$decrypted) {
            Log::error('Atom webhook decryption failed');
            return response()->json(['status' => 'decrypt_failed'], 400);
        }

        Log::info('Atom webhook decrypted', $decrypted);

        $merchTxnId = $decrypted['merchTxnId']
            ?? ($decrypted['payInstrument']['merchDetails']['merchTxnId'] ?? null);

        if (!$merchTxnId) {
            return response()->json(['status' => 'missing_txn_id'], 400);
        }

        $payment = Payment::where('merch_txn_id', $merchTxnId)->first();

        if (!$payment) {
            return response()->json(['status' => 'payment_not_found'], 404);
        }

        // Only process if not already paid
        if (($decrypted['f_code'] ?? '') === 'Ok' && $payment->status !== 'paid') {
            $payment->update([
                'gateway_payment_id' => $decrypted['atomTxnId'] ?? ($decrypted['txnId'] ?? null),
                'status'               => 'paid',
                'gateway_response'     => $decrypted,
                'paid_at'              => now(),
            ]);

            $reg = $payment->registration;

            if ($reg && $reg->status !== 'paid') {
                $reg->update(['status' => 'paid', 'paid_at' => now()]);

                // Idempotent: only generate QR once
                $existingQr = $reg->qrCodes()->where('purpose', 'entry')->first();
                if (!$existingQr) {
                    $qr = $this->qr->generateEntryQr($reg);
                    $qrUrl = asset('storage/' . $qr->image_path);
                    $this->whatsapp->sendQrImage($reg, $qrUrl);
                    $this->email->sendConfirmation($reg, $qr->image_path);
                }

                $this->leadScore->calculateScore($reg);

                // Referral points
                if ($reg->referred_by) {
                    $referrer = EventRegistration::where('referral_code', $reg->referred_by)->first();
                    if ($referrer) {
                        $referrer->referralsMade()
                            ->where('referred_email', $reg->email)
                            ->update(['status' => 'paid', 'points_awarded' => 50]);
                        $this->leadScore->calculateScore($referrer);
                    }
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }

    public function razorWebhook(Request $request)
    {
        $payload = $request->all();
        $secret = config('services.payment.webhook_secret');

        // Verify webhook signature if provided by gateway
        $signature = $request->header('X-Razorpay-Signature');
        if ($signature) {
            $expected = hash_hmac('sha256', json_encode($payload), $secret);
            if (!hash_equals($expected, $signature)) {
                return response()->json(['status' => 'invalid_signature'], 400);
            }
        }

        if (isset($payload['event']) && $payload['event'] === 'payment.captured') {
            $paymentEntity = $payload['payload']['payment']['entity'] ?? null;
            if ($paymentEntity) {
                $payment = Payment::where('gateway_order_id', $paymentEntity['order_id'])->first();
                if ($payment && $payment->status !== 'paid') {
                    $payment->update([
                        'gateway_payment_id' => $paymentEntity['id'],
                        'status' => 'paid',
                        'gateway_response' => $payload,
                        'paid_at' => now(),
                    ]);
                    $payment->registration->update(['status' => 'paid', 'paid_at' => now()]);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}