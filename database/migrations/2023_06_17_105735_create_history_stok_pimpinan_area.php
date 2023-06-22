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
        Schema::create('history_stok_pimpinan_area', function (Blueprint $table) {
            $table->id();
            $table->string('nama_admin');
            $table->string('nama_produk');
            $table->integer('req_stok');
            $table->integer('harga_stok');
            $table->string('catatan');
            $table->string('catatan_pim_area')->nullable();
            $table->boolean('konfirmasi');
            $table->boolean('konfirmasi2')->nullable();
            $table->boolean('konfirmasi3')->nullable();
            $table->date('tanggal');
            $table->datetime('tanggal_po');
            $table->date('deadline_kirim');
            $table->datetime('tanggal_konfirm')->nullable();
            $table->datetime('tanggal_konfirm2')->nullable();
            $table->datetime('tanggal_konfirm3')->nullable();
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_stok_pimpinan_area');
    }
};
