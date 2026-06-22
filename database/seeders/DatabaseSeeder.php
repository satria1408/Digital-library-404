<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================
        // ADMIN
        // ==========================
        User::create([
            'nama_lengkap' => 'Administrator Utama',
            'username'     => 'admin',
            'password'     => Hash::make('123456'),
            'role'         => 'admin',
            'alamat'       => 'Ruang Admin Perpustakaan',
        ]);

        // ==========================
        // SISWA
        // ==========================
        $siswa1 = User::create([
            'nama_lengkap' => 'Budi Santoso',
            'username'     => 'siswa',
            'password'     => Hash::make('123456'),
            'role'         => 'siswa',
            'alamat'       => 'Jl. Mawar No. 10',
        ]);

        User::create([
            'nama_lengkap' => 'Siti Aminah',
            'username'     => 'siti123',
            'password'     => Hash::make('123456'),
            'role'         => 'siswa',
            'alamat'       => 'Jl. Melati No. 5',
        ]);

        // ==========================
        // BUKU
        // ==========================
        $buku1 = Book::create([
            'judul'     => 'Belajar Laravel 10 untuk Pemula',
            'penulis'   => 'Taylor Otwell',
            'penerbit'  => 'Laravel Press',
            'kategori'  => 'Teknologi',
            'stok'      => 5,
        ]);

        $buku2 = Book::create([
            'judul'     => 'Laskar Pelangi',
            'penulis'   => 'Andrea Hirata',
            'penerbit'  => 'Bentang Pustaka',
            'kategori'  => 'Novel',
            'stok'      => 3,
        ]);

        Book::create([
            'judul'     => 'Filosofi Teras',
            'penulis'   => 'Henry Manampiring',
            'penerbit'  => 'Kompas',
            'kategori'  => 'Pengembangan Diri',
            'stok'      => 10,
        ]);

        Book::create([
            'judul'     => 'Harry Potter dan Batu Bertuah',
            'penulis'   => 'J.K. Rowling',
            'penerbit'  => 'Gramedia',
            'kategori'  => 'Fiksi',
            'stok'      => 0,
        ]);

        // ==========================
        // TRANSAKSI
        // ==========================
        Transaction::create([
            'user_id'         => $siswa1->id,
            'book_id'         => $buku1->id,
            'tanggal_pinjam'  => Carbon::now()->subDays(2),
            'tanggal_kembali' => null,
            'status'          => 'pinjam',
        ]);

        $buku1->decrement('stok');

        Transaction::create([
            'user_id'         => $siswa1->id,
            'book_id'         => $buku2->id,
            'tanggal_pinjam'  => Carbon::now()->subDays(10),
            'tanggal_kembali' => Carbon::now()->subDays(3),
            'status'          => 'kembali',
        ]);
    }
}