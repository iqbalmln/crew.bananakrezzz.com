<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Worker antrean WhatsApp untuk hosting tanpa supervisor: jalan tiap menit,
        // berhenti saat antrean kosong.
        //
        // Dipanggil lewat Schedule::call() + Artisan::call(), bukan
        // $schedule->command(), karena command() menjalankan task sebagai
        // sub-proses via Symfony Process dan server ini memblokir proc_open.
        //
        // name() wajib sebelum withoutOverlapping(): closure tidak punya nama
        // alami seperti command, jadi kunci mutex-nya harus diberi nama sendiri.
        // Angka 5 = umur kunci dalam menit; tanpa itu kunci bertahan 24 jam,
        // sehingga worker tidak menyala lagi seharian kalau prosesnya mati mendadak.
        $schedule->call(fn() => Artisan::call('queue:work --queue=whatsapp --stop-when-empty --max-time=50'))
            ->name('wa-worker')
            ->everyMinute()
            ->withoutOverlapping(5);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
