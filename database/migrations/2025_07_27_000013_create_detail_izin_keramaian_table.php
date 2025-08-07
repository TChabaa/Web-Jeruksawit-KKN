<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_izin_keramaian', function (Blueprint $table) {
            $table->increments('id_detail_izin');
            $table->unsignedInteger('id_surat');
            $table->string('keperluan');
            $table->string('jenis_hiburan');
            $table->string('tempat_acara');
            $table->date('tanggal_acara');
            $table->integer('jumlah_undangan');
            $table->foreign('id_surat')->references('id_surat')->on('surat')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('detail_izin_keramaian');
    }
};
