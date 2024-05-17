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
        Schema::create('saldo_nasabah', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->text('no_rekening');
            $table->uuid('nasabah_id');
            $table->datetime('last_update');
            $table->double('saldo');
            $table->double('mengendap')->nullable();
            $table->uuid('updater');
            $table->timestamps();
        });
        // DB::statement(
        //     'ALTER TABLE saldo_nasabah ALTER COLUMN uuid SET DEFAULT uuid_generate_v4();'
        // );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldo_nasabah');
    }
};
