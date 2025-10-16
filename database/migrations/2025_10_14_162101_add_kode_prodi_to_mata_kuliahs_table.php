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
            $table->string('kode_prodi', 20)->nullable()->after('kode_mk');
            $table->foreign('kode_prodi')->references('kode_prodi')->on('prodis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropForeign(['kode_prodi']);
            $table->dropColumn('kode_prodi');
        });
    }
};
