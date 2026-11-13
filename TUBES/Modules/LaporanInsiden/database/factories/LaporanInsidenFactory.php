<?php

namespace Modules\LaporanInsiden\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\LaporanInsiden\Models\LaporanInsiden;

/**
 * @extends Factory<LaporanInsiden>
 */
class LaporanInsidenFactory extends Factory
{
    protected $model = LaporanInsiden::class;

    public function definition(): array
    {
        return [
            'nama_pelapor' => fake()->name(),
            'lokasi_jalan' => fake()->randomElement([
                'Jl. Dr. Djunjunan No. 143',
                'Jl. Pasirkaliki Depan Stasiun',
                'Jl. Soekarno Hatta KM 9',
                'Jl. Surya Sumantri',
                'Jl. LLRE Martadinata',
            ]),
            'kategori_insiden' => fake()->randomElement(['Kemacetan Parah', 'Kecelakaan Lalu Lintas', 'Pohon Tumbang', 'Jalan Berlubang', 'Lampu Merah Mati']),
            'tingkat_keparahan' => fake()->randomElement(['Rendah', 'Sedang', 'Tinggi', 'Kritis']),
            'keterangan' => fake()->sentence(8),
            'kontak_pelapor' => fake()->numerify('08##########'),
        ];
    }
}
