@extends('layout.siswa_pengaduan')

@section('content')
<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .card-custom {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.015);
    }

    .table-custom thead {
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-custom th {
        color: #64748b;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        padding: 1rem 1.25rem;
    }

    .table-custom td {
        padding: 1rem 1.25rem;
        color: #334155;
    }

    .badge-ticket {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 600;
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .btn-action {
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-back-custom {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .btn-back-custom:hover {
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
        border-color: rgba(13, 110, 253, 0.2);
    }

    .card-mobile-report {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background-color: #ffffff;
        transition: transform 0.2s ease;
    }

    .card-mobile-report:active {
        transform: scale(0.98);
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <div class="card card-custom overflow-hidden mb-4">
                
                <!-- Card Header -->
                <div class="card-header bg-transparent border-0 p-4 pb-2">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                        
                        <!-- Tombol Kembali Terkunci Menuju Dashboard Utama -->
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('saranapengaduan.siswa.index') }}" class="btn btn-back-custom rounded-circle shadow-sm" title="Kembali ke Dashboard">
                                <i class="bi bi-arrow-left fs-5"></i>
                            </a>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Riwayat Pengaduan Sarpras</h5>
                                <p class="text-muted small mb-0">Pantau perkembangan status perbaikan fasilitas yang telah Anda laporkan.</p>
                            </div>
                        </div>

                        <a href="{{ route('saranapengaduan.siswa.create') }}" class="btn btn-primary rounded-pill px-4 btn-sm fw-semibold shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-pencil-square"></i>
                            <span>Buat Laporan Baru</span>
                        </a>
                    </div>
                </div>

                <!-- Session Alert -->
                @if(session('success'))
                    <div class="px-4 pt-3">
                        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-0" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <!-- Card Body -->
                <div class="card-body p-0 mt-3">
                    
                    <!-- Desktop View Table (>= Large Devices) -->
                    <div class="table-responsive d-none d-lg-block">
                        <table class="table table-hover table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="15%">Kode Tiket</th>
                                    <th width="40%">Rincian Laporan</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="12%" class="text-center">Status</th>
                                    <th width="13%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($complaints as $index => $complaint)
                                    @php
                                        $judul = str()->limit($complaint->description, 70, '...');
                                        $status = strtolower($complaint->status ?? 'diterima');
                                    @endphp
                                    <tr>
                                        <td class="text-center text-muted small">{{ $complaints->firstItem() + $index }}</td>
                                        <td>
                                            <span class="badge badge-ticket rounded-2 px-2 py-1">
                                                {{ $complaint->ticket_code ?? 'SCH-XXXXXX' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark mb-0.5">{{ $complaint->title ?? 'Pengaduan Sarana Sekolah' }}</div>
                                            <span class="text-muted small d-block text-wrap">{{ $judul }}</span>
                                        </td>
                                        <td class="text-secondary small">
                                            {{ $complaint->created_at ? $complaint->created_at->isoFormat('D MMM Y') : '-' }}
                                        </td>
                                        <td class="text-center">
                                            @if($status == 'diterima')
                                                <span class="badge bg-warning-subtle text-warning border border-warning border-opacity-25 rounded-pill px-2.5 py-1 small">
                                                    <i class="bi bi-clock-history me-1"></i>Diterima
                                                </span>
                                            @elseif($status == 'diproses')
                                                <span class="badge bg-info-subtle text-info border border-info border-opacity-25 rounded-pill px-2.5 py-1 small">
                                                    <i class="bi bi-arrow-repeat me-1"></i>Diproses
                                                </span>
                                            @else
                                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1 small">
                                                    <i class="bi bi-check2-circle me-1"></i>Selesai
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('saranapengaduan.siswa.show', $complaint->id) }}" class="btn btn-outline-primary btn-action rounded-pill">
                                                <i class="bi bi-eye-fill me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="bi bi-chat-left-text fs-2 opacity-25 d-block mb-3 text-secondary"></i>
                                            <span class="d-block small fw-medium">Belum ada riwayat pengaduan yang terekam.</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Desktop Pagination -->
                        @if($complaints->hasPages())
                            <div class="d-flex justify-content-between align-items-center p-4 border-top">
                                <small class="text-muted fw-medium">
                                    Menampilkan {{ $complaints->firstItem() }}–{{ $complaints->lastItem() }} dari {{ $complaints->total() }} laporan
                                </small>
                                <div>
                                    {{ $complaints->links() }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Mobile View List (< Large Devices) -->
                    <div class="d-lg-none p-4 bg-light bg-opacity-10">
                        <div class="row g-3">
                            @forelse($complaints as $complaint)
                                @php
                                    $judul = str()->limit($complaint->description, 60, '...');
                                    $status = strtolower($complaint->status ?? 'diterima');
                                @endphp
                                <div class="col-12">
                                    <div class="card card-mobile-report p-3 shadow-sm">
                                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                            <div class="overflow-hidden">
                                                <span class="badge badge-ticket rounded-2 px-2 py-0.5 mb-2 small d-inline-block">
                                                    {{ $complaint->ticket_code ?? 'SCH-XXXXXX' }}
                                                </span>
                                                <h6 class="fw-bold text-dark text-truncate mb-1">{{ $complaint->title ?? 'Pengaduan Sarana Sekolah' }}</h6>
                                                <p class="text-muted small mb-0">{{ $judul }}</p>
                                            </div>
                                            
                                            @if($status == 'diterima')
                                                <span class="badge bg-warning-subtle text-warning rounded-pill px-2.5 py-1 small">Diterima</span>
                                            @elseif($status == 'diproses')
                                                <span class="badge bg-info-subtle text-info rounded-pill px-2.5 py-1 small">Diproses</span>
                                            @else
                                                <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 small">Selesai</span>
                                            @endif
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center border-top pt-2 mt-2">
                                            <span class="text-secondary style-counter" style="font-size: 0.8rem;">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ $complaint->created_at ? $complaint->created_at->isoFormat('D MMM Y') : '-' }}
                                            </span>
                                            <a href="{{ route('saranapengaduan.siswa.show', $complaint->id) }}" class="btn btn-outline-primary btn-action rounded-pill">
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-chat-left-text fs-2 opacity-25 d-block mb-2"></i>
                                    <span class="small d-block">Belum ada riwayat laporan.</span>
                                </div>
                            @endforelse
                        </div>

                        <!-- Mobile Pagination -->
                        @if($complaints->hasPages())
                            <div class="d-flex flex-column align-items-center gap-2 mt-4">
                                {{ $complaints->links() }}
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection