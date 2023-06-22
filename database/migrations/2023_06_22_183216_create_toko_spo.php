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
        Schema::create('toko_spo', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko')->nullable();
            $table->string('alamat')->nullable();
            $table->string('id_distrik')->nullable();
            $table->char('ws',3)->nullable();
            $table->string('telepon',20)->nullable();
            $table->timestamps();

            $table->foreign('id_distrik')->references('id_distrik')->on('distrik')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toko_spo');
    }
};
