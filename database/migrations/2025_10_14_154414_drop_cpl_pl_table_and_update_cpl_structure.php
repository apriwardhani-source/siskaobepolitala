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
        // Pastikan kode_prodi dan id_tahun sudah ada dan NOT NULL
        Schema::table('capaian_profil_lulusans', function (Blueprint $table) {
            // Jika kolom masih nullable, ubah menjadi required
            $table->string('kode_prodi')->nullable(false)->change();
            $table->unsignedBigInteger('id_tahun')->nullable(false)->change();
        });

        // Drop tabel pivot cpl_pl karena tidak digunakan lagi
        Schema::dropIfExists('cpl_pl');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate tabel cpl_pl untuk rollback
        Schema::create('cpl_pl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cpl');
            $table->unsignedBigInteger('id_pl');
            $table->timestamps();
            
            $table->foreign('id_cpl')->references('id_cpl')->on('capaian_profil_lulusans')->onDelete('cascade');
            $table->foreign('id_pl')->references('id_pl')->on('profil_lulusans')->onDelete('cascade');
        });

        // Kembalikan kode_prodi dan id_tahun menjadi nullable
        Schema::table('capaian_profil_lulusans', function (Blueprint $table) {
            $table->string('kode_prodi')->nullable()->change();
            $table->unsignedBigInteger('id_tahun')->nullable()->change();
        });
    }
};
