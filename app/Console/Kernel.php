<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // Worker antrean WhatsApp untuk hosting tanpa supervisor: jalan tiap menit,
        // berhenti saat antrean kosong. withoutOverlapping() menjaga hanya ada
        // satu worker, supaya jeda antar pesan tetap berlaku.
        $schedule->command('queue:work --queue=whatsapp --stop-when-empty --max-time=50')
            ->everyMinute()
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
