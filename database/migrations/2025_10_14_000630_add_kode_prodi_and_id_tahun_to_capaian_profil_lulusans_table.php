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
        Schema::table('capaian_profil_lulusans', function (Blueprint $table) {
            $table->string('kode_prodi')->nullable()->after('status_cpl');
            $table->unsignedBigInteger('id_tahun')->nullable()->after('kode_prodi');
            
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodis')->onDelete('cascade');
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('capaian_profil_lulusans', function (Blueprint $table) {
            $table->dropForeign(['kode_prodi']);
            $table->dropForeign(['id_tahun']);
            $table->dropColumn(['kode_prodi', 'id_tahun']);
        });
    }
};
