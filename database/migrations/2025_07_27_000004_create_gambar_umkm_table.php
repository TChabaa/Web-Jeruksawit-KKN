<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gambar_umkm', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_umkm')->nullable(false);
            $table->string('image_url')->nullable(false);
            $table->timestamps();
            $table->foreign('id_umkm')->references('id_umkm')->on('umkm')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('gambar_umkm');
    }
};
