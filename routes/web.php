<?php 
 
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\BookController; 
use App\Http\Controllers\SiswaController; 
use App\Http\Controllers\TransactionController; 
 
// Halaman Depan / Login 
Route::get('/', function () { return redirect('/login'); }); 
Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); 
Route::post('/login', [AuthController::class, 'login']); 
Route::get('/register', [AuthController::class, 'showRegister']); // Flowchart: Daftar Anggota 
Route::post('/register', [AuthController::class, 'register']); 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 
 
// Group Admin (Flowchart: Dashboard Admin -> Menu -> CRUD) 
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () { 
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard'); 
     
    // CRUD Data Buku 
    Route::resource('books', BookController::class); 
     
    // Kelola Anggota
    Route::resource('users', App\Http\Controllers\UserController::class); 
     
    // Kelola Transaksi (Admin melihat/edit semua transaksi) 
    Route::resource('transactions', TransactionController::class); 
}); 
 
// Group Siswa (Flowchart: Dashboard Siswa -> Peminjaman/Pengembalian) 
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () { 
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard'); 
    Route::post('/pinjam/{book_id}', [SiswaController::class, 'pinjamBuku']); // Peminjaman 
    Route::post('/kembali/{transaction_id}', [SiswaController::class, 'kembalikanBuku']); // Pengembalian 
});