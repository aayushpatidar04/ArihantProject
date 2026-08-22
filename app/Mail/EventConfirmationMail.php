<?php

namespace App\Mail;

use App\Models\EventRegistration;
use App\Services\CalendarLinkService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EventConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $googleLink;
    public string $outlookLink;
    public string $yahooLink;
    public string $icsPath;

    public function __construct(
        public EventRegistration $registration,
        public string $qrImagePath,
    ) {
        $title = 'ArihantPLUS AI & Algo Conclave 2026';
        $start = '2026-09-05 10:00:00'; // IST
        $end   = '2026-09-05 17:00:00'; // IST
        $location = 'Mariott Hotel, Indore';
        $description = "Central India's Largest AI & Algo Conclave, presented by Arihant Capital.\n\nRegistration #: {$registration->registration_number}";

        $this->googleLink  = CalendarLinkService::google($title, $start, $end, $location, $description);
        $this->outlookLink = CalendarLinkService::outlook($title, $start, $end, $location, $description);
        $this->yahooLink   = CalendarLinkService::yahoo($title, $start, $end, $location, $description);

        // Generate ICS file to storage
        $icsContent = CalendarLinkService::generateIcs($title, $start, $end, 'Mariott Hotel, Indore', $description, $registration->registration_number);
        $this->icsPath = 'calendar/arihantplus-' . $registration->registration_number . '.ics';
        Storage::disk('public')->put($this->icsPath, $icsContent);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Confirmed — ArihantPLUS Conclave 2026',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.confirmation',
            with: [
                'qrUrl'       => asset('storage/' . $this->qrImagePath),
                'eventDate'   => '5 September 2026',
                'eventTime'   => '10:00 AM - 5:00 PM',
                'venue'       => 'Mariott Hotel, Indore',
                'googleLink'  => $this->googleLink,
                'outlookLink' => $this->outlookLink,
                'yahooLink'   => $this->yahooLink,
                'icsUrl'      => asset('storage/' . $this->icsPath),
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

        // ICS calendar file
        $icsFullPath = storage_path('app/public/' . $this->icsPath);
        if (file_exists($icsFullPath)) {
            $attachments[] = Attachment::fromPath($icsFullPath)
                ->as('arihantplus-conclave-2026.ics')
                ->withMime('text/calendar');
        }

        return $attachments;
    }
}