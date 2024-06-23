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
        Schema::create('permohonan_rekening_transfer', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('bank_id')->nullable()->references('uuid')->on('daftar_bank')->onDelete('cascade');
            $table->foreignUuid('user_id')->references('uuid')->on('users_client')->onDelete('cascade');
            $table->string('norek');
            $table->string('atas_nama');
            $table->integer('status')->default(0)->comment('0 pending 1 terima');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_rekening_transfer');
    }
};
