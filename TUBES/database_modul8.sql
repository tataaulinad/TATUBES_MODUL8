-- =====================================================================
-- SMART TRAFFIC FINDER - SKEMA DATABASE MODUL 8 HMVC & AJAX
-- Database: smarttraffic_finder (atau smart_traffic)
-- =====================================================================

USE `smarttraffic_finder`;

-- 1. Tabel Titik Kemacetan (Modul HMVC 1 - Synchronous CRUD)
CREATE TABLE IF NOT EXISTS `titik_kemacetans` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_jalan` VARCHAR(255) NOT NULL,
  `wilayah` VARCHAR(255) NOT NULL,
  `kondisi_lalin` VARCHAR(50) NOT NULL, -- Lancar, Ramai Lancar, Padat Merayap, Macet Total
  `kecepatan_rata_rata` INT(11) NOT NULL, -- km/jam
  `panjang_antrian` INT(11) NOT NULL, -- meter
  `penyebab` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data Awal Minimal 5 Item untuk Titik Kemacetan
INSERT INTO `titik_kemacetans` (`id`, `nama_jalan`, `wilayah`, `kondisi_lalin`, `kecepatan_rata_rata`, `panjang_antrian`, `penyebab`, `created_at`, `updated_at`) VALUES
(1, 'Jl. Dr. Djunjunan (Gerbang Tol Pasteur)', 'Cicendo', 'Padat Merayap', 12, 1200, 'Antrian kendaraan keluar pintu tol Pasteur menuju pusat kota', NOW(), NOW()),
(2, 'Jl. Ir. H. Djuanda (Simpang Dago - Cikapayang)', 'Coblong', 'Macet Total', 5, 850, 'Volume kendaraan tinggi jam pulang kantor dan antrian lampu merah', NOW(), NOW()),
(3, 'Jl. Soekarno-Hatta (Perempatan Buah Batu)', 'Bandung Kidul', 'Padat Merayap', 18, 950, 'Penyempitan jalur flyover dan perlintasan kendaraan bertonase besar', NOW(), NOW()),
(4, 'Jl. R.E. Martadinata (Riau Heritage)', 'Bandung Wetan', 'Ramai Lancar', 28, 200, 'Aktivitas keluar masuk kendaraan di kawasan kuliner dan pertokoan', NOW(), NOW()),
(5, 'Jl. Cihampelas (Depan Ciwalk)', 'Coblong', 'Macet Total', 8, 700, 'Aktivitas wisatawan, drop-off angkutan umum, dan parkir liar', NOW(), NOW())
ON DUPLICATE KEY UPDATE `nama_jalan` = VALUES(`nama_jalan`);

-- 2. Tabel Laporan Insiden (Modul HMVC 2 - Asynchronous CRUD AJAX & Upload Berkas)
CREATE TABLE IF NOT EXISTS `laporan_insidens` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_pelapor` VARCHAR(255) NOT NULL,
  `lokasi_jalan` VARCHAR(255) NOT NULL,
  `kategori_insiden` VARCHAR(100) NOT NULL, -- Kemacetan Parah, Kecelakaan, Jalan Rusak, Pohon Tumbang, Lampu Merah Mati, Banjir
  `tingkat_keparahan` VARCHAR(50) NOT NULL, -- Rendah, Sedang, Tinggi, Kritis
  `keterangan` TEXT NOT NULL,
  `kontak_pelapor` VARCHAR(20) NOT NULL,
  `berkas` VARCHAR(255) DEFAULT NULL,
  `nama_berkas` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data Awal Minimal 5 Item untuk Laporan Insiden
INSERT INTO `laporan_insidens` (`id`, `nama_pelapor`, `lokasi_jalan`, `kategori_insiden`, `tingkat_keparahan`, `keterangan`, `kontak_pelapor`, `berkas`, `nama_berkas`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', 'Jl. Dr. Djunjunan (Pasteur) Depan BTC', 'Kemacetan Parah', 'Kritis', 'Ekor kemacetan telah mencapai lebih dari 1 km hingga exit tol Pasteur, lajur tengah terhambat truk mogok.', '081234567890', 'berkas_insiden/sampel_laporan_pasteur.jpg', 'foto_kemacetan_pasteur.jpg', NOW(), NOW()),
(2, 'Siti Aminah', 'Jl. Setiabudi (Dekat Rumah Sosis)', 'Pohon Tumbang', 'Tinggi', 'Dahan pohon trembesi patah melintang menutupi separuh badan jalan arah Lembang.', '085712345678', NULL, NULL, NOW(), NOW()),
(3, 'Andi Pratama', 'Jl. Soekarno-Hatta Simpang Kiaracondong', 'Lampu Merah Mati', 'Tinggi', 'Lampu APILL dari arah barat padam total sehingga kendaraan saling mengunci di tengah perempatan.', '081398765432', NULL, NULL, NOW(), NOW()),
(4, 'Dewi Lestari', 'Jl. Pasirkaliki (Dekat Paskal 23)', 'Kemacetan Parah', 'Sedang', 'Antrian kendaraan pengunjung mall mengular hingga bahu jalan utama, lajur kiri tidak dapat dilalui.', '082198761234', NULL, NULL, NOW(), NOW()),
(5, 'Rizky Firmansyah', 'Jl. Laswi (Dekat Perlintasan Kereta Api)', 'Jalan Berlubang / Rusak', 'Sedang', 'Aspal amblas sedalam 15 cm di dekat rel kereta api yang membahayakan pengendara roda dua saat malam hari.', '087812344321', NULL, NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE `nama_pelapor` = VALUES(`nama_pelapor`);
