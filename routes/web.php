<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Http\Controllers\SecurityLogController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Siswa\SiswaController;
use App\Http\Controllers\Siswa\WishlistController;
use App\Http\Controllers\Denda\AdminDendaController;

/*
|--------------------------------------------------------------------------
| Rate Limiter — Mencegah spam request login & pinjam buku
|--------------------------------------------------------------------------
*/

RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});

RateLimiter::for('pinjam', function (Request $request) {
    return Limit::perMinute(3)->by($request->user()?->id ?: $request->ip());
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process')
    ->middleware('throttle:login');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register')
    ->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('admin.dashboard');

        Route::resource('books', BookController::class);
        Route::resource('users', UserController::class);
        Route::resource('transactions', TransactionController::class);

        // ROUTE BARU: Import Buku Massal via Excel
        Route::post('/buku/import-excel', [AdminController::class, 'importBukuExcel'])
            ->name('admin.buku.import');

        // Approval System
        Route::patch('/transactions/{id}/setujui', [TransactionController::class, 'setujuiPinjaman'])
            ->name('admin.transactions.setujui');

        Route::patch('/transactions/{id}/tolak', [TransactionController::class, 'tolakPinjaman'])
            ->name('admin.transactions.tolak');

        // Denda (Diambil dari AdminDendaController di folder Denda baru)
        Route::get('/dendas', [AdminDendaController::class, 'index'])
            ->name('dendas.index');

        Route::patch('/dendas/{id}/bayar', [AdminDendaController::class, 'bayar'])
            ->name('dendas.bayar');

        // Security Log
        Route::get('/security-logs', [SecurityLogController::class, 'index'])
            ->name('security.logs.index');

        Route::get('/security-logs/{securityLog}', [SecurityLogController::class, 'show'])
            ->name('security.logs.show');

        Route::delete('/security-logs/{securityLog}', [SecurityLogController::class, 'destroy'])
            ->name('security.logs.destroy');

        Route::delete('/security-logs', [SecurityLogController::class, 'destroyAll'])
            ->name('security.logs.destroyAll');
    });

/*
|--------------------------------------------------------------------------
| Siswa
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [SiswaController::class, 'index'])
            ->name('siswa.dashboard');

        // Halaman
        Route::get('/partials/stats', [SiswaController::class, 'showStats'])
            ->name('siswa.stats');

        Route::get('/partials/peminjaman', [SiswaController::class, 'showPeminjaman'])
            ->name('siswa.peminjaman');

        Route::get('/partials/pengembalian', [SiswaController::class, 'showPengembalian'])
            ->name('siswa.pengembalian');

        /*
        |--------------------------------------------------------------------------
        | Wishlist Buku
        |--------------------------------------------------------------------------
        */

        Route::get('/wishlist', [WishlistController::class, 'index'])
            ->name('wishlist.index');

        Route::post('/wishlist/{book}', [WishlistController::class, 'store'])
            ->name('wishlist.store');

        Route::delete('/wishlist/{book}', [WishlistController::class, 'destroy'])
            ->name('wishlist.destroy');

        /*
        |--------------------------------------------------------------------------
        | Peminjaman & Pengembalian
        |--------------------------------------------------------------------------
        */

        Route::post('/pinjam/{book_id}', [SiswaController::class, 'pinjamBuku'])
            ->name('siswa.pinjam')
            ->middleware('throttle:pinjam');

        Route::post('/kembali/{transaction_id}', [SiswaController::class, 'kembalikanBuku'])
            ->name('siswa.kembali')
            ->middleware('throttle:pinjam');
    });