<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\Denda;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
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

        $siswa2 = User::create([
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
            'judul'    => 'Belajar Laravel 10 untuk Pemula',
            'penulis'  => 'Taylor Otwell',
            'penerbit' => 'Laravel Press',
            'kategori' => 'Teknologi',
            'stok'     => 5,
        ]);

        $buku2 = Book::create([
            'judul'    => 'Laskar Pelangi',
            'penulis'  => 'Andrea Hirata',
            'penerbit' => 'Bentang Pustaka',
            'kategori' => 'Novel',
            'stok'     => 3,
        ]);

        Book::create([
            'judul'    => 'Filosofi Teras',
            'penulis'  => 'Henry Manampiring',
            'penerbit' => 'Kompas',
            'kategori' => 'Pengembangan Diri',
            'stok'     => 10,
        ]);

        Book::create([
            'judul'    => 'Harry Potter dan Batu Bertuah',
            'penulis'  => 'J.K. Rowling',
            'penerbit' => 'Gramedia',
            'kategori' => 'Fiksi',
            'stok'     => 0,
        ]);

        // ==========================
        // TRANSAKSI
        // ==========================

        // Skenario 1: Status masih 'pinjam', jatuh tempo sudah lewat 5 hari yang lalu.
        // Pinjam 12 hari lalu, harusnya balik 5 hari lalu (tanggal_deadline), tanggal_kembali masih null.
        $trx1 = Transaction::create([
            'user_id'          => $siswa1->id,
            'book_id'          => $buku1->id,
            'tanggal_pinjam'   => Carbon::now()->subDays(12),
            'tanggal_deadline' => Carbon::now()->subDays(5), 
            'tanggal_kembali'  => null, 
            'status'           => 'pinjam',
        ]);
        $buku1->decrement('stok');

        // Skenario 2: Status masih 'pinjam', jatuh tempo sudah lewat 10 hari yang lalu.
        // Pinjam 17 hari lalu, harusnya balik 10 hari lalu (tanggal_deadline), tanggal_kembali masih null.
        $trx2 = Transaction::create([
            'user_id'          => $siswa2->id,
            'book_id'          => $buku2->id,
            'tanggal_pinjam'   => Carbon::now()->subDays(17),
            'tanggal_deadline' => Carbon::now()->subDays(10),
            'tanggal_kembali'  => null,
            'status'           => 'pinjam',
        ]);
        $buku2->decrement('stok');

        // Skenario 3: Sudah dikembalikan tepat waktu — tidak ada denda
        // Pinjam 10 hari lalu, deadline harusnya 3 hari lalu, dan dikembalikan tepat waktu 3 hari lalu.
        Transaction::create([
            'user_id'          => $siswa1->id,
            'book_id'          => $buku2->id,
            'tanggal_pinjam'   => Carbon::now()->subDays(10),
            'tanggal_deadline' => Carbon::now()->subDays(3),
            'tanggal_kembali'  => Carbon::now()->subDays(3),
            'status'           => 'kembali',
        ]);

        // ==========================
        // DENDA
        // ==========================
        Denda::create([
            'transaction_id' => $trx1->id,
            'hari_terlambat' => 5,
            'nominal'        => Denda::hitungNominal(5), // Rp 2.000
            'status'         => 'belum_bayar',
        ]);

        Denda::create([
            'transaction_id' => $trx2->id,
            'hari_terlambat' => 10,
            'nominal'        => Denda::hitungNominal(10), // Rp 5.000
            'status'         => 'belum_bayar',
        ]);
    }
}