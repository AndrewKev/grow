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
        Schema::create('penjualan_laku_cash', function (Blueprint $table) {
            $table->id('id_penjualan_laku_cash');
            $table->foreignId('id_user');
            $table->char('id_distrik');
            $table->foreignId('id_routing');
            $table->foreignId('id_toko');
            $table->char('jenis_kunjungan');
            $table->char('id_produk');
            $table->integer('jumlah_produk');
            $table->foreignId('id_keterangan');
            $table->string('emp');
            $table->foreignId('id_foto');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_distrik')->references('id_distrik')->on('distrik')->onDelete('cascade');
            $table->foreign('id_routing')->references('id_routing')->on('routing')->onDelete('cascade');
            $table->foreign('id_toko')->references('id_toko')->on('toko')->onDelete('cascade');
            // $table->foreign('id_kunjungan')->references('id_kunjungan')->on('jenis_kunjungan')->onDelete('cascade');
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
        Schema::dropIfExists('penjualan_laku_cash');
    }
};
