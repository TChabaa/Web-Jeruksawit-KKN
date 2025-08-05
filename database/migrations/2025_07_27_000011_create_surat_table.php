<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->increments('id_surat');
            $table->unsignedInteger('id_pemohon');
            $table->unsignedInteger('id_jenis');
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->unsignedInteger('created_by');
            $table->enum('status', ['belum_diverifikasi', 'disetujui', 'ditolak'])->default('belum_diverifikasi');
            $table->timestamps();
            $table->foreign('id_pemohon')->references('id_pemohon')->on('pemohon')->cascadeOnDelete();
            $table->foreign('id_jenis')->references('id_jenis')->on('jenis_surat')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
