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
        Schema::create('transfer_antar_bank', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('nasabah_id')->references('uuid')->on('data_nasabah')->onDelete('cascade');
            $table->foreignUuid('bank_id')->references('uuid')->on('daftar_bank')->onDelete('cascade');
            $table->text('rekening_tujuan');
            $table->text('rekening_penerima');
            $table->double('nominal')->default(0);
            $table->double('biaya')->default(0);
            $table->double('jumlah')->default(0);
            $table->integer('status_transaksi')->default(1)->comment('1 PENDING 2 SUKSES 3 BATAL');
            $table->text('kode_otp')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // DB::statement(
        //     'ALTER TABLE public.transfer_antar_bank ALTER COLUMN uuid SET DEFAULT uuid_generate_v4();'
        // );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_antar_bank');
    }
};
