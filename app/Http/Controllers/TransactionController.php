<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Book;
use App\Models\Denda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'book', 'denda'])->latest();

        // Filter nama peminjam
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%');
            });
        }

        // Filter status keterlambatan
        if ($request->keterlambatan === 'terlambat') {
            $query->where('status', 'pinjam')
                  ->whereNotNull('tanggal_kembali')
                  ->whereDate('tanggal_kembali', '<', Carbon::today());
        } elseif ($request->keterlambatan === 'tidak_terlambat') {
            $query->where(function ($q) {
                $q->where('status', 'kembali')
                  ->orWhereDate('tanggal_kembali', '>=', Carbon::today());
            });
        }

        // Filter status pinjam/kembali
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $transactions = $query->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::where('role', 'siswa')->get();
        $books = Book::where('stok', '>', 0)->get();
        return view('admin.transactions.create', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'book_id'         => 'required|exists:books,id',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status'          => 'required',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stok < 1) {
            return back()->with('error', 'Stok buku habis!');
        }

        $transaction = Transaction::create([
            'user_id'         => $request->user_id,
            'book_id'         => $request->book_id,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => $request->status,
        ]);

        if ($request->status == 'pinjam') {
            $book->decrement('stok');
        }

        $this->cekDanda($transaction);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $users = User::where('role', 'siswa')->get();
        $books = Book::all();
        return view('admin.transactions.edit', compact('transaction', 'users', 'books'));
    }

    public function update(Request $request, string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $book        = Book::findOrFail($transaction->book_id);

        $request->validate([
            'status'          => 'required',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        if ($transaction->status == 'pinjam' && $request->status == 'kembali') {
            $book->increment('stok');

            if ($transaction->denda && $transaction->denda->status == 'belum_bayar') {
                $transaction->denda->update(['status' => 'lunas']);
            }
        }

        if ($transaction->status == 'kembali' && $request->status == 'pinjam') {
            if ($book->stok < 1) {
                return back()->with('error', 'Stok buku tidak cukup.');
            }
            $book->decrement('stok');
        }

        $transaction->update([
            'user_id'         => $transaction->user_id,
            'book_id'         => $transaction->book_id,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => $request->status,
        ]);

        $this->cekDanda($transaction->fresh());

        return redirect()->route('transactions.index')->with('success', 'Data transaksi diperbarui');
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status == 'pinjam') {
            $transaction->book->increment('stok');
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi dihapus');
    }

    public function dendaIndex()
    {
        $dendas = Denda::with(['transaction.user', 'transaction.book'])
            ->orderBy('status')
            ->latest()
            ->get();

        return view('admin.transactions.index', compact('dendas'));
    }

    public function dendaBayar($id)
    {
        Denda::findOrFail($id)->update(['status' => 'lunas']);
        return redirect()->route('dendas.index')->with('success', 'Denda berhasil dilunasi');
    }

    private function cekDanda(Transaction $transaction): void
    {
        if ($transaction->status !== 'pinjam' || !$transaction->tanggal_kembali) {
            return;
        }

        $hari    = $transaction->hariTerlambat();
        $nominal = Denda::hitungNominal($hari);

        if ($hari > 0) {
            Denda::updateOrCreate(
                ['transaction_id' => $transaction->id],
                ['hari_terlambat' => $hari, 'nominal' => $nominal, 'status' => 'belum_bayar']
            );
        }
    }
}