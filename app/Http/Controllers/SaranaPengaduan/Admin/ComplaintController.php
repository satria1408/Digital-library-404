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
     * A. Halaman Dashboard Utama (Summary View Only)
     */
    public function dashboard()
    {
        // Hitung statistik untuk 4 kotak summary utama
        $stats = [
            'total' => Complaint::count(),
            'diterima' => Complaint::where('status', 'diterima')->count(),
            'diproses' => Complaint::where('status', 'diproses')->count(),
            'selesai' => Complaint::where('status', 'selesai')->count(),
        ];

        return view('sarana_pengaduan.dashboard', compact('stats'));
    }

    /**
     * B. Halaman Index Laporan (Full Table & Filter View)
     */
    public function index(Request $request)
    {
        $query = Complaint::with('user');

        // Filter berdasarkan jenis (kerusakan / keluhan)
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Taktik UX: 'diterima' paling atas, lalu urutkan dari yang terbaru
        $complaints = $query->orderByRaw("FIELD(status, 'diterima', 'diproses', 'selesai') ASC")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('sarana_pengaduan.admin.index', compact('complaints'));
    }

    /**
     * C. Halaman Detail Laporan Tunggal
     */
    public function show($id)
    {
        $complaint = Complaint::with(['user', 'logs.admin'])->findOrFail($id);

        return view('sarana_pengaduan.admin.show', compact('complaint'));
    }

    /**
     * D. Eksekusi Perubahan Status + Kunci Audit Log
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,diproses,selesai',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $complaint = Complaint::findOrFail($id);
        $oldStatus = $complaint->status;

        if ($oldStatus === $request->status && $complaint->admin_notes === $request->admin_notes) {
            return redirect()->back()->with('info', 'Tidak ada perubahan status atau catatan.');
        }

        DB::transaction(function () use ($complaint, $request, $oldStatus) {
            $complaint->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
            ]);

            DB::table('complaint_logs')->insert([
                'complaint_id' => $complaint->id,
                'changed_by_admin_id' => Auth::id(),
                'status_from' => $oldStatus,
                'status_to' => $request->status,
                'notes' => $request->admin_notes ?? 'Mengubah status laporan.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('admin.complaints.index')->with('success', 'Status laporan #'.$complaint->ticket_code.' berhasil diperbarui!');
    }
}
