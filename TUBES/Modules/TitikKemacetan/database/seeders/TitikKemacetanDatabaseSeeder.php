<?php

namespace Modules\TitikKemacetan\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TitikKemacetan\Models\TitikKemacetan;

class TitikKemacetanDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_jalan' => 'Jl. Dr. Djunjunan (Gerbang Tol Pasteur)',
                'wilayah' => 'Cicendo',
                'kondisi_lalin' => 'Padat Merayap',
                'kecepatan_rata_rata' => 12,
                'panjang_antrian' => 1200,
                'penyebab' => 'Antrian kendaraan keluar pintu tol Pasteur menuju pusat kota',
            ],
            [
                'nama_jalan' => 'Jl. Ir. H. Djuanda (Simpang Dago - Cikapayang)',
                'wilayah' => 'Coblong',
                'kondisi_lalin' => 'Macet Total',
                'kecepatan_rata_rata' => 5,
                'panjang_antrian' => 850,
                'penyebab' => 'Volume kendaraan tinggi jam pulang kantor dan lampu merah',
            ],
            [
                'nama_jalan' => 'Jl. Soekarno-Hatta (Perempatan Buah Batu)',
                'wilayah' => 'Bandung Kidul',
                'kondisi_lalin' => 'Padat Merayap',
                'kecepatan_rata_rata' => 18,
                'panjang_antrian' => 950,
                'penyebab' => 'Penyempitan jalur flyover dan perlintasan kendaraan berat',
            ],
            [
                'nama_jalan' => 'Jl. R.E. Martadinata (Riau Heritage)',
                'wilayah' => 'Bandung Wetan',
                'kondisi_lalin' => 'Ramai Lancar',
                'kecepatan_rata_rata' => 28,
                'panjang_antrian' => 200,
                'penyebab' => 'Keluar masuk kendaraan di kawasan pertokoan dan kuliner',
            ],
            [
                'nama_jalan' => 'Jl. Cihampelas (Depan Ciwalk)',
                'wilayah' => 'Coblong',
                'kondisi_lalin' => 'Macet Total',
                'kecepatan_rata_rata' => 8,
                'panjang_antrian' => 700,
                'penyebab' => 'Aktivitas drop-off wisatawan dan penyeberang jalan',
            ],
            [
                'nama_jalan' => 'Jl. Asia Afrika (Alun-Alun Bandung)',
                'wilayah' => 'Regol',
                'kondisi_lalin' => 'Lancar',
                'kecepatan_rata_rata' => 42,
                'panjang_antrian' => 50,
                'penyebab' => 'Arus lancar terkendali petugas Dishub',
            ],
        ];

        foreach ($data as $item) {
            TitikKemacetan::firstOrCreate(
                ['nama_jalan' => $item['nama_jalan']],
                $item
            );
        }
    }
}
