<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_kematian', function (Blueprint $table) {
            $table->increments('id_detail_kematian');
            $table->unsignedInteger('id_surat');
            $table->string('nama_almarhum');
            $table->string('nik_almarhum');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->integer('umur');
            $table->date('tanggal_kematian');
            $table->string('tempat_kematian');
            $table->string('penyebab_kematian');
            $table->string('hubungan_pelapor');
            $table->foreign('id_surat')->references('id_surat')->on('surat')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('detail_kematian');
    }
};
