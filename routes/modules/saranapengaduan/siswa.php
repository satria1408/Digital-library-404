<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaranaPengaduan\Siswa\SiswaComplaintController;

// --- Rute Publik (tanpa login) ---
Route::post('/siswa/pengaduan/kirim-umum', [SiswaComplaintController::class, 'storeUmum'])
    ->name('saranapengaduan.siswa.store_umum');

Route::post('/siswa/pengaduan/cek-status', [SiswaComplaintController::class, 'checkSchoolTicket'])
    ->name('saranapengaduan.siswa.check');

// --- Rute Internal (butuh login siswa) ---
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa/sarana-pengaduan')
    ->name('saranapengaduan.siswa.')
    ->group(function () {

        Route::get('/laporan', [SiswaComplaintController::class, 'index'])
            ->name('index');

        Route::get('/laporan/buat', [SiswaComplaintController::class, 'create'])
            ->name('create');

        Route::post('/laporan/simpan', [SiswaComplaintController::class, 'store'])
            ->name('store');

        Route::get('/laporan/{id}', [SiswaComplaintController::class, 'show'])
            ->name('show');
    });