<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_jenjang_to_prodis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom 'jenjang' ke tabel 'prodis'.
     */
    public function up(): void
    {
        Schema::table('prodis', function (Blueprint $table) {
            // Cek apakah kolom 'jenjang' belum ada sebelum menambahkannya
            if (!Schema::hasColumn('prodis', 'jenjang')) {
                // Tambahkan kolom 'jenjang' bertipe ENUM dengan nilai yang diizinkan
                // Gunakan string dengan panjang maksimal jika tidak bisa ENUM
                $table->string('jenjang', 50)->nullable()->after('nama_prodi');
                // Atau jika database mendukung ENUM (SQLite mungkin tidak, MySQL/MariaDB ya):
                // $table->enum('jenjang', ['Diploma 3', 'Diploma 4', 'S1', 'S2', 'S3'])->nullable()->after('nama_prodi');
            }
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus kolom 'jenjang' dari tabel 'prodis'.
     */
    public function down(): void
    {
        Schema::table('prodis', function (Blueprint $table) {
            // Cek apakah kolom 'jenjang' ada sebelum menghapusnya
            if (Schema::hasColumn('prodis', 'jenjang')) {
                $table->dropColumn('jenjang');
            }
        });
    }
};