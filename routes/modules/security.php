<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecurityLogController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/security-logs')
    ->name('security.logs.')
    ->group(function () {

        Route::get('/', [SecurityLogController::class, 'index'])->name('index');
        Route::get('/{securityLog}', [SecurityLogController::class, 'show'])->name('show');
        Route::delete('/{securityLog}', [SecurityLogController::class, 'destroy'])->name('destroy');
        Route::delete('/', [SecurityLogController::class, 'destroyAll'])->name('destroyAll');
    });