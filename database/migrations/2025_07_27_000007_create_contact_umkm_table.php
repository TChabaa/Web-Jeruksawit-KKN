<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_umkm', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_umkm');
            $table->string('nomor', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('sosial_media', 100)->nullable();
            $table->foreign('id_umkm')->references('id_umkm')->on('umkm')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('contact_umkm');
    }
};
