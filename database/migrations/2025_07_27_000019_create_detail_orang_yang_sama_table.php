<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_orang_yang_sama', function (Blueprint $table) {
            $table->increments('id_detail_orang_sama');
            $table->unsignedInteger('id_surat');
            $table->string('nama_2');
            $table->string('tempat_lahir_2');
            $table->date('tanggal_lahir_2');
            $table->string('nama_ayah_2');
            $table->string('dasar_dokumen_1');
            $table->string('dasar_dokumen_2');
            $table->foreign('id_surat')->references('id_surat')->on('surat')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('detail_orang_yang_sama');
    }
};
