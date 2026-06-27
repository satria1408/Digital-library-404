<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Helper privat untuk mengambil data dasar (Search & Filter Kategori)
     * Agar kita tidak menulis ulang query yang sama di setiap method view.
     */
    private function getFilteredBooks(Request $request, bool $paginate = false)
    {
        $query = Book::query();

        // Logika Search bawaan kamu
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('penerbit', 'like', '%' . $search . '%');
            });
        }

        // Logika Filter Kategori bawaan kamu
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        return $paginate
            ? $query->latest()->paginate(10)->withQueryString()
            : $query->latest()->get();
    }

    /**
     * Helper privat untuk mengambil daftar buku yang diproses siswa
     * PERBAIKAN: Mengambil data status 'pinjam' DAN status 'pending' agar muncul di halaman pengembalian
     */
    private function getMyBorrowedBooks()
    {
        return Transaction::with('book')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pinjam', 'pending']) // 👈 Menampilkan yang aktif dipinjam & yang masih pending
            ->latest()
            ->get();
    }


    /* =========================================================================
     * 1. METHOD UNTUK MENAMPILKAN VIEW (YANG SUDAH DIPOTONG-POTONG)
     * ========================================================================= */

    /**
     * Main Dashboard (Halaman Utama / Landing)
     * ◄ REVISI: Tambah kalkulasi statistik dinamis untuk bagian atas dashboard siswa
     */
    public function index(Request $request)
    {
        $books = $this->getFilteredBooks($request);
        $myBooks = $this->getMyBorrowedBooks();
        
        // 1. Hitung total seluruh koleksi buku yang tersedia di perpustakaan
        $totalKoleksi = Book::count();

        // 2. Hitung total buku milik siswa yang sedang berstatus dipinjam
        $totalDipinjam = $myBooks->where('status', 'pinjam')->count();

        // 3. Hitung total pengajuan peminjaman siswa yang masih pending
        $totalPending = $myBooks->where('status', 'pending')->count();

        // 4. Hitung akumulasi total denda berjalan siswa menggunakan rumus bertingkat
        $totalDendaAman = 0;
        foreach ($myBooks->where('status', 'pinjam') as $trans) {
            $deadline = $trans->tanggal_deadline ? Carbon::parse($trans->tanggal_deadline) : null;
            $today = Carbon::today();
            
            if ($deadline && $today->gt($deadline)) {
                $hariTerlambat = $today->diffInDays($deadline);
                
                $dendaPerHari = match(true) {
                    $hariTerlambat >= 30 => 10000,
                    $hariTerlambat >= 14 => 8000,
                    $hariTerlambat >= 7  => 5000,
                    $hariTerlambat >= 3  => 2000,
                    $hariTerlambat >= 1  => 1000,
                    default              => 0,
                };
                $totalDendaAman += ($hariTerlambat * $dendaPerHari);
            }
        }

        // Mengambil kategori dinamis dari DB agar sinkron dengan seeder baru
        $kategoris = Book::select('kategori')->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        // Di-compact semuanya agar bisa dibaca langsung oleh component row atas di dashboard.blade.php
        return view('siswa.dashboard', compact('books', 'myBooks', 'kategoris', 'totalKoleksi', 'totalDipinjam', 'totalPending', 'totalDendaAman'));
    }

    /**
     * Hanya Menampilkan Halaman Statistik Mandiri
     */
    public function showStats(Request $request)
    {
        $books = $this->getFilteredBooks($request);
        $myBooks = $this->getMyBorrowedBooks();

        return view('siswa.partials.stats', compact('books', 'myBooks'));
    }

    /**
     * Hanya Menampilkan Halaman Peminjaman & Modal Kalender
     */
    public function showPeminjaman(Request $request)
    {
        $books = $this->getFilteredBooks($request, paginate: true);
        $myBooks = $this->getMyBorrowedBooks(); 
        
        // Mengambil kategori dinamis dari DB agar sinkron dengan seeder baru
        $kategoris = Book::select('kategori')->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('siswa.partials.peminjaman', compact('books', 'myBooks', 'kategoris'));
    }

    /**
     * Hanya Menampilkan Halaman Tabel Pengembalian
     */
    public function showPengembalian()
    {
        $myBooks = $this->getMyBorrowedBooks();

        // 1. Hitung total buku yang beneran lagi dipinjam (status pinjam)
        $totalDipinjam = $myBooks->where('status', 'pinjam')->count();

        // 2. Hitung total form peminjaman yang nunggu konfirmasi admin (status pending)
        $totalPending = $myBooks->where('status', 'pending')->count();

        // 3. Hitung akumulasi total rupiah denda berjalan dari semua buku terlambat siswa ini
        $totalDendaAman = 0;
        foreach ($myBooks->where('status', 'pinjam') as $trans) {
            $deadline = $trans->tanggal_deadline ? Carbon::parse($trans->tanggal_deadline) : null;
            $today = Carbon::today();
            
            if ($deadline && $today->gt($deadline)) {
                $hariTerlambat = $today->diffInDays($deadline);
                
                $dendaPerHari = match(true) {
                    $hariTerlambat >= 30 => 10000,
                    $hariTerlambat >= 14 => 8000,
                    $hariTerlambat >= 7  => 5000,
                    $hariTerlambat >= 3  => 2000,
                    $hariTerlambat >= 1  => 1000,
                    default              => 0,
                };
                $totalDendaAman += ($hariTerlambat * $dendaPerHari);
            }
        }

        // Passing semua variabel kalkulasi ke View agar sinkron kinerjanya
        return view('siswa.partials.pengembalian', compact('myBooks', 'totalDipinjam', 'totalPending', 'totalDendaAman'));
    }


    /* =========================================================================
     * 2. LOGIKA PROSES (DISESUAIKAN KE KONSEP PENDING)
     * ========================================================================= */

    /**
     * Proses Pinjam Buku (Validasi Tanggal & Set Status Pending)
     */
    public function pinjamBuku(Request $request, $book_id)
    {
        // =========================================================
        // VALIDASI OWNERSHIP 1: Batasan maksimal 5 buku aktif
        // =========================================================
        $jumlahAktif = Transaction::where('user_id', Auth::id())
                                  ->whereIn('status', ['pinjam', 'pending'])
                                  ->count();

        if ($jumlahAktif >= 5) {
            return redirect()->route('siswa.pengembalian')
                             ->with('warning', 'Kamu sudah memiliki 5 buku aktif. Kembalikan salah satu sebelum meminjam lagi.');
        }

        // =========================================================
        // VALIDASI OWNERSHIP 2: Cek buku yang sama belum dikembalikan
        // =========================================================
        $sudahPinjam = Transaction::where('user_id', Auth::id())
                                  ->where('book_id', $book_id)
                                  ->whereIn('status', ['pinjam', 'pending'])
                                  ->exists();

        if ($sudahPinjam) {
            return redirect()->route('siswa.pengembalian')
                             ->with('warning', 'Kamu masih memiliki pinjaman buku ini yang belum dikembalikan.');
        }

        $tanggalPinjamInput = $request->input('tanggal_pinjam');
        $baseDate = $tanggalPinjamInput ? Carbon::parse($tanggalPinjamInput) : Carbon::today();
        $batasMaksimal = $baseDate->copy()->addDays(30)->format('Y-m-d');

        $request->validate([
            'tanggal_pinjam'  => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ], [
            'tanggal_pinjam.after_or_equal'   => 'Tanggal pinjam tidak boleh tanggal mundur!',
            'tanggal_kembali.after_or_equal'  => 'Tanggal pengembalian tidak boleh sebelum tanggal pinjam!',
        ]);

        $book = Book::findOrFail($book_id);

        if ($book->stok > 0) {
            // Membuat transaksi baru dengan status 'pending'
            Transaction::create([
                'user_id'          => Auth::id(),
                'book_id'          => $book_id,
                'tanggal_pinjam'   => $request->tanggal_pinjam,
                'tanggal_deadline' => $request->tanggal_kembali, 
                'tanggal_kembali'  => null,                       
                'status'           => 'pending' // 👈 STATUS BERUBAH JADI PENDING
            ]);

            // Redirect langsung melempar ke halaman Pengembalian bawa flash message sukses pending
            return redirect()->route('siswa.pengembalian')->with('success', 'Permintaan peminjaman berhasil dikirim! Menunggu persetujuan admin.');
        }

        return redirect()->route('siswa.pengembalian')->with('error', 'Stok habis!');
    }

    /**
     * Proses Kembalikan Buku (Penambahan Stok)
     */
    public function kembalikanBuku($transaction_id)
    {
        // =========================================================
        // VALIDASI OWNERSHIP 3: Pastikan transaksi milik siswa ini
        // dan statusnya benar-benar 'pinjam' (bukan pending/kembali)
        // =========================================================
        $transaksi = Transaction::where('id', $transaction_id)
                                ->where('user_id', Auth::id())
                                ->where('status', 'pinjam') // 👈 Hanya bisa kembalikan yang sudah disetujui admin
                                ->firstOrFail();

        $transaksi->update([
            'tanggal_kembali' => Carbon::now(),
            'status'          => 'kembali'
        ]);

        $transaksi->book->increment('stok');

        // Mengembalikan ke halaman tabel pengembalian lagi setelah sukses mengembalikan buku
        return redirect()->route('siswa.pengembalian')->with('success', 'Buku berhasil dikembalikan');
    }
}