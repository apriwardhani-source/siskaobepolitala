<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            // drop foreign key dulu
            $table->dropForeign(['angkatan_id']);
            // lalu hapus kolom
            $table->dropColumn('angkatan_id');
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->foreignId('angkatan_id')->constrained('angkatans')->onDelete('cascade');
        });
    }
};
