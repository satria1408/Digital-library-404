<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DigitalLibrary\Siswa\SiswaController;
use App\Http\Controllers\DigitalLibrary\Siswa\WishlistController;

Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa/digital-library')
    ->name('digitallibrary.siswa.')
    ->group(function () {

        Route::get('/', [SiswaController::class, 'digitalLibraryIndex'])
            ->name('index');

        Route::get('/partials/stats', [SiswaController::class, 'showStats'])
            ->name('stats');

        Route::get('/partials/peminjaman', [SiswaController::class, 'showPeminjaman'])
            ->name('peminjaman');

        Route::get('/partials/pengembalian', [SiswaController::class, 'showPengembalian'])
            ->name('pengembalian');

        Route::get('/wishlist', [WishlistController::class, 'index'])
            ->name('wishlist.index');

        Route::post('/wishlist/{book}', [WishlistController::class, 'store'])
            ->name('wishlist.store');

        Route::delete('/wishlist/{book}', [WishlistController::class, 'destroy'])
            ->name('wishlist.destroy');

        Route::post('/pinjam/{book_id}', [SiswaController::class, 'pinjamBuku'])
            ->name('pinjam')
            ->middleware('throttle:pinjam');

        Route::post('/kembali/{transaction_id}', [SiswaController::class, 'kembalikanBuku'])
            ->name('kembali')
            ->middleware('throttle:pinjam');
    });