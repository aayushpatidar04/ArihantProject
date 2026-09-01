<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventThankYouMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public EventRegistration $registration,
        public string $feedbackLink,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank You for Being Part of the AI & ALGO CONCLAVE!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-thank-you',
        );
    }
}