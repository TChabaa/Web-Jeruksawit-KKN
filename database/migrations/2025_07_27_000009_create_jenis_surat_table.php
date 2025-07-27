<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_surat', function (Blueprint $table) {
            $table->increments('id_jenis');
            $table->string('nama_jenis');
            $table->text('deskripsi')->nullable();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('jenis_surat');
    }
};
