<?php

namespace App\Http\Controllers\siswa; // SINKRON: Folder siswa huruf kecil

use App\Http\Controllers\Controller; // PENTING: Panggil file induk sejajar SecurityLog
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Dipakai untuk menyamakan format tanggal dengan admin

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
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('penulis', 'like', '%' . $search . '%')
                    ->orWhere('penerbit', 'like', '%' . $search . '%');
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
     * Dashboard Siswa
     */
    public function index(Request $request)
    {
        $books = $this->getFilteredBooks($request);
        $myBooks = $this->getMyBorrowedBooks();

        $totalKoleksi = Book::count();
        $totalDipinjam = $myBooks->where('status', 'pinjam')->count();
        $totalPending = $myBooks->where('status', 'pending')->count();
        $totalWishlist = Wishlist::where('user_id', Auth::id())->count();

        $kategoris = Book::select('kategori')->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('siswa.dashboard', compact(
            'books', 'myBooks', 'kategoris', 'totalKoleksi',
            'totalDipinjam', 'totalPending', 'totalWishlist'
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

        return view('siswa.partials.stats', compact(
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

        return view('siswa.partials.peminjaman', compact('books', 'myBooks', 'wishlistIds', 'kategoris'));
    }

    /**
     * Halaman Pengembalian
     */
    public function showPengembalian()
    {
        $myBooks = $this->getMyBorrowedBooks();

        $totalDipinjam = $myBooks->where('status', 'pinjam')->count();
        $totalPending = $myBooks->where('status', 'pending')->count();

        return view('siswa.partials.pengembalian', compact('myBooks', 'totalDipinjam', 'totalPending'));
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI PROSES UTAMA (SINKRON DENGAN STRUKTUR SEEDER / ADMIN)
    |--------------------------------------------------------------------------
    */

    /**
     * Proses pengajuan pinjam buku oleh siswa (Status awal: pending)
     */
    public function pinjamBuku(Request $request, $book_id)
    {
        $book = Book::findOrFail($book_id);

        if ($book->stok < 1) {
            return back()->with('error', 'Stok buku habis!');
        }

        Transaction::create([
            'user_id'          => Auth::id(),
            'book_id'          => $book->id,
            'tanggal_pinjam'   => Carbon::today(),
            'tanggal_deadline' => Carbon::today()->addDays(7), // Default tenggat waktu 1 minggu
            'tanggal_kembali'  => null,                         // Null karena baru mengajukan pinjam
            'status'           => 'pending',                    // Status masuk ke sistem approval admin lu
        ]);

        return redirect()->back()->with('success', 'Pengajuan peminjaman buku berhasil dikirim!');
    }

    /**
     * Proses pengembalian buku oleh siswa
     */
    public function kembalikanBuku($transaction_id)
    {
        $transaction = Transaction::findOrFail($transaction_id);

        // Menyamakan struktur pengisian data tanggal_kembali dan status dengan update() admin
        $transaction->update([
            'tanggal_kembali'  => Carbon::today(),
            'status'           => 'kembali',
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
    }
}