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
        Schema::create('master.daftar_bank', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('bank');
            $table->integer('status')->default(1)->comment('0 INACTIVE 1 ACTIVE');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement(
            'ALTER TABLE master.daftar_bank ALTER COLUMN uuid SET DEFAULT uuid_generate_v4();'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master.daftar_bank');
    }
};
