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
        Schema::create('request_sales', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('id_user');
            $table->char('id_produk');
            $table->integer('jumlah');
            $table->date('tanggal_request');
            $table->boolean('konfirmasi');
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
        Schema::dropIfExists('request_sales');
    }
};
