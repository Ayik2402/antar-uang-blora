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
        Schema::create('public.token_send_email', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('nasabah_id')->references('uuid')->on('public.data_nasabah')->onDelete('cascade');
            $table->text('token');
            $table->dateTime('hingga');
            $table->timestamps();
        });

        DB::statement(
            'ALTER TABLE public.token_send_email ALTER COLUMN uuid SET DEFAULT uuid_generate_v4();'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public.token_send_email');
    }
};
