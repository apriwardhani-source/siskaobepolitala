<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saw_sessions', function (Blueprint $table) {
            $table->id('id_session');
            $table->string('kode_prodi');
            $table->unsignedBigInteger('id_tahun')->nullable();
            $table->string('judul');
            $table->unsignedBigInteger('uploaded_by');
            $table->integer('total_mahasiswa')->default(0);
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->timestamps();
            
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodis')->onDelete('cascade');
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun')->onDelete('set null');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saw_sessions');
    }
};
