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
    $table->string('nama');
    $table->string('tahun_kurikulum');
    $table->foreignId('prodi_id')->constrained('prodis')->onDelete('cascade');
    $table->timestamps();
});


    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
