<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saw_nilai_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_session');
            $table->string('nim');
            $table->string('nama_mahasiswa');
            $table->string('kode_mk');
            $table->decimal('nilai', 5, 2);
            $table->timestamps();
            
            $table->foreign('id_session')->references('id_session')->on('saw_sessions')->onDelete('cascade');
            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliahs')->onDelete('cascade');
            
            $table->index(['id_session', 'nim']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saw_nilai_mahasiswa');
    }
};
