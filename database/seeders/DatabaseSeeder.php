<?php

namespace Database\Seeders;

use App\Models\Auth\User;
use App\Models\DigitalLibrary\Admin\Book;
use App\Models\DigitalLibrary\Admin\Transaction;
use App\Models\DigitalLibrary\Admin\Denda;
use App\Models\DigitalLibrary\Wishlist;
use App\Models\DigitalLibrary\Owner\Owner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================
        // DEVELOPER 
        // ==========================
        User::create([
            'nama_lengkap' => 'Satria Developer',
            'username'     => 'developer',
            'password'     => Hash::make('123456'),
            'role'         => 'developer',
            'alamat'       => 'Satria si developer nih genk',
            'nisn'         => null, 
        ]);

        // ==========================
        // OWNER (Tambahan Baru Terintegrasi Relasi)
        // ==========================
        $ownerUser = User::create([
            'nama_lengkap' => 'Satria Owner Utama',
            'username'     => 'owner',
            'password'     => Hash::make('123456'),
            'role'         => 'owner',
            'alamat'       => 'Kantor Owner Perpustakaan',
            'nisn'         => null, // Bukan siswa, kosongkan
        ]);

        Owner::create([
            'user_id'       => $ownerUser->id, // Mengikat ID dari user di atas
            'no_telepon'    => '081234567890',
            'alamat_kantor' => 'Ruang Kepala Yayasan / Sekolah',
        ]);

        // ==========================
        // ADMIN
        // ==========================
        User::create([
            'nama_lengkap' => 'Administrator Utama',
            'username'     => 'admin',
            'password'     => Hash::make('123456'),
            'role'         => 'admin',
            'alamat'       => 'Ruang Admin Perpustakaan',
            'nisn'         => null, // Bukan siswa, kosongkan
        ]);

        // ==========================
        // SISWA (Ditambahkan NISN dummy 10 digit)
        // ==========================
        $siswa1 = User::create([
            'nama_lengkap' => 'Budi Santoso',
            'username'     => 'siswa',
            'password'     => Hash::make('123456'),
            'role'         => 'siswa',
            'alamat'       => 'Jl. Mawar No. 10',
            'nisn'         => '0041234561', // Tambahkan NISN unik
        ]);

        $siswa2 = User::create([
            'nama_lengkap' => 'Siti Aminah',
            'username'     => 'siti123',
            'password'     => Hash::make('123456'),
            'role'         => 'siswa',
            'alamat'       => 'Jl. Melati No. 5',
            'nisn'         => '0041234562', // Tambahkan NISN unik
        ]);

        // ==========================
        // BUKU (Total: 12 Buku dengan ISBN & cover_url)
        // ==========================
        $buku1 = Book::create([
            'isbn'      => '9786020523315',
            'judul'     => 'Belajar Laravel 10 untuk Pemula',
            'penulis'   => 'Taylor Otwell',
            'penerbit'  => 'Laravel Press',
            'kategori'  => 'Teknologi',
            'stok'      => 5,
            'cover_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=400', 
        ]);

        $buku2 = Book::create([
            'isbn'      => '9789791227025',
            'judul'     => 'Laskar Pelangi',
            'penulis'   => 'Andrea Hirata',
            'penerbit'  => 'Bentang Pustaka',
            'kategori'  => 'Novel',
            'stok'      => 3,
            'cover_url' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=400', 
        ]);

        $buku3 = Book::create([
            'isbn'      => '9786020633657',
            'judul'     => 'Filosofi Teras',
            'penulis'   => 'Henry Manampiring',
            'penerbit'  => 'Kompas',
            'kategori'  => 'Pengembangan Diri',
            'stok'     => 10,
            'cover_url' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=400', 
        ]);

        Book::create([
            'isbn'      => '9789792206967',
            'judul'     => 'Harry Potter dan Batu Bertuah',
            'penulis'   => 'J.K. Rowling',
            'penerbit'  => 'Gramedia',
            'kategori'  => 'Fiksi',
            'stok'      => 0,
            'cover_url' => 'https://images.unsplash.com/photo-1510172951991-856a654063f9?q=80&w=400', 
        ]);

        $buku5 = Book::create([
            'isbn'      => '9780132350884',
            'judul'     => 'Clean Code',
            'penulis'   => 'Robert C. Martin',
            'penerbit'  => 'Prentice Hall',
            'kategori'  => 'Teknologi',
            'stok'      => 4,
            'cover_url' => 'https://images.unsplash.com/photo-1629654297299-c8506221ca97?q=80&w=400', 
        ]);

        Book::create([
            'isbn'      => '9789799731234',
            'judul'     => 'Bumi Manusia',
            'penulis'   => 'Pramoedya Ananta Toer',
            'penerbit'  => 'Lentera Dipantara',
            'kategori'  => 'Novel',
            'stok'      => 6,
            'cover_url' => 'https://images.unsplash.com/photo-1461360370896-922624d12aa1?q=80&w=400', 
        ]);

        Book::create([
            'isbn'      => '9786020635088',
            'judul'     => 'Atomic Habits',
            'penulis'   => 'James Clear',
            'penerbit'  => 'Gramedia',
            'kategori'  => 'Pengembangan Diri',
            'stok'      => 8,
            'cover_url' => 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?q=80&w=400', 
        ]);

        Book::create([
            'isbn'      => '9786020822112',
            'judul'     => 'Pulang',
            'penulis'   => 'Tere Liye',
            'penerbit'  => 'Sabak Grip',
            'kategori'  => 'Novel',
            'stok'      => 5,
            'cover_url' => 'https://images.unsplash.com/photo-1488085061387-422e29b40080?q=80&w=400', 
        ]);

        Book::create([
            'isbn'      => '9786020165891',
            'judul'     => 'Dilan 1990',
            'penulis'   => 'Pidi Baiq',
            'penerbit'  => 'Pastel Books',
            'kategori'  => 'Novel',
            'stok'      => 7,
            'cover_url' => 'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?q=80&w=400', 
        ]);

        Book::create([
            'isbn'      => '9786020542744',
            'judul'     => 'Canva Pro Design Guide',
            'penulis'   => 'Rizki Agung',
            'penerbit'  => 'Media Kita',
            'kategori'  => 'Teknologi',
            'stok'      => 2,
            'cover_url' => 'https://images.unsplash.com/photo-1542744094-3a31f103e35f?q=80&w=400', 
        ]);

        Book::create([
            'isbn'      => '9786020531256',
            'judul'     => 'Sebuah Seni untuk Bersikap Bodo Amat',
            'penulis'   => 'Mark Manson',
            'penerbit'  => 'Grasindo',
            'kategori'  => 'Pengembangan Diri',
            'stok'      => 4,
            'cover_url' => 'https://images.unsplash.com/photo-1531256456869-ce942a665e80?q=80&w=400', 
        ]);

        Book::create([
            'isbn'      => '9789791227445',
            'judul'     => 'Negeri 5 Menara',
            'penulis'   => 'A. Fuadi',
            'penerbit'  => 'Gramedia',
            'kategori'  => 'Novel',
            'stok'      => 5,
            'cover_url' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=400', 
        ]);

        // ==========================
        // TRANSAKSI
        // ==========================
        $trx1 = Transaction::create([
            'user_id'          => $siswa1->id,
            'book_id'          => $buku1->id,
            'tanggal_pinjam'   => Carbon::now()->subDays(12),
            'tanggal_deadline' => Carbon::now()->subDays(5), 
            'tanggal_kembali'  => null, 
            'status'           => 'pinjam',
        ]);
        $buku1->decrement('stok');

        $trx2 = Transaction::create([
            'user_id'          => $siswa2->id,
            'book_id'          => $buku2->id,
            'tanggal_pinjam'   => Carbon::now()->subDays(17),
            'tanggal_deadline' => Carbon::now()->subDays(10),
            'tanggal_kembali'  => null,
            'status'           => 'pinjam',
        ]);
        $buku2->decrement('stok');

        Transaction::create([
            'user_id'          => $siswa1->id,
            'book_id'          => $buku2->id,
            'tanggal_pinjam'   => Carbon::now()->subDays(10),
            'tanggal_deadline' => Carbon::now()->subDays(3),
            'tanggal_kembali'  => Carbon::now()->subDays(3),
            'status'           => 'kembali',
        ]);

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
            'nominal'        => Denda::hitungNominal(5),
            'status'         => 'belum_bayar',
        ]);

        Denda::create([
            'transaction_id' => $trx2->id,
            'hari_terlambat' => 10,
            'nominal'        => Denda::hitungNominal(10),
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

        // ==========================
        // WISHLIST SISWA 2
        // ==========================
        Wishlist::create([
            'user_id' => $siswa2->id,
            'book_id' => $buku1->id,
        ]);

        // ==========================
        // KOTAK SARAN DEVELOPER
        // ==========================
        $this->call([
            SuggestionSeeder::class,
        ]);
    }
}