<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gambar_kegiatan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_kegiatan')->nullable(false);
            $table->string('image_url')->nullable(false);
            $table->timestamps();
            $table->foreign('id_kegiatan')->references('id_kegiatan')->on('kegiatan_rutin')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('gambar_kegiatan');
    }
};
