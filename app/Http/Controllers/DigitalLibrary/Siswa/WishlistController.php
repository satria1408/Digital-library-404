<?php

namespace App\Http\Controllers\DigitalLibrary\Siswa;

use App\Http\Controllers\Controller;
use App\Models\DigitalLibrary\Admin\Book;
use App\Models\DigitalLibrary\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Menampilkan buku-buku yang sudah ditandai wishlist oleh user yang login.
     */
    public function index(Request $request)
    {
        $query = Book::query()
            ->whereHas('wishlists', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->orderBy('judul');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%'.$request->search.'%')
                    ->orWhere('penulis', 'like', '%'.$request->search.'%')
                    ->orWhere('penerbit', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $books = $query->paginate(10)->withQueryString();

        // Daftar kategori hanya diambil dari buku yang ada di wishlist user ini
        $kategoris = Book::whereHas('wishlists', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('digital_library.siswa.wishlish.index', compact('books', 'kategoris'));
    }

    /**
     * Menambahkan buku ke wishlist user yang login.
     */
    public function store(Request $request, Book $book)
    {
        Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'added']);
        }

        return back()->with('success', 'Buku ditambahkan ke wishlist.');
    }

    /**
     * Menghapus buku dari wishlist user yang login ("keluar dari wishlist").
     */
    public function destroy(Request $request, Book $book)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'removed']);
        }

        return back()->with('success', 'Buku dikeluarkan dari wishlist.');
    }
}
