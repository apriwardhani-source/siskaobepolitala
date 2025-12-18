<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teknik_penilaian', function (Blueprint $table) {
            $table->id('id_teknik');
            $table->string('nama_teknik'); // UTS, UAS, Tugas, dll
            $table->string('kode_mk');
            $table->unsignedBigInteger('id_cpl')->nullable();
            $table->unsignedBigInteger('id_cpmk')->nullable();
            $table->integer('bobot')->default(0);
            $table->unsignedBigInteger('id_tahun');
            $table->timestamps();
            
            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliahs')->onDelete('cascade');
            $table->foreign('id_cpl')->references('id_cpl')->on('capaian_profil_lulusans')->onDelete('cascade');
            $table->foreign('id_cpmk')->references('id_cpmk')->on('capaian_pembelajaran_mata_kuliahs')->onDelete('cascade');
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teknik_penilaian');
    }
};