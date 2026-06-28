<?php

namespace App\Http\Controllers;

use App\Models\SecurityLog;
use Illuminate\Http\Request;

class SecurityLogController extends Controller
{
    /**
     * Tampilkan semua security log (dengan filter & pagination)
     */
    public function index(Request $request)
    {
        $query = SecurityLog::with('user')->latest();

        // Filter berdasarkan attack_type
        if ($request->filled('attack_type')) {
            $query->where('attack_type', $request->attack_type);
        }

        // Filter berdasarkan IP
        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', '%' . $request->ip_address . '%');
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate(20)->withQueryString();

        return view('security.logs.index', compact('logs'));
    }

    /**
     * Tampilkan detail satu log
     */
    public function show(SecurityLog $securityLog)
    {
        $securityLog->load('user');
        return view('security.logs.show', compact('securityLog'));
    }

    /**
     * Hapus satu log
     */
    public function destroy(SecurityLog $securityLog)
    {
        $securityLog->delete();

        return redirect()->route('security.logs.index')
            ->with('success', 'Log berhasil dihapus.');
    }

    /**
     * Hapus semua log (bulk delete)
     */
    public function destroyAll()
    {
        SecurityLog::truncate();

        return redirect()->route('security.logs.index')
            ->with('success', 'Semua log berhasil dihapus.');
    }
}