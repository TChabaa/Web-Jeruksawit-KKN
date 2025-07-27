<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pindah_keluar', function (Blueprint $table) {
            $table->increments('id_detail_pindah');
            $table->unsignedInteger('id_surat');
            $table->string('alamat_tujuan');
            $table->string('alasan_pindah');
            $table->date('tanggal_pindah');
            $table->foreign('id_surat')->references('id_surat')->on('surat')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('detail_pindah_keluar');
    }
};
