<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_pindah', function (Blueprint $table) {
            $table->increments('id_anggota_pindah');
            $table->unsignedInteger('id_detail_pindah');
            $table->unsignedInteger('id_pemohon');
            $table->string('shdk');
            $table->foreign('id_detail_pindah')->references('id_detail_pindah')->on('detail_pindah_keluar')->cascadeOnDelete();
            $table->foreign('id_pemohon')->references('id_pemohon')->on('pemohon')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('anggota_pindah');
    }
};
