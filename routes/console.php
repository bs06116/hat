<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
// Registering the command
// Artisan::command('completed:jobs', function () {
//     $this->info('Marking completed jobs...');
// })->purpose('Mark completed jobs and create invoices');

// Schedule the command to run
// Schedule::command('completed:jobs')->everyMinute();
Schedule::command('weekly:invoice')->sundays();
Schedule::command('queue:work --stop-when-empty')->everyMinute();


