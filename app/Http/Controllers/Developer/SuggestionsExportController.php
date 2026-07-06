<?php

namespace App\Http\Controllers\Developer; // <-- Menyesuaikan lokasi folder lo di foto

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Carbon;

class SuggestionsExportController extends Controller implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Mengambil data saran Khusus Bulan dan Tahun Berjalan saat ini
     */
    public function collection()
    {
        return Suggestion::with('user')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->latest()
            ->get();
    }

    /**
     * Membuat judul kolom (Header) paling atas di file Excel
     */
    public function headings(): array
    {
        return [
            'Kode Tiket',
            'Nama Pengirim',
            'Subjek',
            'Isi Keluhan',
            'Balasan Developer',
            'Status',
            'Tanggal Kirim (WIB)'
        ];
    }

    /**
     * Memetakan data dari database ke kolom Excel agar rapi
     */
    public function map($suggestion): array
    {
        return [
            $suggestion->ticket_code,
            $suggestion->user ? $suggestion->user->nama_lengkap : 'Anonim',
            $suggestion->subjek,
            $suggestion->isi_saran,
            $suggestion->reply_developer ?? 'Belum dibalas',
            strtoupper($suggestion->status),
            Carbon::parse($suggestion->created_at)->timezone('Asia/Jakarta')->format('d M Y - H:i')
        ];
    }
}