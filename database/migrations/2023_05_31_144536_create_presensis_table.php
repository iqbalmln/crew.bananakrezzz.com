<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->nullable();
            $table->foreignId('store_id')->nullable();
            $table->foreignId('marketing_id')->nullable();
           // $table->string('nomor');
            $table->string('waktu');
            $table->string('tgl');
            $table->string('status');
            $table->integer('status_approve')->default('0');
            $table->string('po')->default('-');
            $table->string('biro')->default('-');
            $table->string('bus')->default('-');
            $table->string('ket')->default('-');
            $table->string('belanja')->nullable();
            $table->boolean('reward')->default(0);
            $table->string('fee')->nullable();
            $table->string('kode_hari')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
