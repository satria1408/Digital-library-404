<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

// --- UPDATE CONTROLLERS JALUR UNIVERSAL (DI LUAR DIGITAL LIBRARY) ---
use App\Http\Controllers\SecurityLogController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Developer\SuggestionController;
use App\Http\Controllers\Owner\OwnerController; 

// --- UPDATE CONTROLLERS JALUR MODUL (DI DALAM DIGITAL LIBRARY) ---
use App\Http\Controllers\DigitalLibrary\Admin\AdminController;
use App\Http\Controllers\DigitalLibrary\Admin\BookController;
use App\Http\Controllers\DigitalLibrary\Admin\TransactionController;
use App\Http\Controllers\DigitalLibrary\Admin\UserController;
use App\Http\Controllers\DigitalLibrary\Admin\AdminDendaController; // Disinkronkan masuk ke subfolder Admin sesuai letak model seeder
use App\Http\Controllers\DigitalLibrary\Siswa\SiswaController;
use App\Http\Controllers\DigitalLibrary\Siswa\WishlistController;

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
| Authentication (SISTEM SATU PINTU UNIVERSAL)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Pintu Masuk Utama & Proses Autentikasi Semua Role (Siswa, Admin, Owner, Dev)
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process')
    ->middleware('throttle:login');

// Register & Logout
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register')
    ->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin (Digital Library Module)
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

        // Import Buku Massal via Excel
        Route::post('/buku/import-excel', [AdminController::class, 'importBukuExcel'])
            ->name('admin.buku.import');

        // Approval System
        Route::patch('/transactions/{id}/setujui', [TransactionController::class, 'setujuiPinjaman'])
            ->name('admin.transactions.setujui');

        Route::patch('/transactions/{id}/tolak', [TransactionController::class, 'tolakPinjaman'])
            ->name('admin.transactions.tolak');

        // Denda (Sesuai dengan penempatan namespace AdminDendaController baru)
        Route::get('/dendas', [AdminDendaController::class, 'index'])
            ->name('dendas.index');

        Route::patch('/dendas/{id}/bayar', [AdminDendaController::class, 'bayar'])
            ->name('dendas.bayar');

        // Security Log (Universal)
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
| Siswa (Digital School - OneSchool Hub Platform)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->group(function () {

        // 1. HALAMAN UTAMA ONESCHOOL HUB (Menampilkan 2 modul raksasa)
        Route::get('/dashboard', [SiswaController::class, 'index'])
            ->name('siswa.dashboard');

        // 2. SUB-DASHBOARD PERPUSTAKAAN DIGITAL (Menampilkan statistik perpus & 4 tombol fitur)
        Route::get('/digital-library', [SiswaController::class, 'digitalLibraryIndex'])
            ->name('siswa.digital_library.index');

        // --- Rute Partials Halaman Eksklusif Perpus ---
        Route::get('/partials/stats', [SiswaController::class, 'showStats'])
            ->name('siswa.stats');

        Route::get('/partials/peminjaman', [SiswaController::class, 'showPeminjaman'])
            ->name('siswa.peminjaman');

        Route::get('/partials/pengembalian', [SiswaController::class, 'showPengembalian'])
            ->name('siswa.pengembalian');

        /*
        | Wishlist Buku
        */
        Route::get('/wishlist', [WishlistController::class, 'index'])
            ->name('wishlist.index');

        Route::post('/wishlist/{book}', [WishlistController::class, 'store'])
            ->name('wishlist.store');

        Route::delete('/wishlist/{book}', [WishlistController::class, 'destroy'])
            ->name('wishlist.destroy');

        /*
        | Peminjaman & Pengembalian
        */
        Route::post('/pinjam/{book_id}', [SiswaController::class, 'pinjamBuku'])
            ->name('siswa.pinjam')
            ->middleware('throttle:pinjam');

        Route::post('/kembali/{transaction_id}', [SiswaController::class, 'kembalikanBuku'])
            ->name('siswa.kembali')
            ->middleware('throttle:pinjam');
    });

/*
|--------------------------------------------------------------------------
| Developer (Kotak Saran & Keluhan Sistem - Universal)
|--------------------------------------------------------------------------
*/

// Route Akses Umum
Route::post('/saran/kirim', [SuggestionController::class, 'store'])->name('saran.store');
Route::post('/saran/cek', [SuggestionController::class, 'checkTicket'])->name('saran.check');

// Route Khusus Proteksi Auth & Role Developer
Route::middleware(['auth', 'role:developer'])
    ->prefix('developer')
    ->group(function () {

        Route::get('/dashboard', [SuggestionController::class, 'dashboard'])
            ->name('developer.dashboard');

        Route::get('/suggestions', [SuggestionController::class, 'indexForDeveloper'])
            ->name('developer.suggestions.index');

        // Ekspor Data Keluhan ke Excel
        Route::get('/suggestions/export-excel', [SuggestionController::class, 'exportExcel'])
            ->name('developer.suggestions.export');

        Route::post('/suggestions/{id}/reply', [SuggestionController::class, 'reply'])
            ->name('developer.suggestions.reply');

        // Hapus laporan/saran
        Route::delete('/suggestions/{id}', [SuggestionController::class, 'destroy'])
            ->name('developer.suggestions.destroy');
    });

/*
|--------------------------------------------------------------------------
| Owner (Modul Keuangan & Manajemen Bisnis - Universal)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->group(function () {

        Route::get('/dashboard', [OwnerController::class, 'index'])
            ->name('owner.dashboard');

        Route::post('/profil/update', [OwnerController::class, 'updateProfil'])
            ->name('owner.profil.update');
    });