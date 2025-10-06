// database/migrations/xxxx_xx_xx_xxxxxx_create_kurikulums_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulums', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kurikulum', 10)->unique();
            $table->string('nama_kurikulum');
            $table->foreignId('prodi_id')->constrained('prodis')->onDelete('cascade');
            $table->year('tahun_berlaku'); // Tahun kurikulum berlaku
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulums');
    }
};