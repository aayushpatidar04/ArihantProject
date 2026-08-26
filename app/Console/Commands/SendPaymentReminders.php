<?php

namespace App\Console\Commands;

use App\Mail\PaymentReminderMail;
use App\Models\EventRegistration;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPaymentReminders extends Command
{
    protected $signature = 'reminders:payment';
    protected $description = 'Send payment reminders via WhatsApp & Email to KYC-completed users';

    public function handle(WhatsAppService $whatsapp): int
    {
        $regs = EventRegistration::where('status', 'kyc_completed')->get();

        if ($regs->isEmpty()) {
            $this->info('No pending payment registrations found.');
            return 0;
        }

        $sent = 0;
        $failed = 0;

        foreach ($regs as $reg) {
            $paymentLink = route('registration.payment');

            // WhatsApp
            $waOk = $whatsapp->sendPaymentReminder($reg, $paymentLink);

            // Email
            $emailOk = false;
            try {
                if (!empty($reg->email)) {
                    Mail::to($reg->email)->send(new PaymentReminderMail($reg, $paymentLink));
                    $emailOk = true;
                }
            } catch (\Exception $e) {
                Log::error('Payment reminder email failed: ' . $e->getMessage(), [
                    'reg_id' => $reg->id,
                    'email' => $reg->email,
                ]);
            }

            if ($waOk || $emailOk) {
                $sent++;
            } else {
                $failed++;
            }
        }

        $this->info("Payment reminders sent: {$sent}, failed: {$failed}");
        return 0;
    }
}