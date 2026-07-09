<?php

namespace App\Http\Controllers\DigitalLibrary\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DigitalLibrary\Admin\Book;
use App\Models\DigitalLibrary\Admin\Transaction;
use App\Models\DigitalLibrary\Wishlist;
use App\Models\DigitalLibrary\Admin\Denda; // Sesuai Seeder
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Helper mengambil data buku beserta search dan filter kategori
     */
    private function getFilteredBooks(Request $request, bool $paginate = false)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%'.$search.'%')
                    ->orWhere('penulis', 'like', '%'.$search.'%')
                    ->orWhere('penerbit', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        return $paginate
            ? $query->latest()->paginate(10)->withQueryString()
            : $query->latest()->get();
    }

    /**
     * Helper mengambil buku yang sedang dipinjam / pending
     */
    private function getMyBorrowedBooks()
    {
        return Transaction::with('book')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pinjam', 'pending'])
            ->latest()
            ->get();
    }

    /**
     * Helper mengambil ID buku yang ada di wishlist
     */
    private function getWishlistIds()
    {
        return Wishlist::where('user_id', Auth::id())
            ->pluck('book_id')
            ->toArray();
    }

    /**
     * =========================================================================
     * 1. HALAMAN UTAMA ONESCHOOL HUB
     * =========================================================================
     * Menampilkan gerbang utama dengan 2 modul besar (Perpus & Pengaduan)
     */
    public function index()
    {
        // INI UNTUK HALAMAN HUB UTAMA (2 TOMBOL RAKSASA DI VIDEO LO)
        return view('digital_library.siswa.dashboard');
    }

    /**
     * =========================================================================
     * 2. SUB-DASHBOARD PERPUSTAKAAN DIGITAL (DigiLib)
     * =========================================================================
     * Menampilkan data statistik perpus, filter buku, kategori, dan denda
     */
    public function digitalLibraryIndex(Request $request)
    {
        $userId = Auth::id();
        
        $books = $this->getFilteredBooks($request);
        $myBooks = $this->getMyBorrowedBooks();

        $totalKoleksi = Book::count();
        $totalDipinjam = $myBooks->where('status', 'pinjam')->count();
        $totalPending = $myBooks->where('status', 'pending')->count();
        $totalWishlist = Wishlist::where('user_id', $userId)->count();

        // Sesuai Seeder
        $totalDendaAman = Denda::whereHas('transaction', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('status', 'belum_bayar')
            ->sum('nominal') ?? 0;

        $kategoris = Book::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        // INI FIX-NYA, BRO! JALUR VIEW-NYA MANGGIL DASHBOARD SUB-MODUL PERPUS LO
        return view('digital_library.siswa.dashboard', compact(
            'books', 'myBooks', 'kategoris', 'totalKoleksi',
            'totalDipinjam', 'totalPending', 'totalWishlist', 'totalDendaAman'
        ));
    }

    /**
     * Statistik Siswa
     */
    public function showStats(Request $request)
    {
        $books = $this->getFilteredBooks($request);
        $myAllBooks = Transaction::with('book')->where('user_id', Auth::id())->latest()->get();

        $totalPernahDipinjam = $myAllBooks->count();
        $sedangDipinjam = $myAllBooks->where('status', 'pinjam')->count();

        $myBooks = $myAllBooks;

        return view('digital_library.siswa.partials.stats', compact(
            'books', 'myBooks', 'totalPernahDipinjam', 'sedangDipinjam'
        ));
    }

    /**
     * Halaman Peminjaman
     */
    public function showPeminjaman(Request $request)
    {
        $books = $this->getFilteredBooks($request, true);
        $myBooks = $this->getMyBorrowedBooks();
        $wishlistIds = $this->getWishlistIds();

        $kategoris = Book::select('kategori')->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('digital_library.siswa.partials.peminjaman', compact('books', 'myBooks', 'wishlistIds', 'kategoris'));
    }

    /**
     * Halaman Pengembalian
     */
    public function showPengembalian()
    {
        $myBooks = $this->getMyBorrowedBooks();

        $totalDipinjam = $myBooks->where('status', 'pinjam')->count();
        $totalPending = $myBooks->where('status', 'pending')->count();

        return view('digital_library.siswa.partials.pengembalian', compact('myBooks', 'totalDipinjam', 'totalPending'));
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI PROSES UTAMA
    |--------------------------------------------------------------------------
    */

    /**
     * Proses pengajuan pinjam buku oleh siswa
     */
    public function pinjamBuku(Request $request, $book_id)
    {
        $book = Book::findOrFail($book_id);

        if ($book->stok < 1) {
            return back()->with('error', 'Stok buku habis!');
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'tanggal_pinjam' => Carbon::today(),
            'tanggal_deadline' => Carbon::today()->addDays(7),
            'tanggal_kembali' => null,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengajuan peminjaman buku berhasil dikirim!');
    }

    /**
     * Proses pengembalian buku oleh siswa
     */
    public function kembalikanBuku($transaction_id)
    {
        $transaction = Transaction::findOrFail($transaction_id);

        $transaction->update([
            'tanggal_kembali' => Carbon::today(),
            'status' => 'kembali',
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
    }
}