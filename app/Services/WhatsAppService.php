<?php

namespace App\Services;

use App\Models\Communication;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $apiUrl;
    protected string $token;
    protected string $applicationId;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url', 'https://pickyassist.com/app/api/v2/push');
        $this->token = config('services.whatsapp.token');
        $this->applicationId = config('services.whatsapp.application_id');
    }

    /**
     * Send OTP to a raw phone number (before registration exists).
     */
    public function sendOtpToPhone(string $phone, string $otp): bool
    {
        if (empty($this->token) || empty($this->applicationId)) {
            Log::warning('PickyAssist not configured. OTP queued.');
            return false;
        }
        
        try {
            $payload = [
                'token' => $this->token,
                'application' => $this->applicationId,
                'template_id' => config('services.whatsapp.otp_template'),
                'data' => [
                    [
                        'number' => $this->formatPhone($phone),
                        'language' => 'en',
                        'template_message' => [$otp],
                    ]
                ],
            ];

            $curl = sprintf(
                "curl -X POST '%s' -H 'Content-Type: application/json' -d '%s'",
                $this->apiUrl,
                json_encode($payload)
            );

            Log::info("Outgoing WhatsApp OTP cURL: " . $curl);

            $response = Http::post($this->apiUrl, $payload);
            Log::info("API Response: ", $response->json());


            return $response->successful();
        } catch (\Exception $e) {
            Log::error('PickyAssist OTP failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send OTP via WhatsApp using Meta Business API template.
     */
    public function sendOtp(EventRegistration $registration, string $otp): bool
    {
        $message = "Your ArihantPLUS verification code is: {$otp}. Valid for 10 minutes. Do not share it with anyone.";
        return $this->sendTextMessage($registration, $message, 'otp');
    }

    /**
     * Send seat allocation confirmation.
     */
    public function sendSeatConfirmation(EventRegistration $registration, string $seatNumber): bool
    {
        $message = "Welcome to ArihantPLUS Conclave! Your seat number is {$seatNumber}. Show this message at the entrance. Have a great day!";
        return $this->sendTextMessage($registration, $message, 'seat');
    }

    /**
     * Send reminder message.
     */
    public function sendReminder(EventRegistration $registration, string $daysLeft): bool
    {
        $message = "Reminder: ArihantPLUS AI & Algo Conclave is in {$daysLeft}! Venue: Labh Mandapam, Indore. See you there!";
        return $this->sendTextMessage($registration, $message, 'reminder');
    }

    /**
     * Send post-event thank you.
     */
    public function sendThankYou(EventRegistration $registration): bool
    {
        $message = "Thank you for attending ArihantPLUS Conclave! We hope you found it valuable. Please share your feedback: [link]";
        return $this->sendTextMessage($registration, $message, 'thank_you');
    }

    /**
     * Generic text message sender via Meta WhatsApp API.
     */
    protected function sendTextMessage(EventRegistration $registration, string $message, string $type): bool
    {
        if (empty($this->accessToken) || empty($this->phoneNumberId)) {
            Log::warning('WhatsApp credentials not configured. Message queued.');
            $this->logCommunication($registration, $type, $message, 'queued');
            return false;
        }

        try {
            $url = "{$this->apiUrl}/{$this->phoneNumberId}/messages";
            $response = Http::withToken($this->accessToken)->post($url, [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $this->formatPhone($registration->phone),
                'type' => 'text',
                'text' => ['body' => $message],
            ]);

            $success = $response->successful();
            $this->logCommunication($registration, $type, $message, $success ? 'sent' : 'failed', $success ? null : $response->body());
            return $success;
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed: ' . $e->getMessage());
            $this->logCommunication($registration, $type, $message, 'failed', $e->getMessage());
            return false;
        }
    }

    /**
     * Send text to a raw phone number (no registration record yet).
     */
    protected function sendRawText(string $phone, string $message, string $type): bool
    {
        if (empty($this->accessToken) || empty($this->phoneNumberId)) {
            Log::warning('WhatsApp credentials not configured. OTP queued for ' . $phone);
            return false;
        }

        try {
            $url = "{$this->apiUrl}/{$this->phoneNumberId}/messages";
            $response = Http::withToken($this->accessToken)->post($url, [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $this->formatPhone($phone),
                'type' => 'text',
                'text' => ['body' => $message],
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('WhatsApp raw send failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send media message (QR image) via WhatsApp.
     */
    public function sendQrImage(EventRegistration $registration, string $imageUrl): bool
    {
        if (empty($this->accessToken) || empty($this->phoneNumberId)) {
            $this->logCommunication($registration, 'qr_code', 'QR Image: ' . $imageUrl, 'queued');
            return false;
        }

        try {
            $url = "{$this->apiUrl}/{$this->phoneNumberId}/messages";
            $response = Http::withToken($this->accessToken)->post($url, [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $this->formatPhone($registration->phone),
                'type' => 'image',
                'image' => ['link' => $imageUrl, 'caption' => 'Your ArihantPLUS Entry QR Code. Show this at the venue.'],
            ]);

            $success = $response->successful();
            $this->logCommunication($registration, 'qr_code', $imageUrl, $success ? 'sent' : 'failed', $success ? null : $response->body());
            return $success;
        } catch (\Exception $e) {
            Log::error('WhatsApp QR send failed: ' . $e->getMessage());
            $this->logCommunication($registration, 'qr_code', $imageUrl, 'failed', $e->getMessage());
            return false;
        }
    }

    protected function formatPhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (strlen($phone) === 10) {
            $phone = '91' . $phone;
        }
        return $phone;
    }

    protected function logCommunication(EventRegistration $registration, string $type, string $content, string $status, ?string $error = null): void
    {
        Communication::create([
            'event_registration_id' => $registration->id,
            'channel' => 'whatsapp',
            'type' => $type,
            'content' => $content,
            'status' => $status,
            'error' => $error,
            'sent_at' => $status === 'sent' ? now() : null,
        ]);
    }
}
