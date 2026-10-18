<?php

namespace App\Support;

/**
 * Template pesan WhatsApp. Tiap jenis punya beberapa versi yang dipilih acak,
 * supaya isi pesan tidak identik terus (pesan kembar beruntun gampang dianggap
 * spam oleh WhatsApp). "&#13;" = baris baru di OneSender.
 */
class WaTemplate
{
    public static function presensi(?string $nama, ?string $store, string $tgl, string $waktu): string
    {
        $sapa = $nama ? " $nama" : '';

        return self::pilih([
            "Presensi panjenengan sampun kasil! &#13;&#13;Wonten ing $store &#13;Tanggal : $tgl &#13;Wekdal : $waktu &#13;&#13;Matur Suwun sampun pinarak Kampoeng Banana Krezzz🙏🏻☺️",
            "Sugeng rawuh$sapa! 🙏🏻 &#13;Presensi panjenengan sampun kacathet. &#13;&#13;• Panggenan : $store &#13;• Tanggal : $tgl &#13;• Wekdal : $waktu &#13;&#13;Matur Suwun sampun mampir Kampoeng Banana Krezzz ☺️",
            "Matur Suwun$sapa, presensi sampun kasil kacathet ✅ &#13;&#13;$store &#13;$tgl, wekdal $waktu &#13;&#13;Mugi lancar perjalananipun, dipuntenggo rawuhipun malih wonten Kampoeng Banana Krezzz🙏🏻",
        ]);
    }

    public static function kedatangan(?string $rombongan, string $tgl): string
    {
        return self::pilih([
            "Sugeng Rawuh Dhateng Kampoeng Banana Krezzz Cabang (x) &#13;&#13;• Rombongan : $rombongan &#13;• Tabuh : $tgl &#13;&#13;Matur Suwun sampun pinarak Kampoeng Banana Krezzz🙏🏻☺️",
            "Sugeng rawuh rombongan $rombongan 🙏🏻 &#13;&#13;Kunjungan tanggal $tgl sampun kacathet wonten Kampoeng Banana Krezzz Cabang (x). &#13;&#13;Matur Suwun sampun pinarak ☺️",
            "Matur Suwun sampun pinarak Kampoeng Banana Krezzz Cabang (x) 🙏🏻 &#13;&#13;• Rombongan : $rombongan &#13;• Tanggal : $tgl &#13;&#13;Mugi lancar perjalananipun ☺️",
        ]);
    }

    public static function klaimReward(): string
    {
        return self::pilih([
            "Klaim absensi panjenengan sampun sukses! &#13;Wonten ing Kampoeng Banana Krezzz Cabang (×) &#13;&#13;Matur Suwun, &#13;Dipuntenggo karawuhan saklajengipun🙏🏻☺️",
            "Reward panjenengan sampun kasil diklaim ✅ &#13;Wonten ing Kampoeng Banana Krezzz Cabang (×) &#13;&#13;Matur Suwun, dipuntenggo rawuhipun malih🙏🏻",
            "Selamat, klaim absensi sampun sukses! 🎉 &#13;Kampoeng Banana Krezzz Cabang (×) &#13;&#13;Matur Suwun sampun setia pinarak, dipuntenggo karawuhan saklajengipun☺️",
        ]);
    }

    private static function pilih(array $versi): string
    {
        return $versi[array_rand($versi)];
    }
}
