<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Menampilkan daftar wishlist siswa
     */
    public function index()
    {
        $wishlists = Wishlist::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('siswa.wishlist.index', compact('wishlists'));
    }

    /**
     * Menambahkan buku ke wishlist
     */
    public function store($bookId)
    {
        $book = Book::findOrFail($bookId);

        $cek = Wishlist::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($cek) {
            return back()->with('info', 'Buku sudah ada di wishlist.');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
        ]);

        return back()->with('success', 'Buku berhasil ditambahkan ke wishlist.');
    }

    /**
     * Menghapus buku dari wishlist
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->findOrFail($id);

        $wishlist->delete();

        return back()->with('success', 'Buku berhasil dihapus dari wishlist.');
    }
}