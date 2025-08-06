<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('detail_sktm', function (Blueprint $table) {
            $table->decimal('penghasilan', 15, 2)->nullable()->after('pendidikan');
            $table->integer('jumlah_tanggungan')->nullable()->after('penghasilan');
            $table->text('kondisi_ekonomi')->nullable()->after('jumlah_tanggungan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_sktm', function (Blueprint $table) {
            $table->dropColumn(['penghasilan', 'jumlah_tanggungan', 'kondisi_ekonomi']);
        });
    }
};
