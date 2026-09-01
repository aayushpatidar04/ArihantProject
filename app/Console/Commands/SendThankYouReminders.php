<?php

namespace App\Console\Commands;

use App\Mail\EventThankYouMail;
use App\Models\EventRegistration;
use App\Services\SmsService;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendThankYouReminders extends Command
{
    protected $signature = 'reminders:thankyou';
    protected $description = 'Send thank you SMS, WhatsApp & Email to checked-in attendees';

    public function handle(SmsService $sms, WhatsAppService $whatsapp): int
    {
        $regs = EventRegistration::whereNotNull('checked_in_at')->get();

        if ($regs->isEmpty()) {
            $this->info('No checked-in attendees found.');
            return 0;
        }

        $sentSms = 0;
        $sentWa = 0;
        $sentEmail = 0;
        $failed = 0;

        // Update this with your actual feedback URL
        $feedbackLink = url('/feedback');

        foreach ($regs as $reg) {
            $smsOk = $sms->sendThankYouSms($reg->phone, $reg->full_name, $feedbackLink);
            $waOk = $whatsapp->sendThankYouWhatsApp($reg, $feedbackLink);

            $emailOk = false;
            try {
                if (!empty($reg->email)) {
                    Mail::to($reg->email)->send(new EventThankYouMail($reg, $feedbackLink));
                    $emailOk = true;
                }
            } catch (\Exception $e) {
                Log::error('Thank you email failed: ' . $e->getMessage(), [
                    'reg_id' => $reg->id,
                ]);
            }

            if ($smsOk) $sentSms++;
            if ($waOk) $sentWa++;
            if ($emailOk) $sentEmail++;

            if (!$smsOk && !$waOk && !$emailOk) {
                $failed++;
            }
        }

        $this->info("Thank you reminders — SMS: {$sentSms}, WhatsApp: {$sentWa}, Email: {$sentEmail}, Failed: {$failed}");
        return 0;
    }
}