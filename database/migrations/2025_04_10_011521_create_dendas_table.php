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
        Schema::create('denda', function (Blueprint $table) {
            $table->string('id_denda');
            $table->string('id_pinjem');
            $table->string('jenis_denda');
            $table->string('besar_denda');
            $table->timestamps();
            
            $table->foreign('id_pinjem')->references('id_pinjem')->on('peminjaman')->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};
