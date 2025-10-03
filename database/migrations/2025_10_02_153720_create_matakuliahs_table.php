<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) { // ✅ konsisten pakai underscore
            $table->id();
            $table->string('kode_matkul')->unique();   // contoh: IF101
            $table->string('nama_matkul');             // nama mata kuliah
            $table->unsignedTinyInteger('sks');        // jumlah SKS (1–6)

            // relasi ke tabel prodi
            $table->foreignId('prodi_id')
                  ->constrained('prodis')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
    }
};
