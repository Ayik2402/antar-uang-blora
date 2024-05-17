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
        Schema::create('biaya_transfer', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->double('nominal')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        // DB::statement(
        //     'ALTER TABLE master.biaya_transfer ALTER COLUMN uuid SET DEFAULT uuid_generate_v4();'
        // );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biaya_transfer');
    }
};
