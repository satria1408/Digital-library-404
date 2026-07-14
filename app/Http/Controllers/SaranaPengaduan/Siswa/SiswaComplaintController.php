<?php

namespace App\Http\Controllers\SaranaPengaduan\Siswa;

use App\Http\Controllers\Controller;
use App\Models\SaranaPengaduan\Admin\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SiswaComplaintController extends Controller
{
    /**
     * =========================================================================
     * ALUR 1: AKSES PUBLIK / ANONIM (Dipanggil via AJAX Fetch dari Halaman Login)
     * =========================================================================
     */

    /**
     * Menyimpan Pengaduan Sekolah dari halaman publik sebelum login (AJAX JSON)
     */
    public function storeUmum(Request $request)
    {
        // Validasi input dari modal pengaduan halaman login depan
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
        ]);

        // Generate kode tiket acak unik, contoh: SCH-K2B1X9
        $ticketCode = 'SCH-' . strtoupper(Str::random(6));

        // Format judul dan isi laporan ke dalam string deskripsi tunggal
        $fullDescription = "Judul Laporan: " . $request->judul . "\n\n" . $request->isi_laporan;

        // Simpan ke database mengikuti aturan ketat ENUM di migration dan seeder
        Complaint::create([
            'ticket_code'  => $ticketCode,
            'user_id'      => Auth::check() ? Auth::id() : 1, 
            'type'         => 'keluhan', 
            'category'     => 'umum',
            'description'  => $fullDescription,
            'photo_path'   => null,
            'is_anonymous' => true, 
            'status'       => 'diterima', 
            'admin_notes'  => null,
        ]);

        // Return data JSON untuk diproses JavaScript di halaman depan
        return response()->json([
            'success'     => true,
            'message'     => 'Laporan pengaduan sekolah berhasil dikirim ke Admin Sarana Pengaduan!',
            'ticket_code' => $ticketCode
        ]);
    }

    /**
     * Melacak Status Tiket Pengaduan Sekolah via AJAX JSON (Halaman Depan)
     */
    public function checkSchoolTicket(Request $request)
    {
        //  Validasi input kode tiket dari user
        $request->validate([
            'ticket_code' => 'required|string'
        ]);

        //  Cari data pengaduan berdasarkan ticket_code
        $complaint = Complaint::where('ticket_code', $request->ticket_code)->first();

        //  Jika tidak ditemukan, return response error JSON
        if (!$complaint) {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, kode laporan tidak ditemukan. Periksa kembali kode Anda.'
            ], 404);
        }

        //  Memisahkan kembali Judul Laporan dan Isi Detail dari kolom description
        $description = $complaint->description;
        $judulRaw = Str::between($description, 'Judul Laporan: ', "\n\n");
        $isiRaw = Str::after($description, "\n\n");

        // Jika format gabungan tidak ditemukan, backup ke text asli
        $judul = $judulRaw ?: 'Pengaduan Sekolah';
        $isiLaporan = $judulRaw ? $isiRaw : $description;

        //  Return data sukses berformat JSON sesuai kebutuhan AJAX di login.blade.php
        return response()->json([
            'success' => true,
            'data' => [
                'judul'           => $judul,
                'isi_laporan'     => $isiLaporan,
                'status'          => strtoupper($complaint->status ?? 'DITERIMA'),
                'tanggapan_admin' => $complaint->admin_notes ?: 'Belum ada tanggapan resmi dari pihak sekolah.'
            ]
        ]);
    }

    /**
     * =========================================================================
     * ALUR 2: INDOOR SISWA DASHBOARD (Jika Siswa Sudah Login & Punya Akun)
     * =========================================================================
     */

    /**
     * Menampilkan daftar pengaduan milik siswa yang sedang login
     */
    public function index()
    {
        $complaints = Complaint::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('sarana_pengaduan.siswa.index', compact('complaints'));
    }

    /**
     * Menampilkan form internal untuk membuat laporan pengaduan baru (setelah login)
     */
    public function create()
    {
        return view('sarana_pengaduan.siswa.create');
    }

    /**
     * Menyimpan pengaduan baru dari form internal siswa (setelah login)
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
        ]);

        $ticketCode = 'SCH-' . strtoupper(Str::random(6));
        $fullDescription = "Judul Laporan: " . $request->judul . "\n\n" . $request->isi_laporan;

        Complaint::create([
            'ticket_code'  => $ticketCode,
            'user_id'      => Auth::id(), 
            'type'         => 'keluhan', 
            'category'     => 'siswa',
            'description'  => $fullDescription,
            'photo_path'   => null,
            'is_anonymous' => false, 
            'status'       => 'diterima', 
            'admin_notes'  => null,
        ]);

        return redirect()->route('siswa.complaints.index')
            ->with('success', 'Pengaduan berhasil dikirim ke pihak sekolah.');
    }

    /**
     * Menampilkan detail dari satu pengaduan milik siswa
     */
    public function show($id)
    {
        $complaint = Complaint::where('user_id', Auth::id())->findOrFail($id);
        return view('sarana_pengaduan.siswa.show', compact('complaint'));
    }
}