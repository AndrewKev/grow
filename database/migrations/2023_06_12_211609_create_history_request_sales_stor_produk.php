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
        Schema::create('history_request_sales_stor_produk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_sales');
            $table->string('nama_produk');
            $table->integer('stok_awal');
            $table->integer('terjual');
            $table->integer('sisa_stok');
            $table->boolean('konfirmasi_admin');  // => 0
            $table->string('keterangan'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_request_sales_stor_produk');
    }
};
