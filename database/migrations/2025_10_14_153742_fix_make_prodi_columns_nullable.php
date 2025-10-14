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
        Schema::table('prodis', function (Blueprint $table) {
            // Membuat kolom-kolom yang tidak wajib menjadi nullable
            $table->text('visi_prodi')->nullable()->change();
            $table->date('tgl_berdiri_prodi')->nullable()->change();
            $table->date('penyelenggaraan_prodi')->nullable()->change();
            $table->string('nomor_sk')->nullable()->change();
            $table->date('tanggal_sk')->nullable()->change();
            $table->string('nomor_sk_banpt')->nullable()->change();
            $table->string('gelar_lulusan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prodis', function (Blueprint $table) {
            // Kembalikan menjadi NOT NULL (hanya untuk rollback)
            $table->text('visi_prodi')->nullable(false)->change();
            $table->date('tgl_berdiri_prodi')->nullable(false)->change();
            $table->date('penyelenggaraan_prodi')->nullable(false)->change();
            $table->string('nomor_sk')->nullable(false)->change();
            $table->date('tanggal_sk')->nullable(false)->change();
            $table->string('nomor_sk_banpt')->nullable(false)->change();
            $table->string('gelar_lulusan')->nullable(false)->change();
        });
    }
};
