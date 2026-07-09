<?php

namespace App\Http\Controllers\DigitalLibrary\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\DigitalLibrary\Admin\Book;
use Illuminate\Http\Request;
use App\Imports\BukuImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    /**
     * Digunakan untuk Dashboard & Monitoring
     */
    public function index()
    {
        $totalBuku = Book::count();
        $totalSiswa = User::where('role', 'siswa')->count();
        return view('digital_library.admin.dashboard', compact('totalBuku', 'totalSiswa'));
    }

    /**
     * Fungsi untuk memproses upload file Excel berisi data buku.
     * Diproses langsung (sync) saat request ini berjalan, tanpa antrean/worker.
     */
    public function importBukuExcel(Request $request)
    {
        // 1. Validasi file agar hanya menerima format Excel/CSV
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            // 2. Proses import langsung. Baris yang ISBN-nya duplikat atau kosong
            //    otomatis dilewati oleh BukuImport.
            $import = new BukuImport;
            Excel::import($import, $request->file('file_excel'));

            return redirect()->back()->with(
                'success',
                'Import buku selesai. Data baru sudah langsung tersimpan di daftar buku.'
            );
        } catch (\Exception $e) {
            // 3. Menangani error jika file corrupt atau format tidak sesuai
            return redirect()->back()->with('error', 'Gagal memproses file Excel: ' . $e->getMessage());
        }
    }
}