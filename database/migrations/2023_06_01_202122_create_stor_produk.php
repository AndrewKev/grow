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
            $table->char('id_produk');
            $table->datetime('tanggal_stor');
            $table->datetime('tanggal_stor_uang');
            $table->integer('stok_awal');
            $table->integer('terjual');
            $table->integer('sisa_stok');
            $table->integer('harga_produk');
            $table->integer('total_harga');
            // $table->int('stok_kembali');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('products')->onDelete('cascade');
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
