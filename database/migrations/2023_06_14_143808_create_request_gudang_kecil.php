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
        Schema::create('request_gudang_kecil', function (Blueprint $table) {
            $table->foreignId('id_user');
            $table->char('id_produk');
            $table->date('tanggal_po')->nullable();
            $table->integer('stok');
            $table->integer('sample')->nullable();
            $table->integer('harga_stok');
            $table->date('deadline_kirim')->nullable();
            $table->string('catatan')->nullable();
            $table->string('catatan_pim_area')->nullable();
            $table->boolean('konfirmasi');
            $table->datetime('tgl_konfirmasi')->nullable();
            $table->boolean('konfirmasi2')->nullable();
            $table->datetime('tgl_konfirmasi2')->nullable();
            $table->boolean('konfirmasi3')->nullable();
            $table->datetime('tgl_konfirmasi3')->nullable();
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
        Schema::dropIfExists('request_gudang_kecil');
    }
};
