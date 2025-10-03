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
    Schema::table('mata_kuliahs', function (Blueprint $table) {
        $table->renameColumn('kode', 'kode_matkul');
        $table->renameColumn('nama', 'nama_matkul');
    });
}

public function down(): void
{
    Schema::table('mata_kuliahs', function (Blueprint $table) {
        $table->renameColumn('kode_matkul', 'kode');
        $table->renameColumn('nama_matkul', 'nama');
    });
}

};
