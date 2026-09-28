<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * presensis.belanja menyimpan nominal rupiah tapi bertipe varchar(255), jadi
     * teks apa pun bisa masuk ("NABARU", "B12", "JEPARA"). Akibatnya:
     *   - number_format() melempar TypeError di PHP 8 dan menjatuhkan halaman
     *   - sum('belanja') untuk perhitungan reward ikut salah
     *
     * ALTER dipakai langsung, bukan $table->change(), karena proyek ini Laravel 10
     * tanpa doctrine/dbal.
     */
    public function up(): void
    {
        // Urutannya wajib: bersihkan dulu, baru ubah tipe. Dengan STRICT_TRANS_TABLES
        // aktif, ALTER akan menolak seluruh tabel kalau masih ada baris tak valid.

        // Titik di kolom ini SELALU pemisah ribuan gaya Indonesia ("700.000" =
        // tujuh ratus ribu) atau titik nyasar di akhir ("25000."), tidak pernah
        // desimal — tidak ada satu pun nilai berkoma di tabel ini, dan nominalnya
        // selalu rupiah bulat. Jadi membuang semua titik memulihkan angka aslinya.
        // Tanpa langkah ini, CAST ke BIGINT memotong "700.000" menjadi 700.
        DB::statement("
            UPDATE presensis
               SET belanja = REPLACE(belanja, '.', '')
             WHERE belanja REGEXP '^[0-9]+([.][0-9]*)+$'
        ");

        // Sisanya ("JEPARA", "B12", "b12", "NABARU") tidak memuat angka sama sekali
        // dan tidak bisa dipulihkan. NULL, bukan 0: "tidak tercatat" tidak boleh
        // tertukar dengan "belanja nol rupiah" pada laporan maupun SUM().
        DB::statement("
            UPDATE presensis
               SET belanja = NULL
             WHERE belanja IS NOT NULL
               AND belanja NOT REGEXP '^[0-9]+$'
        ");

        DB::statement('ALTER TABLE presensis MODIFY belanja BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        // Tipe bisa dikembalikan, tapi nilai yang sudah jadi NULL di up() tidak.
        DB::statement('ALTER TABLE presensis MODIFY belanja VARCHAR(255) NULL');
    }
};
