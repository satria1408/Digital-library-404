@extends('layout.dashboard-siswa')

@section('content')
<div class="container py-3">

    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-white border-bottom border-light d-flex justify-content-between align-items-center py-3 px-4">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2.5 rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="bi bi-chat-left-text-fill fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">Riwayat Pengaduan & Sarana</h5>
                    <p class="text-muted small mb-0 d-none d-md-block mt-0.5">Pantau status laporan fasilitas sekolah Anda.</p>
                </div>
            </div>
            <a href="{{ route('siswa.complaints.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm fw-medium">
                <i class="bi bi-pencil-square me-1"></i> Buat Laporan
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-0 mb-0" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive d-none d-lg-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase text-secondary" style="font-size: 0.72rem; font-weight: 700; letter-spacing: 0.05em;">
                        <tr>
                            <th class="ps-4 py-3" width="5%">No</th>
                            <th class="py-3" width="15%">Kode Tiket</th>
                            <th class="py-3" width="35%">Isi Laporan</th>
                            <th class="py-3 text-center" width="15%">Status</th>
                            <th class="py-3" width="15%">Tanggal</th>
                            <th class="pe-4 py-3 text-end" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $index => $complaint)
                            @php
                                $judul = str()->limit($complaint->description, 60, '...');
                                $status = $complaint->status ?? 'diterima';
                            @endphp
                            <tr>
                                <td class="ps-4 text-muted">{{ $complaints->firstItem() + $index }}</td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border rounded-2 px-2 py-1" style="font-family: monospace;">
                                        {{ $complaint->ticket_code ?? 'SCH-OR4NUD' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $complaint->title ?? 'Pengaduan Sarana Sekolah' }}</div>
                                    <span class="text-muted small">{{ $judul }}</span>
                                </td>
                                <td class="text-center">
                                    @if($status == 'diterima')
                                        <span class="badge bg-warning-subtle text-warning border border-warning border-opacity-25 rounded-pill px-2.5 py-1">
                                            <i class="bi bi-clock-history me-1"></i>Diterima
                                        </span>
                                    @elseif($status == 'diproses')
                                        <span class="badge bg-info-subtle text-info border border-info border-opacity-25 rounded-pill px-2.5 py-1">
                                            <i class="bi bi-arrow-repeat me-1"></i>Diproses
                                        </span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1">
                                            <i class="bi bi-check2-circle me-1"></i>Selesai
                                        </span>
                                    @endif
                                </td>
                                <td class="text-secondary small">
                                    {{ $complaint->created_at ? $complaint->created_at->isoFormat('D MMM Y') : '-' }}
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('siswa.complaints.show', $complaint->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                        <i class="bi bi-eye-fill me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-chat-left-text fs-2 opacity-25 d-block mb-2"></i>
                                    Belum ada riwayat laporan pengaduan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($complaints->hasPages())
                    <div class="d-flex justify-content-between align-items-center py-3 px-4 border-top border-light bg-light bg-opacity-25">
                        <small class="text-muted fw-medium">
                            Menampilkan {{ $complaints->firstItem() }}–{{ $complaints->lastItem() }} dari {{ $complaints->total() }} laporan
                        </small>
                        {{ $complaints->links() }}
                    </div>
                @endif
            </div>

            <div class="d-lg-none p-3 bg-light bg-opacity-25">
                <div class="row g-3">
                    @forelse($complaints as $complaint)
                        @php
                            $judul = str()->limit($complaint->description, 60, '...');
                            $status = $complaint->status ?? 'diterima';
                        @endphp
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                        <div class="overflow-hidden">
                                            <span class="fw-bold text-dark d-block text-truncate">{{ $complaint->title ?? 'Pengaduan Sarana Sekolah' }}</span>
                                            <span class="text-muted small">{{ $judul }}</span>
                                        </div>
                                        @if($status == 'diterima')
                                            <span class="badge bg-warning-subtle text-warning rounded-pill px-2 py-1">Diterima</span>
                                        @elseif($status == 'diproses')
                                            <span class="badge bg-info-subtle text-info rounded-pill px-2 py-1">Diproses</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1">Selesai</span>
                                        @endif
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted small">
                                            {{ $complaint->created_at ? $complaint->created_at->isoFormat('D MMM Y') : '-' }}
                                        </span>
                                        <a href="{{ route('siswa.complaints.show', $complaint->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted py-5">
                            <i class="bi bi-chat-left-text fs-2 opacity-25 d-block mb-2"></i>
                            Belum ada riwayat laporan.
                        </div>
                    @endforelse
                </div>

                @if($complaints->hasPages())
                    <div class="d-flex flex-column align-items-center gap-1 mt-2 pb-2">
                        {{ $complaints->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection