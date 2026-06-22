<?php 
 
namespace App\Http\Controllers; 
 
use App\Models\Transaction; 
use App\Models\User; 
use App\Models\Book; 
use Illuminate\Http\Request; 
use Carbon\Carbon; 
 
class TransactionController extends Controller 
{ 
    // READ: Tampilkan semua transaksi 
    public function index() 
    { 
        $transactions = Transaction::with(['user', 'book'])->latest()->get(); 
        return view('admin.transactions.index', compact('transactions')); 
    } 
 
    // CREATE: Form tambah transaksi 
    public function create() 
    { 
        $users = User::where('role', 'siswa')->get(); // Ambil data siswa saja 
        $books = Book::where('stok', '>', 0)->get(); // Ambil buku yang ada stoknya 
        return view('admin.transactions.create', compact('users', 'books')); 
    } 
 
    // STORE: Simpan transaksi baru 
    public function store(Request $request) 
    { 
        $request->validate([ 
            'user_id' => 'required|exists:users,id', 
            'book_id' => 'required|exists:books,id', 
            'tanggal_pinjam' => 'required|date', 
            'status' => 'required' 
        ]); 
 
        // Cek stok buku lagi untuk keamanan 
        $book = Book::findOrFail($request->book_id); 
         
        if ($book->stok < 1) { 
            return back()->with('error', 'Stok buku habis!'); 
        } 
 
        Transaction::create([ 
            'user_id' => $request->user_id, 
            'book_id' => $request->book_id, 
            'tanggal_pinjam' => $request->tanggal_pinjam, 
            'tanggal_kembali' => ($request->status == 'kembali') ? Carbon::now() : null, 
            'status' => $request->status 
        ]); 
 
        // Kurangi stok jika statusnya pinjam 
        if ($request->status == 'pinjam') { 
            $book->decrement('stok'); 
        } 
 
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil 
ditambahkan'); 
    } 
 
    // EDIT: Form edit transaksi 
    public function edit(string $id) 
    { 
        $transaction = Transaction::findOrFail($id); 
        $users = User::where('role', 'siswa')->get(); 
      $books = Book::all(); // Tampilkan semua buku (termasuk yg stok 0, karena ini edit) 
        return view('admin.transactions.edit', compact('transaction', 'users', 'books')); 
    } 
 
    // UPDATE: Simpan perubahan 
    public function update(Request $request, string $id) 
    { 
        $transaction = Transaction::findOrFail($id); 
        $book = Book::findOrFail($transaction->book_id); 
 
        $request->validate([ 
            'status' => 'required', 
            'tanggal_pinjam' => 'required|date' 
        ]); 
 
        // Logika Perubahan Stok berdasarkan perubahan Status 
        // 1. Jika dulunya 'pinjam' -> sekarang diubah 'kembali' (Barang balik) 
        if ($transaction->status == 'pinjam' && $request->status == 'kembali') { 
            $book->increment('stok'); 
            $request->merge(['tanggal_kembali' => Carbon::now()]); 
        } 
         
        // 2. Jika dulunya 'kembali' -> sekarang diubah 'pinjam' (Salah input/batal kembali) 
        if ($transaction->status == 'kembali' && $request->status == 'pinjam') { 
            if ($book->stok > 0) { 
                $book->decrement('stok'); 
                $request->merge(['tanggal_kembali' => null]); 
            } else { 
                return back()->with('error', 'Stok buku tidak cukup untuk mengubah status menjadi 
Pinjam.'); 
            } 
        } 
 
        $transaction->update($request->all()); 
 
        return redirect()->route('transactions.index')->with('success', 'Data transaksi diperbarui'); 
    } 
 
    // DELETE: Hapus transaksi 
    public function destroy(string $id) 
    { 
        $transaction = Transaction::findOrFail($id); 
         
        // Jika menghapus data yang statusnya masih 'pinjam', kembalikan stoknya 
        if ($transaction->status == 'pinjam') { 
            $transaction->book->increment('stok'); 
        } 
 
        $transaction->delete(); 
        return redirect()->route('transactions.index')->with('success', 'Transaksi dihapus'); 
    } 
} 