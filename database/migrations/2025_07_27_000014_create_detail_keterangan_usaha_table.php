<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_keterangan_usaha', function (Blueprint $table) {
            $table->increments('id_detail_usaha');
            $table->unsignedInteger('id_surat');
            $table->date('mulai_usaha');
            $table->string('jenis_usaha');
            $table->string('alamat_usaha');
            $table->foreign('id_surat')->references('id_surat')->on('surat')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('detail_keterangan_usaha');
    }
};
