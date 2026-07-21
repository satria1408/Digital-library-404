<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaranaPengaduan\Admin\ComplaintController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/sarana-pengaduan')
    ->name('saranapengaduan.admin.')
    ->group(function () {

        Route::get('/dashboard', [ComplaintController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/laporan', [ComplaintController::class, 'index'])
            ->name('index');

        Route::get('/laporan/{id}', [ComplaintController::class, 'show'])
            ->name('show');

        Route::patch('/laporan/{id}/update-status', [ComplaintController::class, 'updateStatus'])
            ->name('update_status');
    });