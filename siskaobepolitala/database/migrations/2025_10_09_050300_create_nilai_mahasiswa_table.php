<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_mahasiswa', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->string('nim');
            $table->string('kode_mk');
            $table->unsignedBigInteger('id_teknik');
            $table->unsignedBigInteger('id_cpl')->nullable();
            $table->unsignedBigInteger('id_cpmk')->nullable();
            $table->double('nilai')->default(0);
            $table->unsignedBigInteger('id_tahun');
            $table->timestamps();
            
            $table->foreign('nim')->references('nim')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliahs')->onDelete('cascade');
            $table->foreign('id_teknik')->references('id_teknik')->on('teknik_penilaian')->onDelete('cascade');
            $table->foreign('id_cpl')->references('id_cpl')->on('capaian_profil_lulusans')->onDelete('cascade');
            $table->foreign('id_cpmk')->references('id_cpmk')->on('capaian_pembelajaran_mata_kuliahs')->onDelete('cascade');
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_mahasiswa');
    }
};