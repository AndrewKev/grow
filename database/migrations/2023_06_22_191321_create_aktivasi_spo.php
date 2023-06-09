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
        Schema::create('aktivasi_spo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_toko');
            $table->char('aktivasi',3);
            $table->boolean('is_close')->default(0);
            $table->boolean('is_cash')->default(0);
            $table->timestamps();

            // $table->renameColumn('isClose', 'is_close');
            $table->foreign('id_toko')->references('id')->on('toko_spo')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivasi_spo');
    }
};
