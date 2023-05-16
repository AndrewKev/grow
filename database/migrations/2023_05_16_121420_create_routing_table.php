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
        Schema::create('routing', function (Blueprint $table) {
            $table->id('id_routing');
            $table->char('nama_routing', 12);
            $table->char('id_distrik');
            $table->timestamps();

            $table->foreign('id_distrik')->references('id_distrik')->on('distrik')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routing');
    }
};
