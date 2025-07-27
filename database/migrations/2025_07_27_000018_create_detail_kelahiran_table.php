<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_kelahiran', function (Blueprint $table) {
            $table->increments('id_detail_kelahiran');
            $table->unsignedInteger('id_surat');
            $table->string('nama_anak');
            $table->enum('jenis_kelamin_anak', ['L', 'P']);
            $table->string('hari_lahir');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->string('penolong_kelahiran');
            $table->foreign('id_surat')->references('id_surat')->on('surat')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('detail_kelahiran');
    }
};
