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
    Schema::table('angkatans', function (Blueprint $table) {
        // Hapus kolom prodi lama
        if (Schema::hasColumn('angkatans', 'prodi_id')) {
            $table->dropForeign(['prodi_id']);
            $table->dropColumn('prodi_id');
        }

        // Tambahkan kolom matkul_id tapi boleh null dulu
        $table->foreignId('matkul_id')->nullable()->constrained('mata_kuliahs')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('angkatans', function (Blueprint $table) {
            //
        });
    }
};
