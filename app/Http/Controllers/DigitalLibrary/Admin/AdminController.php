<?php

namespace App\Http\Controllers\DigitalLibrary\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DigitalLibrary\ImportBookRequest;
use App\Models\Auth\User;
use App\Models\DigitalLibrary\Admin\Book;
use App\Models\DigitalLibrary\Admin\Transaction;
use App\Models\DigitalLibrary\Admin\Denda;
use App\Models\SaranaPengaduan\Admin\Complaint;
use App\Models\SecurityLog;
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
     * Memproses upload file Excel berisi data buku.
     * Validasi file sepenuhnya diserahkan ke ImportBookRequest.
     */
    public function importBukuExcel(ImportBookRequest $request)
    {
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