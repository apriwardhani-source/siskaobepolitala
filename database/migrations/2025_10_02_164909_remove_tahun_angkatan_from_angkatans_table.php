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
        $table->dropColumn('tahun_angkatan');
    });
}

public function down(): void
{
    Schema::table('angkatans', function (Blueprint $table) {
        $table->string('tahun_angkatan')->nullable();
    });
}

};
