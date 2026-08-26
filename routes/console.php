<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('reminders:payment')->cron('0 10 */2 * *');   // Every 2nd day at 10:00 AM
Schedule::command('reminders:event 2day')->cron('0 10 3 9 *');   // 3 Sept 2026 at 10:00 AM
Schedule::command('reminders:event 1day')->cron('0 10 4 9 *');   // 4 Sept 2026 at 10:00 AM
Schedule::command('reminders:event same')->cron('0 8 5 9 *');    // 5 Sept 2026 at 8:00 AM