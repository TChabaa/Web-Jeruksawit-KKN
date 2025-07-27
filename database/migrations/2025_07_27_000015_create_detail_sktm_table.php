<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_sktm', function (Blueprint $table) {
            $table->increments('id_detail_sktm');
            $table->unsignedInteger('id_surat');
            $table->string('pendidikan');
            $table->foreign('id_surat')->references('id_surat')->on('surat')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('detail_sktm');
    }
};
