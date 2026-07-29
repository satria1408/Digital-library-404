<?php

namespace App\Http\Controllers\DigitalLibrary\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Book\StoreBookRequest;
use App\Http\Requests\Admin\Book\UpdateBookRequest;
use App\Models\DigitalLibrary\Admin\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $books = $query->latest()->paginate(10)->withQueryString();

        $kategoris = Book::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('digital_library.admin.books.index', compact('books', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Book::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('digital_library.admin.books.create', compact('kategoris'));
    }

    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('cover_url')) {
            $file = $request->file('cover_url');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('covers', $filename, 'public');
            $validated['cover_url'] = $filename;
        }

        Book::create($validated);

        return redirect()->route('digitallibrary.admin.books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $kategoris = Book::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('digital_library.admin.books.edit', compact('book', 'kategoris'));
    }

    public function update(UpdateBookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('cover_url')) {
            $file = $request->file('cover_url');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('covers', $filename, 'public');

            // Hapus file fisik lama jika ada di local storage
            $oldCover = $book->getRawOriginal('cover_url');
            if ($oldCover && !filter_var($oldCover, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete('covers/' . $oldCover);
            }

            $validated['cover_url'] = $filename;
        } else {
            // Unset agar cover_url tidak tertimpa null jika gambar tidak diubah
            unset($validated['cover_url']);
        }

        $book->update($validated);

        return redirect()->route('digitallibrary.admin.books.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        $rawCover = $book->getRawOriginal('cover_url');
        if ($rawCover && !filter_var($rawCover, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete('covers/' . $rawCover);
        }

        $book->delete();

        return redirect()->route('digitallibrary.admin.books.index')->with('success', 'Buku berhasil dihapus');
    }
}