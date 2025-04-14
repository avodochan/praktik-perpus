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
        Schema::create('buku', function (Blueprint $table) {
            $table->string('id_buku')->primary();
            $table->unsignedBigInteger('id_kategori');
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit');
            $table->integer('stok');
            $table->string('cover')->nullable();
            $table->text('sinopsis');
            
            $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('cascade')->nullable();            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
