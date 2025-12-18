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
        // Untuk SQLite, kita perlu drop foreign key dulu
        Schema::table('prodis', function (Blueprint $table) {
            $table->dropForeign(['id_jurusan']);
        });
        
        // Kemudian drop column
        Schema::table('prodis', function (Blueprint $table) {
            $table->dropColumn('id_jurusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prodis', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jurusan')->nullable();
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusans')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
