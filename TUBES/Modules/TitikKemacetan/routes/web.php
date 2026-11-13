<?php

use Illuminate\Support\Facades\Route;
use Modules\TitikKemacetan\Http\Controllers\TitikKemacetanController;

Route::middleware('auth')->group(function () {
    // Menampilkan daftar titik kemacetan (Dapat diakses Admin dan User)
    Route::get('titikkemacetan', [TitikKemacetanController::class, 'index'])->name('titikkemacetan.index');

    // Pengelolaan CRUD titik kemacetan (Khusus Admin dilindungi middleware role:admin)
    Route::middleware('role:admin')->group(function () {
        Route::get('titikkemacetan/create', [TitikKemacetanController::class, 'create'])->name('titikkemacetan.create');
        Route::post('titikkemacetan', [TitikKemacetanController::class, 'store'])->name('titikkemacetan.store');
        Route::get('titikkemacetan/{titik}/edit', [TitikKemacetanController::class, 'edit'])->name('titikkemacetan.edit');
        Route::put('titikkemacetan/{titik}', [TitikKemacetanController::class, 'update'])->name('titikkemacetan.update');
        Route::delete('titikkemacetan/{titik}', [TitikKemacetanController::class, 'destroy'])->name('titikkemacetan.destroy');
    });
});
