<?php

namespace App\Http\Controllers\DigitalLibrary\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Transaction\StoreTransactionRequest;
use App\Http\Requests\Admin\Transaction\UpdateTransactionRequest;
use App\Models\Auth\User;
use App\Models\DigitalLibrary\Admin\Transaction;
use App\Models\DigitalLibrary\Admin\Book;
use App\Models\DigitalLibrary\Admin\Denda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'book', 'denda'])->latest();

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->keterlambatan === 'terlambat') {
            $query->where('status', 'pinjam')
                  ->whereDate('tanggal_deadline', '<', Carbon::today());
        } elseif ($request->keterlambatan === 'tidak_terlambat') {
            $query->where(function ($q) {
                $q->where('status', 'kembali')
                  ->orWhereDate('tanggal_deadline', '>=', Carbon::today());
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $transactions = $query->get();

        return view('digital_library.admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::where('role', 'siswa')->get();
        $books = Book::where('stok', '>', 0)->get();
        return view('digital_library.admin.transactions.create', compact('users', 'books'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $validated = $request->validated();

        $book = Book::findOrFail($validated['book_id']);

        if ($book->stok < 1) {
            return back()->with('error', 'Stok buku habis!');
        }

        $tanggalKembaliRiil = ($validated['status'] == 'kembali') ? Carbon::today() : null;

        $transaction = Transaction::create([
            'user_id'          => $validated['user_id'],
            'book_id'          => $validated['book_id'],
            'tanggal_pinjam'   => $validated['tanggal_pinjam'],
            'tanggal_deadline' => $validated['tanggal_kembali'],
            'tanggal_kembali'  => $tanggalKembaliRiil,
            'status'           => $validated['status'],
        ]);

        if ($validated['status'] == 'pinjam') {
            $book->decrement('stok');
        }

        $this->cekDenda($transaction);

        return redirect()->route('digitallibrary.admin.transactions.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $users = User::where('role', 'siswa')->get();
        $books = Book::all();
        return view('digital_library.admin.transactions.edit', compact('transaction', 'users', 'books'));
    }

    public function update(UpdateTransactionRequest $request, string $id)
    {
        $validated = $request->validated();
        
        $transaction = Transaction::findOrFail($id);
        $book        = Book::findOrFail($transaction->book_id);

        $tanggalKembaliRiil = $transaction->tanggal_kembali;

        if ($transaction->status == 'pinjam' && $validated['status'] == 'kembali') {
            $book->increment('stok');
            $tanggalKembaliRiil = Carbon::today();

            if ($transaction->denda && $transaction->denda->status == 'belum_bayar') {
                $transaction->denda->update(['status' => 'lunas']);
            }
        }

        if ($transaction->status == 'kembali' && $validated['status'] == 'pinjam') {
            if ($book->stok < 1) {
                return back()->with('error', 'Stok buku tidak cukup.');
            }
            $book->decrement('stok');
            $tanggalKembaliRiil = null;
        }

        $transaction->update([
            'user_id'          => $transaction->user_id,
            'book_id'          => $transaction->book_id,
            'tanggal_pinjam'   => $validated['tanggal_pinjam'],
            'tanggal_deadline' => $validated['tanggal_kembali'],
            'tanggal_kembali'  => $tanggalKembaliRiil,
            'status'           => $validated['status'],
        ]);

        $this->cekDenda($transaction->fresh());

        return redirect()->route('digitallibrary.admin.transactions.index')->with('success', 'Data transaksi diperbarui');
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status == 'pinjam') {
            $transaction->book->increment('stok');
        }

        $transaction->delete();

        return redirect()->route('digitallibrary.admin.transactions.index')->with('success', 'Transaksi dihapus');
    }

    private function cekDenda(Transaction $transaction): void
    {
        if ($transaction->status !== 'pinjam') {
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

    public function setujuiPinjaman($id)
    {
        $transaction = Transaction::findOrFail($id);
        $book = Book::findOrFail($transaction->book_id);

        if ($book->stok < 1) {
            return redirect()->back()->with('error', 'Gagal menyetujui. Stok buku ini sudah habis!');
        }

        $transaction->update(['status' => 'pinjam']);
        $book->decrement('stok');

        return redirect()->back()->with('success', 'Permintaan peminjaman buku berhasil disetujui!');
    }

    public function tolakPinjaman($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'ditolak']);

        return redirect()->back()->with('info', 'Permintaan peminjaman buku telah ditolak.');
    }
}