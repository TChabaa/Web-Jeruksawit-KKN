<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_skck', function (Blueprint $table) {
            $table->increments('id_detail_skck');
            $table->unsignedInteger('id_surat');
            $table->string('keperluan');
            $table->date('tanggal_mulai_berlaku');
            $table->date('tanggal_akhir_berlaku');
            $table->foreign('id_surat')->references('id_surat')->on('surat')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('detail_skck');
    }
};
