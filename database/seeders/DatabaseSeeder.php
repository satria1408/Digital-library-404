<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\Denda;
use App\Models\Wishlist;
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
        // BUKU (Total: 12 Buku dengan Real Image Link)
        // ==========================
        $buku1 = Book::create([
            'judul'    => 'Belajar Laravel 10 untuk Pemula',
            'penulis'  => 'Taylor Otwell',
            'penerbit' => 'Laravel Press',
            'kategori' => 'Teknologi',
            'stok'     => 5,
            'cover'    => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=400', // Coding theme
        ]);

        $buku2 = Book::create([
            'judul'    => 'Laskar Pelangi',
            'penulis'  => 'Andrea Hirata',
            'penerbit' => 'Bentang Pustaka',
            'kategori' => 'Novel',
            'stok'     => 3,
            'cover'    => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=400', // School/Rainbow kids vibe
        ]);

        $buku3 = Book::create([
            'judul'    => 'Filosofi Teras',
            'penulis'  => 'Henry Manampiring',
            'penerbit' => 'Kompas',
            'kategori' => 'Pengembangan Diri',
            'stok'     => 10,
            'cover'    => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=400', // Calm/Statue aesthetic
        ]);

        Book::create([
            'judul'    => 'Harry Potter dan Batu Bertuah',
            'penulis'  => 'J.K. Rowling',
            'penerbit' => 'Gramedia',
            'kategori' => 'Fiksi',
            'stok'     => 0,
            'cover'    => 'https://images.unsplash.com/photo-1510172951991-856a654063f9?q=80&w=400', // Magic/Castle vibe
        ]);

        $buku5 = Book::create([
            'judul'    => 'Clean Code',
            'penulis'  => 'Robert C. Martin',
            'penerbit' => 'Prentice Hall',
            'kategori' => 'Teknologi',
            'stok'     => 4,
            'cover'    => 'https://images.unsplash.com/photo-1629654297299-c8506221ca97?q=80&w=400', // Clean code screen theme
        ]);

        Book::create([
            'judul'    => 'Bumi Manusia',
            'penulis'  => 'Pramoedya Ananta Toer',
            'penerbit' => 'Lentera Dipantara',
            'kategori' => 'Novel',
            'stok'     => 6,
            'cover'    => 'https://images.unsplash.com/photo-1461360370896-922624d12aa1?q=80&w=400', // Classic old history vibe
        ]);

        Book::create([
            'judul'    => 'Atomic Habits',
            'penulis'  => 'James Clear',
            'penerbit' => 'Gramedia',
            'kategori' => 'Pengembangan Diri',
            'stok'     => 8,
            'cover'    => 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?q=80&w=400', // Progress checklist vibe
        ]);

        Book::create([
            'judul'    => 'Pulang',
            'penulis'  => 'Tere Liye',
            'penerbit' => 'Sabak Grip',
            'kategori' => 'Novel',
            'stok'     => 5,
            'cover'    => 'https://images.unsplash.com/photo-1488085061387-422e29b40080?q=80&w=400', // Train travel vibe
        ]);

        Book::create([
            'judul'    => 'Dilan 1990',
            'penulis'  => 'Pidi Baiq',
            'penerbit' => 'Pastel Books',
            'kategori' => 'Novel',
            'stok'     => 7,
            'cover'    => 'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?q=80&w=400', // Retro/Love vibe
        ]);

        Book::create([
            'judul'    => 'Canva Pro Design Guide',
            'penulis'  => 'Rizki Agung',
            'penerbit' => 'Media Kita',
            'kategori' => 'Teknologi',
            'stok'     => 2,
            'cover'    => 'https://images.unsplash.com/photo-1542744094-3a31f103e35f?q=80&w=400', // UI/UX design vibe
        ]);

        Book::create([
            'judul'    => 'Sebuah Seni untuk Bersikap Bodo Amat',
            'penulis'  => 'Mark Manson',
            'penerbit' => 'Grasindo',
            'kategori' => 'Pengembangan Diri',
            'stok'     => 4,
            'cover'    => 'https://images.unsplash.com/photo-1531256456869-ce942a665e80?q=80&w=400', // Portrait careless art vibe
        ]);

        Book::create([
            'judul'    => 'Negeri 5 Menara',
            'penulis'  => 'A. Fuadi',
            'penerbit' => 'Gramedia',
            'kategori' => 'Novel',
            'stok'     => 5,
            'cover'    => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=400', // Old mosque/Students tower vibe
        ]);

        // ==========================
        // TRANSAKSI
        // ==========================

        // Skenario 1: Status masih 'pinjam', jatuh tempo sudah lewat 5 hari yang lalu.
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
        Transaction::create([
            'user_id'          => $siswa1->id,
            'book_id'          => $buku2->id,
            'tanggal_pinjam'   => Carbon::now()->subDays(10),
            'tanggal_deadline' => Carbon::now()->subDays(3),
            'tanggal_kembali'  => Carbon::now()->subDays(3),
            'status'           => 'kembali',
        ]);

        // Skenario Tambahan: Status 'pending' (Pengajuan Baru dari Siswa)
        Transaction::create([
            'user_id'          => $siswa2->id,
            'book_id'          => $buku5->id,
            'tanggal_pinjam'   => Carbon::now(),
            'tanggal_deadline' => Carbon::now()->addDays(7),
            'tanggal_kembali'  => null,
            'status'           => 'pending',
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

        // ==========================
        // WISHLIST
        // ==========================
        Wishlist::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku3->id,
        ]);

        Wishlist::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku5->id,
        ]);

        Wishlist::create([
            'user_id' => $siswa2->id,
            'book_id' => $buku1->id,
        ]);
    }
}