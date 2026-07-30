<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            if (!Schema::hasColumn('presensis', 'status_approve')) {
                $table->integer('status_approve')->default(0)->after('status');
            }
            if (!Schema::hasColumn('presensis', 'image')) {
                $table->string('image')->nullable()->after('belanja');
            }
        });
    }

    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->dropColumn(['status_approve', 'image']);
        });
    }
};
