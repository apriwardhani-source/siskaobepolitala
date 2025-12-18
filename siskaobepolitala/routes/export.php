<?php

use App\Http\Controllers\ExportLaporanController;
use App\Http\Controllers\ExportKptController;
use App\Http\Controllers\TimExportController;
use App\Http\Controllers\Wadir1ExportController;
use Illuminate\Support\Facades\Route;

// Export routes - accessible by multiple roles
Route::middleware(['auth'])->group(function () {
    
    // Export Laporan OBE (Admin, Wadir1, Kaprodi)
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/nilai', [ExportLaporanController::class, 'exportNilai'])->name('nilai');
        Route::get('/pencapaian-cpl', [ExportLaporanController::class, 'exportPencapaianCPL'])->name('pencapaian-cpl');
        Route::get('/rekap-obe', [ExportLaporanController::class, 'exportRekapOBE'])->name('rekap-obe');
    });
    
    // Tim exports
    Route::prefix('tim/export')->name('tim.export.')->middleware(['auth.tim'])->group(function () {
        Route::get('/mahasiswa', [TimExportController::class, 'exportMahasiswa'])->name('mahasiswa');
        Route::get('/dosen', [TimExportController::class, 'exportDosen'])->name('dosen');
    });
    
    // Wadir1 exports
    Route::prefix('wadir1/export')->name('wadir1.export.')->middleware(['auth.wadir1'])->group(function () {
        Route::get('/kpt/{id}', [ExportKptController::class, 'exportToKpt'])->name('kpt');
        Route::post('/obe', [Wadir1ExportController::class, 'exportHasilObe'])->name('obe');
    });
});
