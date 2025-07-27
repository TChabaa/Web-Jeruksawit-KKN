<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_domisili_instansi', function (Blueprint $table) {
            $table->increments('id_detail_domisili_instansi');
            $table->unsignedInteger('id_surat');
            $table->string('nama_instansi');
            $table->string('nama_pimpinan');
            $table->string('nip_pimpinan')->nullable();
            $table->string('email_pimpinan')->nullable();
            $table->string('alamat_instansi');
            $table->string('keterangan_lokasi')->nullable();
            $table->foreign('id_surat')->references('id_surat')->on('surat')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('detail_domisili_instansi');
    }
};
