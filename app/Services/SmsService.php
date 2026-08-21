<?php

namespace App\Services;

use App\Models\Communication;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected string $apiUrl;
    protected string $username;
    protected string $apiKey;
    protected string $authHeader;

    public function __construct()
    {
        $this->apiUrl = config('services.sms.url');
        $this->username = config('services.sms.username');
        $this->apiKey = config('services.sms.api_key');
        $this->authHeader = config('services.sms.auth_header');
    }

    /**
     * Send OTP via Arihant SMS API (Registration flow).
     */
    public function sendOtp(string $phone, string $otp): bool
    {
        if (empty($this->apiKey)) {
            Log::warning('SMS API key not configured. SMS skipped.');
            return false;
        }

        $phone = $this->normalizePhone($phone);

        $message = "Your OTP for registering for ARIHANT PLUS AI & ALGO CONCLAVE, scheduled on 5th September 2026 at Labh Mandapam, Abhay Prashal, Indore, is {$otp}. This OTP is valid for 5 minutes. By entering this OTP, you provide your consent to register for the event. Arihant Capital Markets Limited";

        return $this->dispatch($phone, $message);
    }

    /**
     * Send OTP via Arihant SMS API (Login flow).
     * Template: {#num#} is your verification code...
     */
    public function sendLoginOtp(string $phone, string $otp): bool
    {
        if (empty($this->apiKey)) {
            Log::warning('SMS API key not configured. Login OTP skipped.');
            return false;
        }

        $phone = $this->normalizePhone($phone);

        $message = "{$otp} is your verification code. For your security, do not share this code. This code expires in 2 minutes. Arihant";

        return $this->dispatch($phone, $message);
    }

    protected function dispatch(string $phone, string $message): bool
    {
        $payload = [
            [
                'UserName' => $this->username,
                'APIkey' => $this->apiKey,
                'SMSType' => '',
                'messages' => [
                    [
                        'To' => $phone,
                        'msg' => $message,
                    ],
                ],
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $this->authHeader,
            ])->post($this->apiUrl, $payload);

            Log::info('Arihant SMS API response', [
                'phone' => $phone,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('Arihant SMS API failed', ['body' => $response->body()]);
            return false;

        } catch (\Exception $e) {
            Log::error('Arihant SMS API exception: ' . $e->getMessage());
            return false;
        }
    }

    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (strlen($phone) === 12 && str_starts_with($phone, '91')) {
            $phone = substr($phone, 2);
        }
        return $phone;
    }

}