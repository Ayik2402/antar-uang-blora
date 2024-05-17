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
        Schema::table('data_nasabah', function (Blueprint $table) {
            $table->text('otp_verifikasi')->nullable();
            $table->datetime('otp_verifikasi_hingga')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_nasabah', function (Blueprint $table) {
            $table->dropColumn('otp_verifikasi');
            $table->dropColumn('otp_verifikasi_hingga');
        });
    }
};
