<?php

namespace App\Console\Commands;

use App\Mail\EventReminder1DayMail;
use App\Mail\EventReminder2DayMail;
use App\Mail\EventReminderSameDayMail;
use App\Models\EventRegistration;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEventReminders extends Command
{
    protected $signature = 'reminders:event {type : Type of reminder: 2day, 1day, same}';
    protected $description = 'Send event reminder emails & WhatsApp to paid registrations';

    public function handle(WhatsAppService $whatsapp): int
    {
        $type = $this->argument('type');

        if (!in_array($type, ['2day', '1day', 'same'])) {
            $this->error('Invalid type. Use: 2day, 1day, or same');
            return 1;
        }

        $regs = EventRegistration::where('status', 'paid')->get();

        if ($regs->isEmpty()) {
            $this->info('No paid registrations found.');
            return 0;
        }

        $sentEmail = 0;
        $sentWa = 0;
        $failed = 0;

        foreach ($regs as $reg) {
            $ticketUrl = route('registration.success');

            // Email
            $emailOk = false;
            try {
                $mailable = match ($type) {
                    '2day' => new EventReminder2DayMail($reg),
                    '1day' => new EventReminder1DayMail($reg),
                    'same' => new EventReminderSameDayMail($reg),
                };

                if (!empty($reg->email)) {
                    Mail::to($reg->email)->send($mailable);
                    $emailOk = true;
                    $sentEmail++;
                }
            } catch (\Exception $e) {
                Log::error("Event reminder email [{$type}] failed: " . $e->getMessage(), [
                    'reg_id' => $reg->id,
                ]);
            }

            // WhatsApp
            $waOk = match ($type) {
                '2day' => $whatsapp->sendReminder2Day($reg, $ticketUrl),
                '1day' => $whatsapp->sendReminder1Day($reg, $ticketUrl),
                'same' => $whatsapp->sendReminderSameDay($reg, $ticketUrl),
            };

            if ($waOk) {
                $sentWa++;
            }

            if (!$emailOk && !$waOk) {
                $failed++;
            }
        }

        $this->info("Event reminder [{$type}] — Email: {$sentEmail}, WhatsApp: {$sentWa}, Failed: {$failed}");
        return 0;
    }
}