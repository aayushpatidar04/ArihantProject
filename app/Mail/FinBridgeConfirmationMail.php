<?php

namespace App\Mail;

use App\Models\FinbridgeRegistration;
use App\Services\CalendarLinkService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class FinBridgeConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public FinbridgeRegistration $registration,
        public string $qrImagePath,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Confirmed — ArihantPLUS Fin bridge expo Ahemdabad 2026',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.finbridge-confirmation',
            with: [
                'qrUrl'       => asset('storage/' . $this->qrImagePath),
            ],
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        // QR image
        $qrPath = storage_path('app/public/' . $this->qrImagePath);
        if (file_exists($qrPath)) {
            $attachments[] = Attachment::fromPath($qrPath)
                ->as('arihantplus-qr.png')
                ->withMime('image/png');
        }

        return $attachments;
    }
}