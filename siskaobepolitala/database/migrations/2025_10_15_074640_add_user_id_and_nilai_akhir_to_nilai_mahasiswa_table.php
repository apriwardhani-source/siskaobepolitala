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
        Schema::table('nilai_mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('nilai'); // dosen yang input nilai
            $table->double('nilai_akhir')->nullable()->after('nilai'); // nilai akhir mahasiswa
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'nilai_akhir']);
        });
    }
};
