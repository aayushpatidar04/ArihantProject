<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SeatConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public EventRegistration $registration,
        public string $seatNumber,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Seat Confirmed — ArihantPLUS Conclave 2026',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.seat',
            with: [
                'seatNumber' => $this->seatNumber,
                'name' => $this->registration->full_name,
            ],
        );
    }
}
