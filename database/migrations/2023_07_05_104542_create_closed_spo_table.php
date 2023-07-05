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
        Schema::create('closed_spo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user');
            $table->char('id_produk');
            $table->foreignId('id_aktivasi');
            $table->date('tanggal_close_spo');
            $table->integer('jumlah_produk');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('products')->onDelete('cascade');
            $table->foreign('id_aktivasi')->references('id')->on('aktivasi_spo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closed_spo');
    }
};
