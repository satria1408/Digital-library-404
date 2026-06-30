<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\Wishlist;
use Carbon\Carbon;
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
     * Dashboard
     */
    public function index(Request $request)
    {
        $books = $this->getFilteredBooks($request);
        $myBooks = $this->getMyBorrowedBooks();

        $totalKoleksi = Book::count();

        $totalDipinjam = $myBooks->where('status', 'pinjam')->count();

        $totalPending = $myBooks->where('status', 'pending')->count();

        $totalWishlist = Wishlist::where('user_id', Auth::id())->count();

        $totalDendaAman = 0;

        foreach ($myBooks->where('status', 'pinjam') as $trans) {

            $deadline = $trans->tanggal_deadline
                ? Carbon::parse($trans->tanggal_deadline)
                : null;

            if ($deadline && Carbon::today()->gt($deadline)) {

                $hariTerlambat = Carbon::today()->diffInDays($deadline);

                $dendaPerHari = match (true) {
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

        $kategoris = Book::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('siswa.dashboard', compact(
            'books',
            'myBooks',
            'kategoris',
            'totalKoleksi',
            'totalDipinjam',
            'totalPending',
            'totalWishlist',
            'totalDendaAman'
        ));
    }

    /**
     * Statistik
     */
    public function showStats(Request $request)
    {
        $books = $this->getFilteredBooks($request);

        $myAllBooks = Transaction::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $totalPernahDipinjam = $myAllBooks->count();

        $sedangDipinjam = $myAllBooks->where('status', 'pinjam')->count();

        $totalDendaAman = 0;

        foreach ($myAllBooks->where('status', 'pinjam') as $trans) {

            $deadline = $trans->tanggal_deadline
                ? Carbon::parse($trans->tanggal_deadline)
                : null;

            if ($deadline && Carbon::today()->gt($deadline)) {

                $hariTerlambat = Carbon::today()->diffInDays($deadline);

                $dendaPerHari = match (true) {
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

        $myBooks = $myAllBooks;

        return view('siswa.partials.stats', compact(
            'books',
            'myBooks',
            'totalPernahDipinjam',
            'sedangDipinjam',
            'totalDendaAman'
        ));
    }

    /**
     * Halaman peminjaman
     */
    public function showPeminjaman(Request $request)
    {
        $books = $this->getFilteredBooks($request, true);

        $myBooks = $this->getMyBorrowedBooks();

        $wishlistIds = $this->getWishlistIds();

        $kategoris = Book::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('siswa.partials.peminjaman', compact(
            'books',
            'myBooks',
            'wishlistIds',
            'kategoris'
        ));
    }

    /**
     * Halaman pengembalian
     */
    public function showPengembalian()
    {
        $myBooks = $this->getMyBorrowedBooks();

        $totalDipinjam = $myBooks->where('status', 'pinjam')->count();

        $totalPending = $myBooks->where('status', 'pending')->count();

        $totalDendaAman = 0;

        foreach ($myBooks->where('status', 'pinjam') as $trans) {

            $deadline = $trans->tanggal_deadline
                ? Carbon::parse($trans->tanggal_deadline)
                : null;

            if ($deadline && Carbon::today()->gt($deadline)) {

                $hariTerlambat = Carbon::today()->diffInDays($deadline);

                $dendaPerHari = match (true) {
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

        return view('siswa.partials.pengembalian', compact(
            'myBooks',
            'totalDipinjam',
            'totalPending',
            'totalDendaAman'
        ));
    }

    /**
     * Proses peminjaman buku
     */
    public function pinjamBuku(Request $request, $book_id)
    {
        $jumlahAktif = Transaction::where('user_id', Auth::id())
            ->whereIn('status', ['pinjam', 'pending'])
            ->count();

        if ($jumlahAktif >= 5) {
            return redirect()->route('siswa.pengembalian')
                ->with('warning', 'Kamu sudah memiliki 5 buku aktif.');
        }

        $sudahPinjam = Transaction::where('user_id', Auth::id())
            ->where('book_id', $book_id)
            ->whereIn('status', ['pinjam', 'pending'])
            ->exists();

        if ($sudahPinjam) {
            return redirect()->route('siswa.pengembalian')
                ->with('warning', 'Buku ini masih kamu pinjam.');
        }

        $request->validate([
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam'
        ]);

        $book = Book::findOrFail($book_id);

        if ($book->stok < 1) {
            return redirect()->back()->with('error', 'Stok buku habis.');
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_deadline' => $request->tanggal_kembali,
            'tanggal_kembali' => null,
            'status' => 'pending'
        ]);

        return redirect()->route('siswa.pengembalian')
            ->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }

    /**
     * Proses pengembalian buku
     */
    public function kembalikanBuku($transaction_id)
    {
        $transaksi = Transaction::where('id', $transaction_id)
            ->where('user_id', Auth::id())
            ->where('status', 'pinjam')
            ->firstOrFail();

        $transaksi->update([
            'tanggal_kembali' => Carbon::now(),
            'status' => 'kembali'
        ]);

        $transaksi->book->increment('stok');

        return redirect()->route('siswa.pengembalian')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}