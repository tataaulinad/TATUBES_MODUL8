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
        Schema::create('laporan_insidens', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor');
            $table->string('lokasi_jalan');
            $table->string('kategori_insiden'); // Kemacetan Parah, Kecelakaan, Jalan Rusak, Pohon Tumbang, Lampu Merah Mati, Banjir
            $table->string('tingkat_keparahan'); // Rendah, Sedang, Tinggi, Kritis
            $table->text('keterangan');
            $table->string('kontak_pelapor', 20);
            $table->string('berkas')->nullable();
            $table->string('nama_berkas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_insidens');
    }
};
