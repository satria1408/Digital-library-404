<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DigitalLibrary\Siswa\SiswaController;

Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'index'])
            ->name('dashboard');
    });