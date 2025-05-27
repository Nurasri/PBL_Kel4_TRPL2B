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
    Schema::create('laporan_harians', function (Blueprint $table) {
        $table->id();
        $table->foreignId('perusahaan_id')->constrained('perusahaans')->onDelete('cascade');
        $table->date('tanggal');
        $table->string('jenis_limbah');
        $table->float('jumlah');
        $table->string('lokasi');
        $table->string('status');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_harians');
    }
};
