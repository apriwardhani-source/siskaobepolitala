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
        Schema::create('dosen_mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // dosen
            $table->string('kode_mk'); // menggunakan kode_mk karena PK MataKuliah adalah kode_mk
            $table->unsignedBigInteger('id_tahun');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliahs')->onDelete('cascade');
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun')->onDelete('cascade');
            
            // Unique constraint: satu dosen tidak bisa mengampu MK yang sama di tahun yang sama 2x
            $table->unique(['user_id', 'kode_mk', 'id_tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_mata_kuliah');
    }
};
