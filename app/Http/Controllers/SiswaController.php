<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%')
                  ->orWhere('penerbit', 'like', '%' . $request->search . '%');
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $books = $query->latest()->get();

        // Ambil kategori unik untuk dropdown
        $kategoris = Book::select('kategori')
                        ->distinct()
                        ->pluck('kategori');

        // Buku yang sedang dipinjam siswa
        $myBooks = Transaction::with('book')
                    ->where('user_id', Auth::id())
                    ->where('status', 'pinjam')
                    ->get();

        return view('siswa.dashboard', compact(
            'books',
            'myBooks',
            'kategoris'
        ));
    }

    public function pinjamBuku(Request $request, $book_id)
    {
        // 1. Hitung tanggal maksimal peminjaman (30 hari dari tanggal_pinjam yang diinput)
        // Jika input tanggal_pinjam kosong/tidak valid, default menggunakan hari ini sebagai acuan batas
        $tanggalPinjamInput = $request->input('tanggal_pinjam');
        $baseDate = $tanggalPinjamInput ? Carbon::parse($tanggalPinjamInput) : Carbon::today();
        $batasMaksimal = $baseDate->copy()->addDays(30)->format('Y-m-d');

        // 2. Validasi ketat di sisi Backend dengan batas maksimal 1 bulan (30 hari)
        $request->validate([
            'tanggal_pinjam'  => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam|before_or_equal:' . $batasMaksimal,
        ], [
            'tanggal_pinjam.after_or_equal'   => 'Tanggal pinjam tidak boleh tanggal mundur!',
            'tanggal_kembali.after_or_equal'  => 'Tanggal pengembalian tidak boleh sebelum tanggal pinjam!',
            'tanggal_kembali.before_or_equal' => 'Durasi peminjaman buku maksimal adalah 1 bulan (30 hari)!',
        ]);

        $book = Book::findOrFail($book_id);

        if ($book->stok > 0) {

            // 3. Simpan data sesuai struktur kolom baru database
            Transaction::create([
                'user_id'          => Auth::id(),
                'book_id'          => $book_id,
                'tanggal_pinjam'   => $request->tanggal_pinjam,
                'tanggal_deadline' => $request->tanggal_kembali, // Masuk ke tenggat waktu (deadline)
                'tanggal_kembali'  => null,                       // Belum dikembalikan secara riil
                'status'           => 'pinjam'
            ]);

            $book->decrement('stok');

            return back()->with('success', 'Buku berhasil dipinjam');
        }

        return back()->with('error', 'Stok habis!');
    }

    public function kembalikanBuku($transaction_id)
    {
        $transaksi = Transaction::where('id', $transaction_id)
                                ->where('user_id', Auth::id())
                                ->firstOrFail();

        // Mencatat tanggal pemulangan buku hari ini secara riil
        $transaksi->update([
            'tanggal_kembali' => Carbon::now(),
            'status'          => 'kembali'
        ]);

        $transaksi->book->increment('stok');

        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}