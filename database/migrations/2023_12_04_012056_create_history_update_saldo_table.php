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
        Schema::create('history_update_saldo', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0)->comment('0:Import;1:Manual;');
            $table->datetime('waktu');
            $table->uuid('updater');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_update_saldo');
    }
};
