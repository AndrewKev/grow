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
        Schema::create('rincian_uang', function (Blueprint $table) {
            $table->id('id_rincian_uang');
            $table->foreignId('id_user');
            $table->datetime('tanggal_masuk');
            $table->integer('seratus_ribu');
            $table->integer('lima_puluh_ribu');
            $table->integer('dua_puluh_ribu');
            $table->integer('sepuluh_ribu');
            $table->integer('lima_ribu');
            $table->integer('dua_ribu');
            $table->integer('seribu');
            $table->integer('seribu_koin');
            $table->integer('lima_ratus_koin');
            $table->integer('dua_ratus_koin');
            $table->integer('seratus_koin');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_uang');
    }
};
