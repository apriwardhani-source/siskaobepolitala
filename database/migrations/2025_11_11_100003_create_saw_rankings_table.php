<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saw_rankings', function (Blueprint $table) {
            $table->id('id_ranking');
            $table->unsignedBigInteger('id_session');
            $table->string('nim');
            $table->string('nama_mahasiswa');
            $table->decimal('total_skor', 10, 6);
            $table->integer('ranking');
            $table->text('detail_perhitungan')->nullable();
            $table->timestamps();
            
            $table->foreign('id_session')->references('id_session')->on('saw_sessions')->onDelete('cascade');
            
            $table->index(['id_session', 'ranking']);
            $table->unique(['id_session', 'nim']); // Prevent duplicate mahasiswa per session
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saw_rankings');
    }
};
