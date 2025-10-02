<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::table('mahasiswas', function (Blueprint $table) {
        // solusi 1: biar bisa kosong
        $table->string('tahun_kurikulum')->nullable();

        // ATAU solusi 2: kasih default nilai
        // $table->string('tahun_kurikulum')->default('2023');
    });
}

public function down(): void
{
    Schema::table('mahasiswas', function (Blueprint $table) {
        $table->dropColumn('tahun_kurikulum');
    });
}

};
