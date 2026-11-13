<?php

namespace Modules\TitikKemacetan\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TitikKemacetan\Models\TitikKemacetan;

/**
 * @extends Factory<TitikKemacetan>
 */
class TitikKemacetanFactory extends Factory
{
    protected $model = TitikKemacetan::class;

    public function definition(): array
    {
        return [
            'nama_jalan' => fake()->randomElement([
                'Jl. Dr. Djunjunan (Pasteur)',
                'Jl. Ir. H. Djuanda (Dago)',
                'Jl. R.E. Martadinata (Riau)',
                'Jl. Soekarno-Hatta (By Pass)',
                'Jl. Raya Buah Batu',
                'Jl. Cihampelas',
                'Jl. Setiabudi',
                'Jl. Asia Afrika',
            ]),
            'wilayah' => fake()->randomElement(['Bandung Tengah', 'Bandung Utara', 'Bandung Selatan', 'Bandung Timur', 'Bandung Barat']),
            'kondisi_lalin' => fake()->randomElement(['Lancar', 'Ramai Lancar', 'Padat Merayap', 'Macet Total']),
            'kecepatan_rata_rata' => fake()->numberBetween(5, 60),
            'panjang_antrian' => fake()->numberBetween(50, 2000),
            'penyebab' => fake()->randomElement([
                'Penyempitan lajur kendaraan',
                'Volume kendaraan jam sibuk kerja',
                'Perbaikan saluran drainase jalan',
                'Antrian lampu merah perempatan utama',
                'Kendaraan mogok di lajur tengah',
            ]),
        ];
    }
}
