<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();
            $table->string('nama_mahasiswa');
            $table->string('kode_prodi');
            $table->unsignedBigInteger('id_tahun_angkatan');
            $table->enum('status', ['aktif', 'lulus', 'cuti', 'keluar'])->default('aktif');
            $table->timestamps();
            
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodis')->onDelete('cascade');
            $table->foreign('id_tahun_angkatan')->references('id_tahun')->on('tahun')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};