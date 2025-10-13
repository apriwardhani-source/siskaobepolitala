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
        Schema::table('sub_cpmks', function (Blueprint $table) {
            $table->string('kode_mk')->nullable(); // Add kode_mk column
            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_cpmks', function (Blueprint $table) {
            $table->dropForeign(['kode_mk']); // Drop foreign key first
            $table->dropColumn('kode_mk'); // Then drop the column
        });
    }
};
