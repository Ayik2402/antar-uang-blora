<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfer_antar_rekening', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('nasabah_id')->references('uuid')->on('data_nasabah')->onDelete('cascade');
            $table->text('rekening_tujuan');
            $table->double('nominal')->default(0);
            $table->integer('status_transaksi')->default(1)->comment('1 PENDING 2 SUKSES 3 BATAL');
            $table->text('kode_otp')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // DB::statement(
        //     'ALTER TABLE public.transfer_antar_rekening ALTER COLUMN uuid SET DEFAULT uuid_generate_v4();'
        // );

        Schema::table('data_nasabah', function (Blueprint $table) {
            // $table->text('bukti_lembur')->nullable();
            $table->foreignUuid('user_id')->nullable()->references('uuid')->on('users_client')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_antar_rekening');

        Schema::table('data_nasabah', function (Blueprint $table) {
            // $table->dropColumn('bukti_lembur');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
