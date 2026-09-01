<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InfluencerLoginOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp
    ) {
    }

    public function build()
    {
        return $this
            ->subject('Your ArihantPLUS Influencer Login OTP')
            ->view('emails.influencer-login-otp');
    }
}