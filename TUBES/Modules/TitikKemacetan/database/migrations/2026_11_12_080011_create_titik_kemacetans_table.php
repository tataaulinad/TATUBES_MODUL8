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
        Schema::create('titik_kemacetans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jalan');
            $table->string('wilayah');
            $table->string('kondisi_lalin'); // Lancar, Ramai Lancar, Padat Merayap, Macet Total
            $table->integer('kecepatan_rata_rata'); // km/jam
            $table->integer('panjang_antrian'); // meter
            $table->string('penyebab');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titik_kemacetans');
    }
};
