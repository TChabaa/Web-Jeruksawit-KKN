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
        Schema::table('detail_kelahiran', function (Blueprint $table) {
            $table->string('ibu')->after('penolong_kelahiran'); // Menambahkan kolom ibu
            $table->string('ayah')->after('ibu'); // Menambahkan kolom ayah
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_kelahiran', function (Blueprint $table) {
            $table->dropColumn('ibu');
            $table->dropColumn('ayah');
        });
    }
};
