<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
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
        return $this
            ->subject('It’s CONCLAVE Day! Your Event Ticket & QR Code')
            ->view('emails.event-day-qr');
    }
}