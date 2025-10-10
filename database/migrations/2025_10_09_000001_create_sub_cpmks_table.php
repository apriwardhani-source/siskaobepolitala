<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sub_cpmks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cpmk_id')->constrained('cpmks')->cascadeOnDelete();
            $table->text('uraian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_cpmks');
    }
};

