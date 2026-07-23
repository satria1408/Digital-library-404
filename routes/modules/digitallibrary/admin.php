<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DigitalLibrary\Admin\AdminController;
use App\Http\Controllers\DigitalLibrary\Admin\BookController;
use App\Http\Controllers\DigitalLibrary\Admin\TransactionController;
use App\Http\Controllers\DigitalLibrary\Admin\UserController;
use App\Http\Controllers\DigitalLibrary\Denda\AdminDendaController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('digitallibrary.admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

        Route::resource('books', BookController::class);
        Route::resource('users', UserController::class);
        Route::resource('transactions', TransactionController::class);

        // Import Buku Massal via Excel
        Route::post('/buku/import-excel', [AdminController::class, 'importBukuExcel'])
            ->name('buku.import');

        // Approval System
        Route::patch('/transactions/{id}/setujui', [TransactionController::class, 'setujuiPinjaman'])
            ->name('transactions.setujui');

        Route::patch('/transactions/{id}/tolak', [TransactionController::class, 'tolakPinjaman'])
            ->name('transactions.tolak');

        // Denda
        Route::get('/dendas', [AdminDendaController::class, 'index'])
            ->name('dendas.index');

        Route::patch('/dendas/{id}/bayar', [AdminDendaController::class, 'bayar'])
            ->name('dendas.bayar');
    });