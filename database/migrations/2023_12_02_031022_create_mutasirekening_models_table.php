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
        Schema::create('mutasi_rekening', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('nasabah_id')->references('uuid')->on('data_nasabah')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('kode');
            $table->text('keterangan');
            $table->double('debit')->default(0);
            $table->double('kredit')->default(0);
            $table->double('saldo')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // DB::statement(
        //     'ALTER TABLE public.mutasi_rekening ALTER COLUMN uuid SET DEFAULT uuid_generate_v4();'
        // );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_rekening');
    }
};
