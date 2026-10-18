<?php

namespace App\Jobs;

use App\Support\MessageBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Kirim satu pesan WhatsApp lewat OneSender.
 *
 * Dikirim lewat queue supaya pesan tidak keluar beruntun dalam hitungan detik
 * saat satu bus datang (pola itu yang bikin nomor ditandai WhatsApp lalu
 * ter-logout). Worker memproses antrean "whatsapp" satu per satu dan menunggu
 * beberapa detik acak setelah tiap pesan. Jalankan HANYA SATU worker untuk
 * antrean ini, kalau lebih dari satu jedanya jadi tidak berlaku.
 */
class SendWhatsappMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const API_URL = 'https://wa51596.oneapi.my.id/api/v1/messages';
    const API_KEY = 'uc2af632eb985457.ec7cc53448054d67bd738b54435f2502';

    // Jeda acak (detik) antar pesan.
    const JEDA_MIN = 5;
    const JEDA_MAX = 15;

    public $tries = 3;
    public $backoff = 60;

    public function __construct(public string $phone, public string $text)
    {
        $this->onQueue('whatsapp');
    }

    public function handle(): void
    {
        $client = new MessageBuilder([
            'api_url' => self::API_URL,
            'api_key' => self::API_KEY,
        ]);

        $message = $client->to($this->phone)->content($this->text)->save();
        [$delivery, $errors] = $client->send([$message]);

        if ($errors) {
            Log::warning('Gagal kirim WhatsApp', ['phone' => $this->phone, 'errors' => $errors]);
        }

        // Di driver sync (belum pakai worker) jangan menunggu, nanti request
        // presensinya ikut tertahan.
        if ($this->job && $this->job->getConnectionName() !== 'sync') {
            sleep(random_int(self::JEDA_MIN, self::JEDA_MAX));
        }
    }
}
