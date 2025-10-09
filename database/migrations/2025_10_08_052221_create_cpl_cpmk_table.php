<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cpl_cpmk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cpl_id')->constrained('cpls')->onDelete('cascade');
            $table->foreignId('cpmk_id')->constrained('cpmks')->onDelete('cascade');
            $table->timestamps();
        Schema::table('cpmk', function (Blueprint $table) {
    $table->foreignId('cpl_id')->constrained('cpl')->onDelete('cascade');
});

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cpl_cpmk');
    }
};
