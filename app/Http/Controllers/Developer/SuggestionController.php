<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\DigitalLibrary\Developer\Suggestion;
use App\Models\DigitalLibrary\Auth\User;
use App\Models\DigitalLibrary\Admin\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SuggestionController extends Controller
{
    /**
     * Tampilan Dashboard Utama Developer
     */
    public function dashboard()
    {
        if (Auth::user()->role !== 'developer') {
            abort(403);
        }
        
        // Mengambil data ringkasan untuk statistik dashboard
        $stats = [
            'total_saran'   => Suggestion::count(),
            'belum_dibaca'  => Suggestion::where('status', 'unread')->count(),
            'total_siswa'   => User::where('role', 'siswa')->count(),
            'total_buku'    => Book::count(),
        ];

        return view('developer.dashboard', compact('stats'));
    }

    /**
     * Fitur Export Excel Otomatis Mengunci Per Bulan Berjalan (Tanpa API / AI)
     * Menggunakan SuggestionsExportController yang satu folder di Developer
     */
    public function exportExcel()
    {
        if (Auth::user()->role !== 'developer') {
            abort(403);
        }

        // Otomatis mengambil nama bulan (Bahasa Indonesia) dan Tahun aktif saat ini
        $bulanTahun = now()->locale('id')->isoFormat('MMMM-Y'); 
        
        // Nama file terkunci per bulan, contoh: Laporan-Keluhan-Juli-2026.xlsx
        $namaFile = 'Laporan-Keluhan-' . $bulanTahun . '.xlsx';

        // Langsung panggil class export yang ada di folder yang sama
        return \Maatwebsite\Excel\Facades\Excel::download(new SuggestionsExportController, $namaFile);
    }

    /**
     * Menyimpan saran baru dari halaman depan (Anonim / Siswa)
     */
    public function store(Request $request)
    {
        $request->validate([
            'subjek'    => 'required|string|max:150',
            'isi_saran' => 'required|string',
        ]);

        $ticketCode = 'DEV-' . strtoupper(Str::random(6));

        Suggestion::create([
            'user_id'         => Auth::check() ? Auth::id() : null,
            'ticket_code'     => $ticketCode,
            'subjek'          => $request->subjek,
            'isi_saran'       => $request->isi_saran,
            'reply_developer' => null,
            'status'          => 'unread'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Saran berhasil dikirim secara anonim!',
            'ticket_code' => $ticketCode
        ]);
    }

    /**
     * Mengecek status surat & balasan berdasarkan kode tiket
     */
    public function checkTicket(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string',
        ]);

        $suggestion = Suggestion::where('ticket_code', $request->ticket_code)->first();

        if (!$suggestion) {
            return response()->json([
                'success' => false,
                'message' => 'Kode tiket tidak ditemukan. Periksa kembali penulisan lo.'
            ], 404);
        }

        // JAM NYATA (TIMEZONE): Setel Carbon ke Asia/Jakarta sebelum memformat jam pengiriman
        $tanggalKirim = Carbon::parse($suggestion->created_at)
            ->setTimezone('Asia/Jakarta')
            ->format('d M Y H:i');

        return response()->json([
            'success' => true,
            'data'    => [
                'subjek'          => $suggestion->subjek,
                'isi_saran'       => $suggestion->isi_saran,
                'status'          => $suggestion->status,
                'reply_developer' => $suggestion->reply_developer ?? 'Belum ada balasan dari developer. Ditunggu ya!',
                'tanggal_kirim'   => $tanggalKirim,
            ]
        ]);
    }

    /**
     * Menampilkan semua daftar keluhan/saran di dashboard lo
     */
    public function indexForDeveloper()
    {
        if (Auth::user()->role !== 'developer') {
            abort(403);
        }

        $suggestions = Suggestion::with('user')->latest()->get();

        return view('developer.suggestions.index', compact('suggestions'));
    }

    /**
     * Membalas pesan keluhan masuk
     */
    public function reply(Request $request, $id)
    {
        if (Auth::user()->role !== 'developer') {
            abort(403);
        }

        $request->validate([
            'reply_developer' => 'required|string',
        ]);

        $suggestion = Suggestion::findOrFail($id);
        
        $suggestion->update([
            'reply_developer' => $request->reply_developer,
            'status'          => 'replied'
        ]);

        return redirect()->back()->with('success', 'Balasan surat berhasil dikirim ke user!');
    }

    /**
     * Menghapus laporan/saran dari daftar
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'developer') {
            abort(403);
        }

        $suggestion = Suggestion::findOrFail($id);
        $suggestion->delete();
        return redirect()->back()->with('success', 'Laporan berhasil dihapus!');
    }
}