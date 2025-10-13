<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skor_cpl_mahasiswa', function (Blueprint $table) {
            $table->id('id_skor');
            $table->string('nim');
            $table->unsignedBigInteger('id_cpl');
            $table->unsignedBigInteger('id_tahun');
            $table->double('skor')->default(0);
            $table->timestamps();
            
            $table->foreign('nim')->references('nim')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('id_cpl')->references('id_cpl')->on('capaian_profil_lulusans')->onDelete('cascade');
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skor_cpl_mahasiswa');
    }
};