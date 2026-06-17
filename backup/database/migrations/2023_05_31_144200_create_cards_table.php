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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('nomor');
            $table->string('nik')->nullable();
            $table->string('nama')->nullable();
            $table->string('asal')->nullable();
            $table->string('hp')->nullable();
            $table->string('email')->nullable();
            $table->string('jk')->nullable();
            $table->string('po')->nullable();
            $table->foreignId('level')->default('1');
            // $table->boolean('reward')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
