<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            // Hapus constraint foreign key kalau ada
            if (Schema::hasColumn('mata_kuliahs', 'dosen_id')) {
                $table->dropForeign(['dosen_id']);
                $table->dropColumn('dosen_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            if (!Schema::hasColumn('mata_kuliahs', 'dosen_id')) {
                $table->foreignId('dosen_id')
                      ->nullable()
                      ->constrained('dosens')
                      ->nullOnDelete();
            }
        });
    }
};
