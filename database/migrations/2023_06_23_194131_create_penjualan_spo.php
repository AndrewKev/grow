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
        Schema::create('penjualan_spo', function (Blueprint $table) {
            $table->id('id_penjualan_spo');
            $table->foreignId('id_user');
            $table->char('id_distrik');
            $table->foreignId('id_toko');
            $table->char('jenis_spo')->nullable();
            $table->string('nomor_spo')->nullable();
            $table->char('id_produk')->nullable();
            $table->integer('jumlah_produk')->nullable();
            $table->foreignId('id_keterangan')->nullable();
            $table->string('emp')->nullable();
            $table->foreignId('id_foto')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_distrik')->references('id_distrik')->on('distrik')->onDelete('cascade');
            $table->foreign('id_toko')->references('id')->on('toko_spo')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('products')->onDelete('cascade');
            $table->foreign('id_keterangan')->references('id_keterangan')->on('keterangan')->onDelete('cascade');
            $table->foreign('id_foto')->references('id_foto')->on('foto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_spo');
    }
};
