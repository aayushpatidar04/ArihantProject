<?php

namespace App\Console\Commands;

use App\Models\EventRegistration;
use App\Services\EmailService;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendEventDayQrReminder extends Command
{
    protected $signature = 'reminders:event-day-qr';

    protected $description = 'Send event-day QR ticket reminder via WhatsApp and email';

    public function __construct(
        protected WhatsAppService $whatsapp,
        protected EmailService $email
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting event-day QR reminder...');

        $sentWhatsapp = 0;
        $sentEmail = 0;
        $failedWhatsapp = 0;
        $failedEmail = 0;

        EventRegistration::with('qrCodes')
            ->whereNotNull('phone')
            ->where('status', 'paid')
            ->orderBy('id')
            ->chunkById(50, function ($registrations) use (
                &$sentWhatsapp,
                &$sentEmail,
                &$failedWhatsapp,
                &$failedEmail
            ) {

                foreach ($registrations as $registration) {

                    $this->line('');
                    $this->line('======================================');
                    $this->line(
                        "Registration: {$registration->id} - {$registration->full_name}"
                    );

                    try {

                        /*
                         * Get the participant QR.
                         *
                         * IMPORTANT:
                         * Use the same QR path logic already used by
                         * your existing confirmation/reminder flow.
                         */

                        $qr = $registration->qrCodes->first();

                        if (!$qr) {
                            $this->error(
                                "QR NOT FOUND | Registration {$registration->id}"
                            );

                            Log::warning(
                                'Event day QR reminder skipped - QR not found',
                                [
                                    'registration_id' => $registration->id,
                                ]
                            );

                            continue;
                        }

                        /*
                         * Adjust this field if your QR model uses another
                         * column name.
                         */
                        $qrImagePath = $qr->image_path;

                        if (!$qrImagePath) {

                            $this->error(
                                "QR IMAGE PATH NOT FOUND | Registration {$registration->id}"
                            );

                            continue;
                        }

                        /*
                         * WhatsApp needs a publicly accessible URL.
                         */
                        $imageUrl = url(
                            '/storage/' . ltrim($qrImagePath, '/')
                        );

                        $this->line("QR URL: {$imageUrl}");

                        /*
                         * WhatsApp - PickyAssist
                         */
                        $whatsappResult = $this->whatsapp->sendDayQrImage(
                            $registration,
                            $imageUrl
                        );

                        if ($whatsappResult) {
                            $sentWhatsapp++;

                            $this->info(
                                "WhatsApp SUCCESS | {$registration->phone}"
                            );
                        } else {
                            $failedWhatsapp++;

                            $this->error(
                                "WhatsApp FAILED | {$registration->phone}"
                            );
                        }

                        /*
                         * Email
                         */
                        $emailResult = $this->email->sendEventDayQr(
                            $registration,
                            $qrImagePath
                        );

                        if ($emailResult) {
                            $sentEmail++;

                            $this->info(
                                "Email SUCCESS | {$registration->email}"
                            );
                        } else {
                            $failedEmail++;

                            $this->error(
                                "Email FAILED | {$registration->email}"
                            );
                        }

                    } catch (\Throwable $e) {

                        $this->error(
                            "ERROR | Registration {$registration->id} | {$e->getMessage()}"
                        );

                        Log::error(
                            'Event day QR reminder exception',
                            [
                                'registration_id' => $registration->id,
                                'error' => $e->getMessage(),
                            ]
                        );
                    }
                }
            });

        $this->line('');
        $this->line('======================================');
        $this->info('EVENT DAY QR REMINDER COMPLETED');
        $this->line("WhatsApp Sent : {$sentWhatsapp}");
        $this->line("WhatsApp Failed: {$failedWhatsapp}");
        $this->line("Email Sent    : {$sentEmail}");
        $this->line("Email Failed  : {$failedEmail}");

        return Command::SUCCESS;
    }
}