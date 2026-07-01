<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // ◄ Tambah ini untuk handle hapus file

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Kita ubah paginate jadi 6 atau sesuai selera biar pas di grid/tabel
        $books = $query->latest()->paginate(10)->withQueryString();

        $kategoris = Book::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('admin.books.index', compact(
            'books',
            'kategoris'
        ));
    }

    public function create()
    {
        $kategoris = Book::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('admin.books.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'    => 'required|string|max:255',
            'penulis'  => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'stok'     => 'required|integer|min:0',
            'cover'    => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048', // ◄ Validasi Cover Gambar (Max 2MB)
        ]);

        // Proses upload file jika ada cover yang diunggah
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Simpan file fisik ke: storage/app/public/covers/
            $file->storeAs('public/covers', $filename);
            
            // Masukkan nama filenya ke dalam array data yang divalidasi
            $validated['cover'] = $filename;
        }

        Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);

        $kategoris = Book::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('admin.books.edit', compact(
            'book',
            'kategoris'
        ));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul'    => 'required|string|max:255',
            'penulis'  => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'stok'     => 'required|integer|min:0',
            'cover'    => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048', // ◄ Validasi Cover Gambar
        ]);

        $book = Book::findOrFail($id);

        // Proses update file cover baru jika ada yang diupload
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Simpan cover baru
            $file->storeAs('public/covers', $filename);

            // Hapus file cover yang lama jika berupa file lokal (bukan link seeder)
            if ($book->cover && !filter_var($book->cover, FILTER_VALIDATE_URL)) {
                Storage::delete('public/covers/' . $book->cover);
            }

            $validated['cover'] = $filename;
        }

        $book->update($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Hapus file fisik cover dari storage lokal sebelum menghapus data di DB
        if ($book->cover && !filter_var($book->cover, FILTER_VALIDATE_URL)) {
            Storage::delete('public/covers/' . $book->cover);
        }

        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}