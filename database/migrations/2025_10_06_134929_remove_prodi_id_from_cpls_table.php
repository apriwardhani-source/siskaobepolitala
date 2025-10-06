<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cpls', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']); // hapus foreign key
            $table->dropColumn('prodi_id');    // hapus kolom
        });
    }

    public function down(): void
    {
        Schema::table('cpls', function (Blueprint $table) {
            $table->foreignId('prodi_id')->constrained('prodis')->onDelete('cascade');
        });
    }
};
