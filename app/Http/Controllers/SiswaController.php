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
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%')
                  ->orWhere('penerbit', 'like', '%' . $request->search . '%');
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
     */
    public function index(Request $request)
    {
        $books = $this->getFilteredBooks($request);
        $myBooks = $this->getMyBorrowedBooks();
        
        $kategoris = Book::select('kategori')->distinct()->pluck('kategori');

        return view('siswa.dashboard', compact('books', 'myBooks', 'kategoris'));
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
        
        $kategoris = Book::select('kategori')->distinct()->pluck('kategori');

        return view('siswa.partials.peminjaman', compact('books', 'myBooks', 'kategoris'));
    }

    /**
     * Hanya Menampilkan Halaman Tabel Pengembalian
     */
    public function showPengembalian()
    {
        $myBooks = $this->getMyBorrowedBooks();

        return view('siswa.partials.pengembalian', compact('myBooks'));
    }


    /* =========================================================================
     * 2. LOGIKA PROSES (DISESUAIKAN KE KONSEP PENDING)
     * ========================================================================= */

    /**
     * Proses Pinjam Buku (Validasi Tanggal & Set Status Pending)
     */
    public function pinjamBuku(Request $request, $book_id)
    {
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

            // ⚠️ STOK TIDAK DI-DECREMENT DI SINI, stok baru berkurang saat disetujui Admin di TransactionController

            // Redirect langsung melempar ke halaman Pengembalian bawa flash message sukses pending
            return redirect()->route('siswa.pengembalian')->with('success', 'Permintaan peminjaman berhasil dikirim! Menunggu persetujuan admin.');
        }

        return back()->with('error', 'Stok habis!');
    }

    /**
     * Proses Kembalikan Buku (Penambahan Stok)
     */
    public function kembalikanBuku($transaction_id)
    {
        $transaksi = Transaction::where('id', $transaction_id)
                                ->where('user_id', Auth::id())
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