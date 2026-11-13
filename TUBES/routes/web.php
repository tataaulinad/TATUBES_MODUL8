<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes - Smart Traffic Finder
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. RUTE PUBLIK (Dapat diakses tanpa login)
// ==========================================
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

// Rute Autentikasi Tamu (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// ==========================================
// 2. RUTE TERPROTEKSI (Wajib Login / Middleware Auth)
// ==========================================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // Dashboard / Beranda Utama
    Route::get('/beranda', [HomeController::class, 'beranda'])->name('beranda');
    Route::get('/dashboard', [HomeController::class, 'beranda'])->name('dashboard');

    // Laporan Insiden & Kemacetan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');

    // Ruang Chat Komunitas Lalu Lintas
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');

    // Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ==========================================
// 3. KOMPATIBILITAS RUTE LEGACY PHP
// ==========================================
Route::get('/Hlogin.php', fn () => redirect()->route('login'));
Route::get('/Hregristulang.php', fn () => redirect()->route('register'));
Route::get('/beranda.php', fn () => redirect()->route('beranda'));
Route::get('/laporan.php', fn () => redirect()->route('laporan.index'));
Route::get('/chat.php', fn () => redirect()->route('chat'));
Route::get('/Profile.php', fn () => redirect()->route('profile'));
Route::get('/logout.php', function () {
    return redirect()->route('login')->with('info', 'Gunakan tombol logout resmi di aplikasi.');
});
