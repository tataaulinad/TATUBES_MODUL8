<?php

namespace Modules\LaporanInsiden\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Modules\LaporanInsiden\Models\LaporanInsiden;

class LaporanInsidenDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('berkas_insiden');

        // Buat file contoh bukti insiden jika belum ada
        $samplePath = 'berkas_insiden/sampel_laporan_pasteur.jpg';
        if (! Storage::disk('public')->exists($samplePath)) {
            // Gambar 1x1 pixel PNG valid sebagai sampel berkas
            $sampleImage = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
            Storage::disk('public')->put($samplePath, $sampleImage);
        }

        $data = [
            [
                'nama_pelapor' => 'Budi Santoso',
                'lokasi_jalan' => 'Jl. Dr. Djunjunan (Pasteur) Depan BTC',
                'kategori_insiden' => 'Kemacetan Parah',
                'tingkat_keparahan' => 'Kritis',
                'keterangan' => 'Ekor kemacetan telah mencapai lebih dari 1 km hingga exit tol Pasteur, lajur tengah terhambat truk mogok.',
                'kontak_pelapor' => '081234567890',
                'berkas' => $samplePath,
                'nama_berkas' => 'foto_kemacetan_pasteur.jpg',
            ],
            [
                'nama_pelapor' => 'Siti Aminah',
                'lokasi_jalan' => 'Jl. Setiabudi (Dekat Rumah Sosis)',
                'kategori_insiden' => 'Pohon Tumbang',
                'tingkat_keparahan' => 'Tinggi',
                'keterangan' => 'Dahan pohon trembesi patah melintang menutupi separuh badan jalan arah Lembang.',
                'kontak_pelapor' => '085712345678',
                'berkas' => null,
                'nama_berkas' => null,
            ],
            [
                'nama_pelapor' => 'Andi Pratama',
                'lokasi_jalan' => 'Jl. Soekarno-Hatta Simpang Kiaracondong',
                'kategori_insiden' => 'Lampu Merah Mati',
                'tingkat_keparahan' => 'Tinggi',
                'keterangan' => 'Lampu APILL dari arah barat padam total sehingga kendaraan saling mengunci di tengah perempatan.',
                'kontak_pelapor' => '081398765432',
                'berkas' => null,
                'nama_berkas' => null,
            ],
            [
                'nama_pelapor' => 'Dewi Lestari',
                'lokasi_jalan' => 'Jl. Pasirkaliki (Dekat Paskal 23)',
                'kategori_insiden' => 'Kemacetan Parah',
                'tingkat_keparahan' => 'Sedang',
                'keterangan' => 'Antrian kendaraan masuk mall meluber ke jalan utama.',
                'kontak_pelapor' => '087812341234',
                'berkas' => null,
                'nama_berkas' => null,
            ],
            [
                'nama_pelapor' => 'Rizky Ramadhan',
                'lokasi_jalan' => 'Jl. Pagarsih Simpang Jamika',
                'kategori_insiden' => 'Banjir / Genangan Air',
                'tingkat_keparahan' => 'Tinggi',
                'keterangan' => 'Genangan air setinggi 30 cm setelah hujan deras, sepeda motor dialihkan.',
                'kontak_pelapor' => '082245678901',
                'berkas' => null,
                'nama_berkas' => null,
            ],
            [
                'nama_pelapor' => 'Rina Marlina',
                'lokasi_jalan' => 'Jl. Surapati Depan Gasibu',
                'kategori_insiden' => 'Kecelakaan Lalu Lintas',
                'tingkat_keparahan' => 'Sedang',
                'keterangan' => 'Senggolan antara minibus dan sepeda motor, sudah dievakuasi ke bahu jalan namun arus masih padat.',
                'kontak_pelapor' => '081122334455',
                'berkas' => null,
                'nama_berkas' => null,
            ],
        ];

        foreach ($data as $item) {
            LaporanInsiden::firstOrCreate(
                ['lokasi_jalan' => $item['lokasi_jalan'], 'nama_pelapor' => $item['nama_pelapor']],
                $item
            );
        }
    }
}
