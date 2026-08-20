<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccessfulMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public EventRegistration $registration,
        public ?string $plainPassword = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Successful — ArihantPLUS Conclave 2026',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration_successful',
            with: [
                'eventDate' => '8 September 2026',
                'eventTime' => '10:00 AM - 5:00 PM',
                'venue' => 'Labh Mandapam, Indore',
                'password' => $this->plainPassword,
            ],
        );
    }
}