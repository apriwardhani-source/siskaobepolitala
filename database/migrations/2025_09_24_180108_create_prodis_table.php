<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prodis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_prodi')->unique(); // Misalnya: IF, SI, TI
            $table->string('nama_prodi');          // Misalnya: Informatika, Sistem Informasi, Teknik Informatika
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prodis');
    }
};