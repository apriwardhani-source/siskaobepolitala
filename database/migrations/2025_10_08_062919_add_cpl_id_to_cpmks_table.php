<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cpmks', function (Blueprint $table) {
            // tambahkan kolom cpl_id dengan relasi ke tabel cpls
            $table->foreignId('cpl_id')
                  ->nullable()
                  ->constrained('cpls')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('cpmks', function (Blueprint $table) {
            $table->dropForeign(['cpl_id']);
            $table->dropColumn('cpl_id');
        });
    }
};
