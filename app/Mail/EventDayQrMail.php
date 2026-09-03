<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class EventDayQrMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public EventRegistration $registration,
        public string $qrImagePath
    ) {
    }

    public function build()
    {
        $qrUrl = asset('storage/' . $this->qrImagePath);
        return $this
            ->subject('It’s CONCLAVE Day! Your Event Ticket & QR Code')
            ->view('emails.event-day-qr', compact('qrUrl'));
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