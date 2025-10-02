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
        Schema::create('matakuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // contoh: IF101
            $table->string('nama');           // nama mata kuliah
            $table->unsignedTinyInteger('sks'); // jumlah SKS (biasanya 1–6)

            // relasi ke tabel dosens (pastikan tabel dosens sudah ada)
            $table->foreignId('dosen_id')
                  ->nullable()
                  ->constrained('dosens')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matakuliahs');
    }
};
