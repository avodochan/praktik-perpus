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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->string('id_pinjem')->primary();
            $table->string('id_buku')->nullable(); 
            $table->string('id_member')->nullable();
            $table->datetime('tgl_pinjam');
            $table->datetime('tgl_kembali')->nullable();
            
            $table->foreign('id_buku')->references('id_buku')->on('buku')->onDelete('cascade');   
            $table->foreign('id_member')->references('id_member')->on('member')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
