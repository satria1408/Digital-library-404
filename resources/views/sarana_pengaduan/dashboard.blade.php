@extends('layout.app') 

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="h4 mb-1 text-gray-800 fw-bold">Dashboard Sarana Pengaduan</h2>
        <p class="text-muted small">Overview data laporan, keluhan, dan transparansi performa sekolah.</p>
    </div>

    <div class="row g-3 mb-4">
        <!-- Total Masuk -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 border-start border-primary border-4 h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center g-0">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 small fw-bold">Total Laporan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 fs-3 fw-bold">{{ $stats['total'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status: Diterima (Butuh Respon Cepat) -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 border-start border-danger border-4 h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center g-0">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1 small fw-bold">Belum Direspons</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 fs-3 fw-bold">{{ $stats['diterima'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status: Diproses -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 border-start border-warning border-4 h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center g-0">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 small fw-bold">Sedang Diproses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 fs-3 fw-bold">{{ $stats['diproses'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status: Selesai -->
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0 border-start border-success border-4 h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center g-0">
                        <div class="col me-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1 small fw-bold">Selesai Dieksekusi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 fs-3 fw-bold">{{ $stats['selesai'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Antrean Kerja: 5 Laporan Terbaru -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-dark h6 fw-bold">Laporan Terbaru Mendekati Batas Waktu</h5>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead class="table-light text-uppercase fs-7 fw-bold text-muted">
                    <tr>
                        <th class="ps-3">Tiket</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Status Urgensi</th>
                        <th class="text-end pe-3">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentComplaints as $complaint)
                    <tr>
                        <td class="ps-3 fw-bold text-primary">#{{ $complaint->ticket_code }}</td>
                        <td>
                            @if($complaint->is_anonymous)
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1">🔒 Anonim</span>
                            @else
                                <span class="fw-semibold text-dark">{{ $complaint->user->name }}</span>
                            @endif
                        </td>
                        <td class="text-muted text-capitalize">{{ $complaint->type }} ({{ $complaint->category }})</td>
                        <td>
                            @if($complaint->status == 'diterima')
                                <span class="badge bg-danger px-2 py-1">Diterima (Baru)</span>
                            @elseif($complaint->status == 'diproses')
                                <span class="badge bg-warning text-dark px-2 py-1">Diproses</span>
                            @else
                                <span class="badge bg-success px-2 py-1">Selesai</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            {{-- Arahkan show ke detail pengaduan untuk eksekusi status --}}
                            <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="btn btn-primary btn-sm px-3">
                                Buka
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada antrean pengaduan saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection