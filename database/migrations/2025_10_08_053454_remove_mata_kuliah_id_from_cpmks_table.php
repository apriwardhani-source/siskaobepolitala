<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cpmks', function (Blueprint $table) {
            if (Schema::hasColumn('cpmks', 'mata_kuliah_id')) {
                $table->dropForeign(['mata_kuliah_id']);
                $table->dropColumn('mata_kuliah_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cpmks', function (Blueprint $table) {
            if (!Schema::hasColumn('cpmks', 'mata_kuliah_id')) {
                $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->onDelete('cascade');
            }
        });
    }
};
