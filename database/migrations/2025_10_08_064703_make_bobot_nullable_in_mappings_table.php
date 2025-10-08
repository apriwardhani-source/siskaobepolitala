<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mappings', function (Blueprint $table) {
            $table->decimal('bobot', 5, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('mappings', function (Blueprint $table) {
            $table->decimal('bobot', 5, 2)->nullable(false)->change();
        });
    }
};
