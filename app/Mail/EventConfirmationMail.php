<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class EventConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public EventRegistration $registration,
        public string $qrImagePath,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ArihantPLUS Conclave 2026 — Registration Confirmed',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.confirmation',
            with: [
                'qrUrl' => asset('storage/' . $this->qrImagePath),
                'eventDate' => '5 September 2026',
                'eventTime' => '10:00 AM - 5:00 PM',
                'venue' => 'Labh Mandapam, Indore',
            ],
        );
    }

    public function attachments(): array
    {
        $path = storage_path('app/public/' . $this->qrImagePath);
        if (file_exists($path)) {
            return [Attachment::fromPath($path)->as('arihantplus-qr.png')->withMime('image/png')];
        }
        return [];
    }
}
