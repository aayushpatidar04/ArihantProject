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
     * Send OTP via Arihant SMS API.
     */
    public function sendOtp(string $phone, string $otp): bool
    {
        if (empty($this->apiKey)) {
            Log::warning('SMS API key not configured. SMS skipped.');
            return false;
        }

        // Ensure 10-digit format
        $phone = preg_replace('/\D/', '', $phone);
        if (strlen($phone) === 12 && str_starts_with($phone, '91')) {
            $phone = substr($phone, 2);
        }

        $message = "Your OTP for Arihant Capital Markets Research Servicing Tracker login is {$otp}. Valid for 10 minutes. Do not share this OTP with anyone. - ARIHANT";

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
            // $this->logCommunication($phone, $message, 'failed', $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error('Arihant SMS API exception: ' . $e->getMessage());
            // $this->logCommunication($phone, $message, 'failed', $e->getMessage());
            return false;
        }
    }

    protected function logCommunication(string $phone, string $content, string $status, ?string $error = null): void
    {
        Communication::create([
            'event_registration_id' => null,
            'phone' => $phone,
            'channel' => 'sms',
            'type' => 'otp',
            'content' => $content,
            'status' => $status,
            'error' => $error,
            'sent_at' => now(),
        ]);
    }
}