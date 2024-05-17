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
        Schema::create('users_client', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('nasabah_id')->nullable()->references('uuid')->on('data_nasabah')->onDelete('cascade');
            $table->string('name');
            $table->string('otp')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->dateTime('otp_aktif')->nullable();
            $table->text('tokenhash')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // DB::statement(
        //     'ALTER TABLE public.users_client ALTER COLUMN uuid SET DEFAULT uuid_generate_v4();'
        // );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_client');
    }
};
