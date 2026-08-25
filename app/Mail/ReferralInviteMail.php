<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReferralInviteMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public EventRegistration $referrer,
        public string $referredName,
        public string $referralLink,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You\'re Invited — ArihantPLUS AI & Algo Conclave 2026',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.referral-invite',
        );
    }
}