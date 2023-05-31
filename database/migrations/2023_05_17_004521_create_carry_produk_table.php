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
        Schema::create('carry_produk', function (Blueprint $table) {
            $table->foreignId('id_user');
            $table->char('id_produk');
            $table->datetime('tanggal_carry');
            $table->integer('stok_awal');
            $table->integer('stok_sekarang');
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
        Schema::dropIfExists('carry_produk');
    }
};
