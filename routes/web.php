<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SecurityLogController;

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

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

        // Approval System untuk Fitur Pending (Disisipkan tanpa merusak struktur)
        Route::patch('/transactions/{id}/setujui', [TransactionController::class, 'setujuiPinjaman'])
            ->name('admin.transactions.setujui');
        Route::patch('/transactions/{id}/tolak', [TransactionController::class, 'tolakPinjaman'])
            ->name('admin.transactions.tolak');

        // Denda — ditangani TransactionController
        Route::get('/dendas', [TransactionController::class, 'dendaIndex'])->name('dendas.index');
        Route::patch('/dendas/{id}/bayar', [TransactionController::class, 'dendaBayar'])->name('dendas.bayar');

        // Security Log — Anti SQL Injection
        Route::get('/security-logs', [SecurityLogController::class, 'index'])->name('security.logs.index');
        Route::get('/security-logs/{securityLog}', [SecurityLogController::class, 'show'])->name('security.logs.show');
        Route::delete('/security-logs/{securityLog}', [SecurityLogController::class, 'destroy'])->name('security.logs.destroy');
        Route::delete('/security-logs', [SecurityLogController::class, 'destroyAll'])->name('security.logs.destroyAll');
    });

/*
|--------------------------------------------------------------------------
| Siswa
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->group(function () {

        // Halaman Utama Dashboard Menu Card (Menggunakan layout baru)
        Route::get('/dashboard', [SiswaController::class, 'index'])
            ->name('siswa.dashboard');

        // URL Halaman Terpisah Berbasis Struktur Partials
        Route::get('/partials/stats', [SiswaController::class, 'showStats'])
            ->name('siswa.stats');

        Route::get('/partials/peminjaman', [SiswaController::class, 'showPeminjaman'])
            ->name('siswa.peminjaman');

        Route::get('/partials/pengembalian', [SiswaController::class, 'showPengembalian'])
            ->name('siswa.pengembalian');

        // Logika Proses POST Peminjaman & Pengembalian
        Route::post('/pinjam/{book_id}', [SiswaController::class, 'pinjamBuku'])
            ->name('siswa.pinjam')
            ->middleware('throttle:pinjam');

        Route::post('/kembali/{transaction_id}', [SiswaController::class, 'kembalikanBuku'])
            ->name('siswa.kembali')
            ->middleware('throttle:pinjam');
    });