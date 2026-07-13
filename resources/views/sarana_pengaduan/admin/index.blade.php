@extends('layout.app') 

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1 text-gray-800 fw-bold">Daftar Laporan Masuk</h2>
            <p class="text-muted small mb-0">Manajemen filter keluhan dan kerusakan fasilitas sekolah.</p>
        </div>
        <a href="{{ route('admin.complaints.dashboard') }}" class="btn btn-outline-secondary btn-sm px-3">
            ← Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info border-0 shadow-sm alert-dismissible fade show" role="alert">
            {{ session('info') }}
        </div>
    @endif

    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('admin.complaints.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Jenis Pengaduan</label>
                    <select name="type" class="form-select form-select-sm">
                        <option value="">Semua Jenis</option>
                        <option value="kerusakan" {{ request('type') == 'kerusakan' ? 'selected' : '' }}>Kerusakan (Fasilitas)</option>
                        <option value="keluhan" {{ request('type') == 'keluhan' ? 'selected' : '' }}>Keluhan (Layanan/Sosial)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima (Baru)</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-4 d-grid">
                    <button type="submit" class="btn btn-primary btn-sm">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead class="table-light text-uppercase fs-7 fw-bold text-muted">
                    <tr>
                        <th class="ps-3">Kode Tiket</th>
                        <th>Pelapor</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Tanggal Masuk</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                    <tr>
                        <td class="ps-3 fw-bold text-primary">#{{ $complaint->ticket_code }}</td>
                        <td>
                            @if($complaint->is_anonymous)
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1">🔒 Anonim</span>
                            @else
                                <span class="fw-semibold text-dark">{{ $complaint->user->name }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $complaint->type == 'kerusakan' ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning' }} text-capitalize">
                                {{ $complaint->type }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $complaint->category }}</td>
                        <td class="text-muted">{{ $complaint->created_at->translatedFormat('d M Y, H:i') }}</td>
                        <td>
                            @if($complaint->status == 'diterima')
                                <span class="badge bg-danger px-2.5 py-1.5 text-uppercase fs-8 fw-bold">Diterima</span>
                            @elseif($complaint->status == 'diproses')
                                <span class="badge bg-warning text-dark px-2.5 py-1.5 text-uppercase fs-8 fw-bold">Diproses</span>
                            @else
                                <span class="badge bg-success px-2.5 py-1.5 text-uppercase fs-8 fw-bold">Selesai</span>
                            @endif
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="btn btn-outline-primary btn-sm px-3">
                                Detail & Respon
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <span class="fs-4 d-block mb-2">📥</span>
                            Tidak ditemukan data pengaduan yang sesuai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($complaints->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $complaints->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection