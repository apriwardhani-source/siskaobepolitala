<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('mata_kuliahs', function (Blueprint $table) {
        if (Schema::hasColumn('mata_kuliahs', 'prodi_id')) {
            $table->dropForeign(['prodi_id']);
            $table->dropColumn('prodi_id');
        }
    });
}

public function down()
{
    Schema::table('mata_kuliahs', function (Blueprint $table) {
        $table->unsignedBigInteger('prodi_id')->nullable();
        $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('cascade');
    });
}

};
