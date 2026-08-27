<?php

namespace App\Services;

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
            $response = Http::timeout(60)->post($this->apiUrl, [
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
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('PickyAssist OTP exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send Registration Confirmation template (AW20699204).
     * Variables: Transaction ID, Amount, Payment Mode
     */
    public function sendRegistrationConfirmation(
        EventRegistration $registration,
        ?string $transactionId = null,
        ?string $amount = null,
        ?string $paymentMode = null
    ): bool {
        if (empty($this->token) || empty($this->applicationId)) {
            Log::warning('PickyAssist not configured. Registration confirmation skipped.');
            return false;
        }

        $reference = 'reg_' . $registration->phone . '_' . now()->format('YmdHis') . '_' . \Illuminate\Support\Str::random(4);

        $transactionId = $transactionId ?? $reference;
        $amount = $amount ?? ($registration->is_existing_client ? '399' : '599');
        $paymentMode = $paymentMode ?? 'Bharat QR';

        try {
            $response = Http::timeout(60)->post($this->apiUrl, [
                'token' => $this->token,
                'application' => $this->applicationId,
                'template_id' => 'WJ21349148',
                'data' => [
                    [
                        'number' => $this->formatPhone($registration->phone),
                        'language' => 'en',
                        'template_message' => [$transactionId, $amount, $paymentMode],
                    ]
                ],
            ]);

            $json = $response->json();
            Log::info('PickyAssist registration confirmation response', [
                'response' => $json,
                'reference' => $reference,
                'reg_id' => $registration->id,
            ]);

            if (!$response->successful() || ($json['status'] ?? 0) != 100) {
                Log::error('PickyAssist registration confirmation failed', ['response' => $json]);
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('PickyAssist registration confirmation exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send QR Ticket template (GW20590908) with QR media via PickyAssist.
     * Variables: {{1}} = Name
     */
    public function sendQrImage(EventRegistration $registration, string $imageUrl): bool
    {
        if (empty($this->token) || empty($this->applicationId)) {
            Log::warning('PickyAssist not configured. QR ticket skipped.');
            return false;
        }

        $reference = 'qr_' . $registration->phone . '_' . now()->format('YmdHis') . '_' . \Illuminate\Support\Str::random(4);

        try {
            $response = Http::timeout(60)->post($this->apiUrl, [
                'token' => $this->token,
                'application' => $this->applicationId,
                'template_id' => 'JJ21403323',
                'data' => [
                    [
                        'number' => $this->formatPhone($registration->phone),
                        'language' => 'en',
                        'template_message' => [$registration->full_name],
                        'media' => $imageUrl,
                    ]
                ],
            ]);

            $json = $response->json();
            Log::info('PickyAssist QR ticket response', [
                'response' => $json,
                'reference' => $reference,
                'reg_id' => $registration->id,
            ]);

            if (!$response->successful() || ($json['status'] ?? 0) != 100) {
                Log::error('PickyAssist QR ticket failed', ['response' => $json]);
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('PickyAssist QR ticket exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send Payment Reminder template (WX22433028).
     * Variables: {{1}} = Name, {{2}} = Payment Link
     */
    public function sendPaymentReminder(EventRegistration $registration, string $paymentLink): bool
    {
        if (empty($this->token) || empty($this->applicationId)) {
            Log::warning('PickyAssist not configured. Payment reminder skipped.');
            return false;
        }

        $reference = 'payrem_' . $registration->phone . '_' . now()->format('YmdHis') . '_' . \Illuminate\Support\Str::random(4);

        try {
            $response = Http::timeout(60)->post($this->apiUrl, [
                'token' => $this->token,
                'application' => $this->applicationId,
                'template_id' => 'WX22433028',
                'reference_number' => $reference,
                'data' => [
                    [
                        'number' => $this->formatPhone($registration->phone),
                        'language' => 'en',
                        'template_message' => [$registration->full_name, $paymentLink],
                    ]
                ],
            ]);

            $json = $response->json();
            Log::info('PickyAssist payment reminder response', [
                'response' => $json,
                'reference' => $reference,
                'reg_id' => $registration->id,
            ]);

            if (!$response->successful() || ($json['status'] ?? 0) != 100) {
                Log::error('PickyAssist payment reminder failed', ['response' => $json]);
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('PickyAssist payment reminder exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send 2-Day Event Reminder (YP17323923).
     * Variables: {{1}} = Name, {{2}} = View Ticket URL
     */
    public function sendReminder2Day(EventRegistration $registration, string $ticketUrl): bool
    {
        return $this->sendEventReminder($registration, $ticketUrl, 'YP17323923', '2day');
    }

    /**
     * Send 1-Day Event Reminder (PP17269800).
     * Variables: {{1}} = Name, {{2}} = View Ticket URL
     */
    public function sendReminder1Day(EventRegistration $registration): bool
    {
        return $this->sendEventReminderDay1($registration, 'PY17811120', '1day');
    }

    /**
     * Send Event Day Reminder (XX22595679).
     * Variables: {{1}} = Name, {{2}} = View Ticket URL
     */
    public function sendReminderSameDay(EventRegistration $registration, string $ticketUrl): bool
    {
        return $this->sendEventReminder($registration, $ticketUrl, 'XX22595679', 'same');
    }

    /**
     * Generic event reminder dispatcher.
     */
    protected function sendEventReminder(EventRegistration $registration, string $ticketUrl, string $templateId, string $logPrefix): bool
    {
        if (empty($this->token) || empty($this->applicationId)) {
            Log::warning('PickyAssist not configured. Event reminder skipped.');
            return false;
        }

        $reference = 'evrem_' . $logPrefix . '_' . $registration->phone . '_' . now()->format('YmdHis') . '_' . \Illuminate\Support\Str::random(4);

        try {
            $response = Http::timeout(60)->post($this->apiUrl, [
                'token' => $this->token,
                'application' => $this->applicationId,
                'template_id' => $templateId,
                'data' => [
                    [
                        'number' => $this->formatPhone($registration->phone),
                        'language' => 'en',
                        'template_message' => [$registration->full_name, $ticketUrl],
                    ]
                ],
            ]);

            $json = $response->json();
            Log::info('PickyAssist event reminder [' . $logPrefix . '] response', [
                'response' => $json,
                'reference' => $reference,
                'reg_id' => $registration->id,
            ]);

            if (!$response->successful() || ($json['status'] ?? 0) != 100) {
                Log::error('PickyAssist event reminder [' . $logPrefix . '] failed', ['response' => $json]);
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('PickyAssist event reminder [' . $logPrefix . '] exception: ' . $e->getMessage());
            return false;
        }
    }

    protected function sendEventReminderDay1(EventRegistration $registration, string $templateId, string $logPrefix): bool
    {
        if (empty($this->token) || empty($this->applicationId)) {
            Log::warning('PickyAssist not configured. Event reminder skipped.');
            return false;
        }

        $reference = 'evrem_' . $logPrefix . '_' . $registration->phone . '_' . now()->format('YmdHis') . '_' . \Illuminate\Support\Str::random(4);

        try {
            $response = Http::timeout(60)->post($this->apiUrl, [
                'token' => $this->token,
                'application' => $this->applicationId,
                'template_id' => $templateId,
                'data' => [
                    [
                        'number' => $this->formatPhone($registration->phone),
                        'language' => 'en',
                        'template_message' => [$registration->full_name],
                    ]
                ],
            ]);

            $json = $response->json();
            Log::info('PickyAssist event reminder [' . $logPrefix . '] response', [
                'response' => $json,
                'reference' => $reference,
                'reg_id' => $registration->id,
            ]);

            if (!$response->successful() || ($json['status'] ?? 0) != 100) {
                Log::error('PickyAssist event reminder [' . $logPrefix . '] failed', ['response' => $json]);
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('PickyAssist event reminder [' . $logPrefix . '] exception: ' . $e->getMessage());
            return false;
        }
    }

    /* ============================================================
       Meta/WhatsApp Cloud API methods (kept for backward compat)
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
        $message = "Reminder: ArihantPLUS AI & Algo Conclave is in {$daysLeft}! Venue: Mariott Hotel, Indore. See you there!";
        return $this->sendTextMessage($registration, $message, 'reminder');
    }

    public function sendThankYou(EventRegistration $registration): bool
    {
        $message = "Thank you for attending ArihantPLUS Conclave! We hope you found it valuable. Please share your feedback: [link]";
        return $this->sendTextMessage($registration, $message, 'thank_you');
    }

    protected function sendTextMessage(EventRegistration $registration, string $message, string $type): bool
    {
        $phoneNumberId = config('services.whatsapp.phone_number_id');
        if (empty($this->token) || empty($phoneNumberId)) {
            Log::warning('WhatsApp Cloud API credentials not configured. Message queued.');
            return false;
        }

        try {
            $url = "https://graph.facebook.com/v18.0/{$phoneNumberId}/messages";
            $response = Http::withToken($this->token)->post($url, [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $this->formatPhone($registration->phone),
                'type' => 'text',
                'text' => ['body' => $message],
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('WhatsApp Cloud API send failed: ' . $e->getMessage());
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
}