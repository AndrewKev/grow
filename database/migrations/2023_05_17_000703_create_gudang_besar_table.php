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
        Schema::create('gudang_besar', function (Blueprint $table) {
            $table->char('id_produk');
            $table->integer('stok');
            $table->integer('sample')->nullable();
            $table->integer('harga_stok');
            $table->integer('retur')->nullable();
            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudang_besar');
    }
};
