// database/migrations/xxxx_xx_xx_xxxxxx_update_mata_kuliahs_table_add_sks_details.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            // Tambahkan kolom sks_teori dan sks_praktikum jika belum ada
            if (!Schema::hasColumn('mata_kuliahs', 'sks_teori')) {
                $table->integer('sks_teori')->default(0)->after('sks');
            }
            if (!Schema::hasColumn('mata_kuliahs', 'sks_praktikum')) {
                $table->integer('sks_praktikum')->default(0)->after('sks_teori');
            }
            // Opsional: Hapus kolom 'sks' lama jika tidak digunakan lagi
            // if (Schema::hasColumn('mata_kuliahs', 'sks')) {
            //     $table->dropColumn('sks');
            // }
        });
    }

    public function down(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            if (Schema::hasColumn('mata_kuliahs', 'sks_praktikum')) {
                $table->dropColumn('sks_praktikum');
            }
            if (Schema::hasColumn('mata_kuliahs', 'sks_teori')) {
                $table->dropColumn('sks_teori');
            }
            // Jika kolom 'sks' dihapus, tambahkan kembali di sini
            // if (!Schema::hasColumn('mata_kuliahs', 'sks')) {
            //     $table->integer('sks')->default(0);
            // }
        });
    }
};