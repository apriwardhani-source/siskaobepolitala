<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cpls', function (Blueprint $table) {
            $table->id();
            $table->string('kode_cpl', 10)->unique();
            $table->text('deskripsi');
            $table->decimal('threshold', 5, 2)->default(70.00); // Threshold dalam persen, default 70%
            $table->foreignId('prodi_id')->constrained('prodis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cpls');
    }
};