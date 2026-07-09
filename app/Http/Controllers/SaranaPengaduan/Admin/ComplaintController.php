<?php

namespace App\Http\Controllers\SaranaPengaduan\Admin;

use App\Http\Controllers\Controller; 
use App\Models\SaranaPengaduan\Admin\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    /**
     * 1. Halaman Inbox Utama Admin (List View)
     */
    public function index(Request $request)
    {
        // Tarik data pengaduan beserta data user/siswa yang melapor
        $query = Complaint::with('user');

        // Filter: Berdasarkan jenis (kerusakan / keluhan)
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Filter: Berdasarkan status tracking
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // UX Taktis Backend: Paksa status 'diterima' (belum disentuh) naik paling atas,
        // baru diurutkan berdasarkan tanggal terbaru. Biar admin gak numpuk laporan!
        $complaints = $query->orderByRaw("FIELD(status, 'diterima', 'diproses', 'selesai') ASC")
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view('admin.complaints.index', compact('complaints'));
    }

    /**
     * 2. Halaman Detail Laporan Tunggal
     */
    public function show($id)
    {
        // Tarik detail pengaduan beserta history audit log-nya
        $complaint = Complaint::with(['user', 'logs.admin'])->findOrFail($id);

        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * 3. Eksekusi Perubahan Status + Kunci Audit Log (Anti-Malas)
     */
    public function updateStatus(Request $request, $id)
    {
        // Validasi input ketat demi keamanan data
        $request->validate([
            'status' => 'required|in:diterima,diproses,selesai',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $complaint = Complaint::findOrFail($id);
        
        // Simpan status lama sebelum diubah untuk history log
        $oldStatus = $complaint->status;

        // Cegah klik submit berulang jika tidak ada perubahan sama sekali
        if ($oldStatus === $request->status && $complaint->admin_notes === $request->admin_notes) {
            return redirect()->back()->with('info', 'Tidak ada perubahan status atau catatan.');
        }

        // Pakai DB Transaction: Menjamin kedua tabel ter-update barengan. 
        // Gak boleh status berubah tapi log-nya gagal tersimpan!
        DB::transaction(function () use ($complaint, $request, $oldStatus) {
            
            // Aksi 1: Update tabel pengaduan utama
            $complaint->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
            ]);

            // Aksi 2: Suntik data ke tabel log akuntabilitas (Blackbox internal)
            DB::table('complaint_logs')->insert([
                'complaint_id' => $complaint->id,
                'changed_by_admin_id' => Auth::id(), // ID Admin yang sedang login dan mengeksekusi
                'status_from' => $oldStatus,
                'status_to' => $request->status,
                'notes' => $request->admin_notes ?? 'Mengubah status laporan.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('admin.complaints.index')->with('success', 'Status laporan #' . $complaint->ticket_code . ' berhasil diperbarui!');
    }
}