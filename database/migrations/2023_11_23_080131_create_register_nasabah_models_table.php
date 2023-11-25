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
        Schema::create('public.data_nasabah', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('tabungan_id')->references('uuid')->on('master.jenis_tabungan')->onDelete('cascade');
            $table->text('noregister')->nullable();
            $table->string('norek')->nullable();
            $table->string('nama');
            $table->string('email');
            $table->text('no_hp');
            $table->integer('type_nasabah')->default(0)->comment('0 LAMA 1 BARU');
            $table->integer('aktivasi')->default(0)->comment('0 BELUM AKTIVASI 1 SUDAH AKTIVASI 2 AKUN DITANGGUHKAN 3 DIBLOKIR');
            $table->text('alamat_ktp');
            $table->text('alamat_domisili')->nullable();
            $table->integer('same_domisili')->default(0)->comment('0 TIDAK SAMA 1 SAMA DENGAN KTP');
            $table->text('tag_bpr')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement(
            'ALTER TABLE public.data_nasabah ALTER COLUMN uuid SET DEFAULT uuid_generate_v4();'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.data_nasabah');
    }
};
