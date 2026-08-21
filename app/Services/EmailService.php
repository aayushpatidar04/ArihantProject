<?php

namespace App\Services;

use App\Models\Communication;
use App\Models\EventRegistration;
use App\Mail\EventConfirmationMail;
use App\Mail\SeatConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Send registration confirmation with calendar invite.
     */

    public function sendRegistrationSuccessful(
        EventRegistration $registration,
        ?string $plainPassword = null
    ): void {
        try {
            Mail::to($registration->email)->send(
                new \App\Mail\RegistrationSuccessfulMail($registration, $plainPassword)
            );
            // $this->logCommunication($registration, 'registration_successful', 'Registration successful email sent', 'sent');
        } catch (\Exception $e) {
            Log::error('Registration email failed: ' . $e->getMessage());
            // $this->logCommunication($registration, 'registration_successful', 'Registration successful email', 'failed', $e->getMessage());
        }
    }

    public function sendConfirmation(EventRegistration $registration, string $qrImagePath): void
    {
        try {
            Mail::to($registration->email)->send(new EventConfirmationMail($registration, $qrImagePath));
            // $this->logCommunication($registration, 'confirmation', 'Registration confirmation with calendar invite', 'sent');
        } catch (\Exception $e) {
            Log::error('Email confirmation failed: ' . $e->getMessage());
            // $this->logCommunication($registration, 'confirmation', 'Registration confirmation', 'failed', $e->getMessage());
        }
    }

    /**
     * Send seat allocation email.
     */
    public function sendSeatConfirmation(EventRegistration $registration, string $seatNumber): void
    {
        try {
            Mail::to($registration->email)->send(new SeatConfirmationMail($registration, $seatNumber));
            // $this->logCommunication($registration, 'seat', 'Seat confirmation: ' . $seatNumber, 'sent');
        } catch (\Exception $e) {
            Log::error('Seat email failed: ' . $e->getMessage());
            // $this->logCommunication($registration, 'seat', 'Seat confirmation', 'failed', $e->getMessage());
        }
    }

    /**
     * Send reminder email.
     */
    public function sendReminder(EventRegistration $registration, string $subject, string $body): void
    {
        try {
            Mail::raw($body, function ($message) use ($registration, $subject) {
                $message->to($registration->email)->subject($subject);
            });
            // $this->logCommunication($registration, 'reminder', $body, 'sent');
        } catch (\Exception $e) {
            Log::error('Reminder email failed: ' . $e->getMessage());
            // $this->logCommunication($registration, 'reminder', $body, 'failed', $e->getMessage());
        }
    }

    protected function logCommunication(EventRegistration $registration, string $type, string $content, string $status, ?string $error = null): void
    {
        Communication::create([
            'event_registration_id' => $registration->id,
            'channel' => 'email',
            'type' => $type,
            'content' => $content,
            'status' => $status,
            'error' => $error,
            'sent_at' => $status === 'sent' ? now() : null,
        ]);
    }
}
