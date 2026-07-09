<?php

namespace App\Http\Controllers\DigitalLibrary\Denda;

use App\Http\Controllers\Controller;
use App\Models\DigitalLibrary\Admin\Denda;

class AdminDendaController extends Controller
{
    /**
     * Menampilkan daftar semua denda siswa untuk Admin Pustakawan
     */
    public function index()
    {
        // Mengambil semua data denda beserta data relasi transaksi, user, dan buku sekaligus (Eager Loading)
        $dendas = Denda::with(['transaction.user', 'transaction.book'])
            ->orderBy('status')
            ->latest()
            ->get();

        return view('digital_library.admin.dendas.index', compact('dendas'));
    }

    /**
     * Proses pelunasan denda oleh Admin
     */
    public function bayar($id)
    {
        // Cari data denda berdasarkan ID, lalu ubah statusnya jadi lunas
        $denda = Denda::findOrFail($id);
        $denda->update([
            'status' => 'lunas',
        ]);

        // Redirect balik ke halaman daftar denda dengan pesan sukses
        return redirect()->route('dendas.index')->with('success', 'Denda berhasil dilunasi');
    }
}