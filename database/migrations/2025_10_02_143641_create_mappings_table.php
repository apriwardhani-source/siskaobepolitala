<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cpl_id')->constrained('cpls')->onDelete('cascade');
            $table->foreignId('cpmk_id')->constrained('cpmks')->onDelete('cascade');
            $table->decimal('bobot', 5, 2); // Bobot kontribusi dalam persen, misal 25.00
            $table->timestamps();

            // Tambahkan constraint unik untuk pasangan CPL-CPMK
            $table->unique(['cpl_id', 'cpmk_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mappings');
    }
};