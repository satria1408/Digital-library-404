<?php

namespace App\Http\Controllers\DigitalLibrary\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\DigitalLibrary\Admin\Book;
use App\Models\DigitalLibrary\Admin\Transaction;
use App\Models\DigitalLibrary\Admin\Denda;
use App\Models\SaranaPengaduan\Admin\Complaint;
use App\Models\SecurityLog;
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
        $totalAnggota = User::where('role', 'siswa')->count();
        $totalTransaksiAktif = Transaction::whereIn('status', ['pinjam', 'pending'])->count();
        $totalDendaBelumLunas = Denda::where('status', 'belum_bayar')->sum('nominal');

        $totalPengaduanBaru = Complaint::where('status', 'diterima')->count();
        $totalPengaduanDiproses = Complaint::where('status', 'diproses')->count();
        $totalPengaduanSelesai = Complaint::where('status', 'selesai')->count();

        $totalSecurityLog = SecurityLog::count();

        return view('digital_library.admin.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'totalTransaksiAktif',
            'totalDendaBelumLunas',
            'totalPengaduanBaru',
            'totalPengaduanDiproses',
            'totalPengaduanSelesai',
            'totalSecurityLog'
        ));
    }

    /**
     * Fungsi untuk memproses upload file Excel berisi data buku.
     * Diproses langsung (sync) saat request ini berjalan, tanpa antrean/worker.
     */
    public function importBukuExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $import = new BukuImport;
            Excel::import($import, $request->file('file_excel'));

            return redirect()->back()->with(
                'success',
                'Import buku selesai. Data baru sudah langsung tersimpan di daftar buku.'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses file Excel: ' . $e->getMessage());
        }
    }
}