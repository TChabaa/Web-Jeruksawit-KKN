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
    Schema::table('umkm', function (Blueprint $table) {
        $table->integer('views')->default(0)->after('deskripsi');
    });
}

public function down()
{
    Schema::table('umkm', function (Blueprint $table) {
        $table->dropColumn('views');
    });
}
};
