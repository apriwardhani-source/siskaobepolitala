<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            if (!Schema::hasColumn('mata_kuliahs', 'prodi_id')) {
                $table->foreignId('prodi_id')
                      ->after('sks')
                      ->constrained('prodis')
                      ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            if (Schema::hasColumn('mata_kuliahs', 'prodi_id')) {
                $table->dropForeign(['prodi_id']);
                $table->dropColumn('prodi_id');
            }
        });
    }
};
