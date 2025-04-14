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
        Schema::create('member', function (Blueprint $table) {
            $table->string('id_member')->primary();
            $table->unsignedBigInteger(('id_user'));
            $table->string('nama');
            $table->string('email')->unique();
            $table->text('alamat');
            $table->string('no_tlp');
            
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
