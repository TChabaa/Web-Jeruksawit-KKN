<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_domisili_kelompok', function (Blueprint $table) {
            $table->increments('id_detail_domisili_kelompok');
            $table->unsignedInteger('id_surat');
            $table->string('nama_kelompok');
            $table->string('email_ketua')->nullable();
            $table->string('alamat_kelompok');
            $table->string('ketua');
            $table->string('sekretaris');
            $table->string('bendahara');
            $table->string('keterangan_lokasi')->nullable();
            $table->foreign('id_surat')->references('id_surat')->on('surat')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('detail_domisili_kelompok');
    }
};
