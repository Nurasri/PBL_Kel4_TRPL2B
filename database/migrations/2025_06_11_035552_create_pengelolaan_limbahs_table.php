<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengelolaan_limbahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perusahaan_id')->constrained('perusahaans')->onDelete('cascade');
            $table->foreignId('laporan_harian_id')->constrained('laporan_harians')->onDelete('cascade');
            $table->foreignId('penyimpanan_id')->constrained('penyimpanans')->onDelete('cascade');
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->onDelete('set null');
            
            $table->decimal('jumlah_dikelola', 10, 2);
            $table->string('satuan', 20);
            $table->enum('jenis_pengelolaan', ['internal', 'vendor_eksternal', 'disposal', 'recycling']);
            $table->enum('status', ['diproses', 'dalam_pengangkutan', 'selesai', 'dibatalkan'])->default('diproses');
            
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->decimal('biaya', 12, 2)->nullable();
            $table->string('nomor_manifest')->nullable();
            $table->text('catatan')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['perusahaan_id', 'status']);
            $table->index(['tanggal_mulai']);
            $table->index(['jenis_pengelolaan']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengelolaan_limbahs');
    }
};
