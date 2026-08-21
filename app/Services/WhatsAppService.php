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

    public function __construct(
        protected SmsService $sms,
    ) {
        $this->apiUrl = config('services.whatsapp.api_url', 'https://pickyassist.com/app/api/v2/push');
        $this->token = config('services.whatsapp.token');
        $this->applicationId = config('services.whatsapp.application_id');
    }

    /**
     * Send OTP via WhatsApp AND SMS simultaneously.
     */
    public function sendOtpToPhone(string $phone, string $otp): bool
    {
        $whatsappOk = $this->sendOtpViaWhatsApp($phone, $otp);
        $smsOk = $this->sms->sendOtp($phone, $otp);

        // Return true if at least one channel succeeded
        return $whatsappOk || $smsOk;
    }

    /**
     * WhatsApp-only OTP (PickyAssist).
     */
    protected function sendOtpViaWhatsApp(string $phone, string $otp): bool
    {
        if (empty($this->token) || empty($this->applicationId)) {
            Log::warning('PickyAssist not configured. WhatsApp OTP skipped.');
            return false;
        }

        $reference = 'otp_' . $phone . '_' . now()->format('YmdHis') . '_' . \Illuminate\Support\Str::random(4);

        try {
            $response = Http::post($this->apiUrl, [
                'token' => $this->token,
                'application' => $this->applicationId,
                'template_id' => config('services.whatsapp.otp_template'),
                'reference_number' => $reference,
                'data' => [
                    [
                        'number' => $this->formatPhone($phone),
                        'language' => 'en',
                        'template_message' => [$otp],
                    ]
                ],
            ]);

            $json = $response->json();
            Log::info('PickyAssist OTP response', ['response' => $json, 'reference' => $reference]);

            if (!$response->successful() || ($json['status'] ?? 0) != 100) {
                Log::error('PickyAssist OTP failed', ['response' => $json]);
                // $this->logRawCommunication($phone, 'otp', "OTP: {$otp}", 'failed', $reference, null, null, $json['message'] ?? 'API error');
                return false;
            }

            $pushId = $json['push_id'] ?? null;
            $msgId = $json['data'][0]['msg_id'] ?? null;

            // $this->logRawCommunication($phone, 'otp', "OTP: {$otp}", 'submitted', $reference, $pushId, $msgId);
            return true;

        } catch (\Exception $e) {
            Log::error('PickyAssist OTP exception: ' . $e->getMessage());
            // $this->logRawCommunication($phone, 'otp', "OTP: {$otp}", 'failed', $reference, null, null, $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       Meta/WhatsApp Cloud API methods (unchanged)
       ============================================================ */

    public function sendOtp(EventRegistration $registration, string $otp): bool
    {
        $message = "Your ArihantPLUS verification code is: {$otp}. Valid for 10 minutes. Do not share it with anyone.";
        return $this->sendTextMessage($registration, $message, 'otp');
    }

    public function sendSeatConfirmation(EventRegistration $registration, string $seatNumber): bool
    {
        $message = "Welcome to ArihantPLUS Conclave! Your seat number is {$seatNumber}. Show this message at the entrance. Have a great day!";
        return $this->sendTextMessage($registration, $message, 'seat');
    }

    public function sendReminder(EventRegistration $registration, string $daysLeft): bool
    {
        $message = "Reminder: ArihantPLUS AI & Algo Conclave is in {$daysLeft}! Venue: Labh Mandapam, Indore. See you there!";
        return $this->sendTextMessage($registration, $message, 'reminder');
    }

    public function sendThankYou(EventRegistration $registration): bool
    {
        $message = "Thank you for attending ArihantPLUS Conclave! We hope you found it valuable. Please share your feedback: [link]";
        return $this->sendTextMessage($registration, $message, 'thank_you');
    }

    protected function sendTextMessage(EventRegistration $registration, string $message, string $type): bool
    {
        if (empty($this->token) || empty($this->phoneNumberId)) {
            Log::warning('WhatsApp credentials not configured. Message queued.');
            // $this->logCommunication($registration, $type, $message, 'queued');
            return false;
        }

        try {
            $url = "{$this->apiUrl}/{$this->phoneNumberId}/messages";
            $response = Http::withToken($this->token)->post($url, [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $this->formatPhone($registration->phone),
                'type' => 'text',
                'text' => ['body' => $message],
            ]);

            $success = $response->successful();
            // $this->logCommunication($registration, $type, $message, $success ? 'sent' : 'failed', $success ? null : $response->body());
            return $success;
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed: ' . $e->getMessage());
            // $this->logCommunication($registration, $type, $message, 'failed', $e->getMessage());
            return false;
        }
    }

    protected function sendRawText(string $phone, string $message, string $type): bool
    {
        if (empty($this->token) || empty($this->phoneNumberId)) {
            Log::warning('WhatsApp credentials not configured. OTP queued for ' . $phone);
            return false;
        }

        try {
            $url = "{$this->apiUrl}/{$this->phoneNumberId}/messages";
            $response = Http::withToken($this->token)->post($url, [
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

    public function sendQrImage(EventRegistration $registration, string $imageUrl): bool
    {
        if (empty($this->token) || empty($this->phoneNumberId)) {
            // $this->logCommunication($registration, 'qr_code', 'QR Image: ' . $imageUrl, 'queued');
            return false;
        }

        try {
            $url = "{$this->apiUrl}/{$this->phoneNumberId}/messages";
            $response = Http::withToken($this->token)->post($url, [
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
            // $this->logCommunication($registration, 'qr_code', $imageUrl, 'failed', $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       Helpers
       ============================================================ */

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
            'phone' => $registration->phone,
            'channel' => 'whatsapp',
            'type' => $type,
            'content' => $content,
            'status' => $status,
            'error' => $error,
            'sent_at' => $status === 'sent' ? now() : null,
        ]);
    }

    protected function logRawCommunication(
        string $phone,
        string $type,
        string $content,
        string $status,
        ?string $reference = null,
        ?string $pushId = null,
        ?string $msgId = null,
        ?string $error = null
    ): void {
        Communication::create([
            'event_registration_id' => null,
            'phone' => $phone,
            'channel' => 'whatsapp',
            'type' => $type,
            'content' => $content,
            'status' => $status,
            'reference_number' => $reference,
            'provider_push_id' => $pushId,
            'provider_msg_id' => $msgId,
            'provider_error' => $error,
            'sent_at' => now(),
        ]);
    }
}