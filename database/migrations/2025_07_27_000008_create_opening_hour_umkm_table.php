<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opening_hour_umkm', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_umkm');
            $table->enum('day', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu']);
            $table->time('open')->nullable();
            $table->time('close')->nullable();
            $table->foreign('id_umkm')->references('id_umkm')->on('umkm')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('opening_hour_umkm');
    }
};
