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
        Schema::create('toko', function (Blueprint $table) {
            $table->id('id_toko');
            $table->foreignId('id_routing')->nullable();
            $table->char('id_kunjungan')->nullable();
            $table->string('nama_toko')->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->integer('mapping')->nullable();
            $table->timestamps();

            $table->foreign('id_routing')->references('id_routing')->on('routing')->onDelete('cascade');
            $table->foreign('id_kunjungan')->references('id_kunjungan')->on('jenis_kunjungan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toko');
    }
};
