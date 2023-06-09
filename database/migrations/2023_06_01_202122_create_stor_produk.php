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
        Schema::create('stor_produk', function (Blueprint $table) {
            $table->foreignId('id_user');
            $table->char('id_produk')->nullable();
            $table->datetime('tanggal_stor_barang')->nullable();
            $table->datetime('tanggal_stor_uang')->nullable();
            $table->integer('stok_awal')->nullable();
            $table->integer('terjual')->nullable();
            $table->integer('sisa_stok')->nullable();
            $table->integer('harga_produk')->nullable();
            $table->integer('total_harga')->nullable();
            $table->foreignId('id_rincian_uang')->nullable();
            // $table->int('stok_kembali');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('products')->onDelete('cascade');
            $table->foreign('id_rincian_uang')->references('id_rincian_uang')->on('rincian_uang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stor_produk');
    }
};
