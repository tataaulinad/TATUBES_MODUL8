<?php

use Illuminate\Support\Facades\Route;
use Modules\LaporanInsiden\Http\Controllers\LaporanInsidenController;

Route::middleware(['auth', 'role:admin,user'])->group(function () {
    Route::get('laporaninsiden', [LaporanInsidenController::class, 'index'])->name('laporaninsiden.index');
    Route::get('laporaninsiden/data', [LaporanInsidenController::class, 'getData'])->name('laporaninsiden.data');
    Route::post('laporaninsiden', [LaporanInsidenController::class, 'store'])->name('laporaninsiden.store');
    Route::get('laporaninsiden/{laporaninsiden}/edit', [LaporanInsidenController::class, 'edit'])->name('laporaninsiden.edit');
    Route::put('laporaninsiden/{laporaninsiden}', [LaporanInsidenController::class, 'update'])->name('laporaninsiden.update');
    Route::delete('laporaninsiden/{laporaninsiden}', [LaporanInsidenController::class, 'destroy'])->name('laporaninsiden.destroy');
});
