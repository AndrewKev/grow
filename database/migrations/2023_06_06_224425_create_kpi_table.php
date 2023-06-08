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
        Schema::create('kpi', function (Blueprint $table) {
            $table->id('id_kpi');
            $table->foreignId('id_user');
            $table->integer('call_made');
            $table->integer('emp');
            $table->integer('volume');
            $table->integer('io');
            $table->integer('ro');
            $table->integer('roc');
            $table->integer('greenland');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi');
    }
};
