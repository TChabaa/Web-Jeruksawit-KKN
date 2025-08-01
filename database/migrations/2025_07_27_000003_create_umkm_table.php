<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkm', function (Blueprint $table) {
            $table->increments('id_umkm');
            $table->string('nama');
            $table->string('alamat');
            $table->string('gmaps_url')->nullable(false);
            $table->text('deskripsi');
            $table->unsignedInteger('created_by');
            $table->timestamps();
            $table->string('slug', 150)->nullable(false);
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
