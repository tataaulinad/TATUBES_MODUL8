# DOKUMENTASI TUGAS AKHIR PEMROGRAMAN BERBASIS WEB
## MODUL 8: ARSITEKTUR HMVC, AUTHORIZATION BERBASIS ROLE, DAN AJAX

---

### Identitas Proyek
- **Nama Aplikasi**: Smart Traffic Finder
- **Framework**: Laravel 12.x
- **Arsitektur Modular**: HMVC (*Hierarchical Model-View-Controller*) via `nwidart/laravel-modules`
- **Desain & UI**: Tailwind CSS CDN, Font Awesome 6, Inter Font (Desain orisinal tetap dipertahankan 100%)

---

### Ketentuan Modul 8 & Realisasi

| No | Ketentuan Tugas Akhir Modul 8 | Status | Realisasi Implementasi |
|:---|:---|:---:|:---|
| **(a)** | Minimal dua modul HMVC sesuai tema proyek | **TERPENUHI** | Modul 1: `TitikKemacetan`, Modul 2: `LaporanInsiden`, Modul 3: `UserManagement`. |
| **(b)** | 1 modul CRUD Synchronous & 1 modul CRUD AJAX (masing-masing min. 5 item) | **TERPENUHI** | **TitikKemacetan**: CRUD Synchronous (6 item: nama_jalan, wilayah, kondisi_lalin, kecepatan_rata_rata, panjang_antrian, penyebab).<br>**LaporanInsiden**: CRUD AJAX (7 item: nama_pelapor, kontak_pelapor, lokasi_jalan, kategori_insiden, tingkat_keparahan, keterangan, berkas). |
| **(c)** | Minimal 2 role pengguna dengan hak akses berbeda & dilindungi middleware | **TERPENUHI** | Role `admin` & `user`. Dilindungi middleware `EnsureUserHasRole` (`role:admin`, `role:admin,user`). Admin memiliki akses penuh Create/Edit/Delete TitikKemacetan & Kelola User. User biasa hanya dapat membaca Titik Kemacetan dan mengelola Laporan Insiden. |
| **(d)** | Seluruh halaman pengelolaan data hanya dapat diakses setelah login | **TERPENUHI** | Seluruh route pengelolaan data dibungkus dalam middleware `auth`. Pengguna tamu (guest) otomatis diredirect ke `/login`. |
| **(e)** | Modul AJAX wajib memiliki minimal satu input upload file yang dapat dibuka kembali | **TERPENUHI** | Modul `LaporanInsiden` memiliki input upload berkas bukti foto/dokumen (JPG, PNG, PDF) dengan tombol **"Buka Berkas"** yang membuka file di tab baru (`/storage/berkas_insiden/...`). |
| **(f)** | Desain aplikasi tidak diubah (tetap seperti semula) | **TERPENUHI** | Tampilan tetap konsisten menggunakan Tailwind CSS, skema warna oranye khas Smart Traffic Finder, navigasi bawah mobile, dan font Inter. |

---

### Akun Pengujian (Testing Credentials)

| Role | Email | Password | Hak Akses |
|:---|:---|:---|:---|
| **Administrator** | `admin@smarttraffic.id` | `admin123` | Akses penuh CRUD seluruh modul (Titik Kemacetan, Laporan Insiden, Kelola Pengguna). |
| **User Biasa** | `user1@smarttraffic.id` | `password123` | Read-only Titik Kemacetan, CRUD AJAX Laporan Insiden, dilarang mengakses modul Admin (403 Forbidden). |

---

### Panduan Menjalankan Aplikasi

1. **Jalankan Web Server & MySQL**:
   Nyalakan Apache & MySQL di XAMPP.
2. **Setup Database**:
   Import file `smarttraffic_finder_modul6.sql` lalu `database_modul8.sql`, atau jalankan migration & seeder:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
3. **Storage Link (Untuk Akses File Upload)**:
   ```bash
   php artisan storage:link
   ```
4. **Jalankan Server Laravel**:
   ```bash
   php artisan serve
   ```
5. **Jalankan Pengujian Unit & Feature (PHPUnit)**:
   ```bash
   php vendor/phpunit/phpunit/phpunit
   ```
   *Seluruh 23 skenario pengujian otomatis lolos (100% OK).*
