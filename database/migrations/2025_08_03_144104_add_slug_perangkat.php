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
        Schema::table('perangkat_desa', function (Blueprint $table) {
            $table->string('slug', 150)->nullable(false)->after('gambar');
        });
    }

    public function down()
    {
        Schema::table('perangkat_desa', function (Blueprint $table) {
            $table->string('slug', 150)->nullable(false);
        });
    }
};
