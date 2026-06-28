@extends('layout.app')

@section('content')

<style>
.security-bg {
    min-height: calc(100vh - 56px);
    padding: 30px;
    background: linear-gradient(
        135deg,
        #0f172a 0%,
        #1e3a8a 50%,
        #2563eb 100%
    );
    transition: .3s;
}

.security-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 12px;
}

.security-title {
    color: #fff;
    font-weight: 700;
    margin: 0;
    font-size: 24px;
}

.security-title span {
    font-size: 14px;
    font-weight: 400;
    opacity: .65;
    display: block;
    margin-top: 4px;
}

.glass-card {
    border: none;
    border-radius: 16px;
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,.12);
    color: #fff;
    transition: .3s;
}

.glass-card .card-header {
    background: rgba(255,255,255,.1);
    border-bottom: 1px solid rgba(255,255,255,.15);
    font-weight: 600;
    font-size: 14px;
    letter-spacing: .4px;
    border-radius: 16px 16px 0 0 !important;
    padding: 14px 20px;
}

/* Filter form */
.filter-row .form-control,
.filter-row .form-select {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.2);
    color: #fff;
    border-radius: 10px;
    font-size: 14px;
    height: 40px;
}

.filter-row .form-control::placeholder {
    color: rgba(255,255,255,.45);
}

.filter-row .form-control:focus,
.filter-row .form-select:focus {
    background: rgba(255,255,255,.2);
    border-color: rgba(255,255,255,.45);
    color: #fff;
    box-shadow: none;
}

.filter-row .form-select option {
    background: #1e3a8a;
    color: #fff;
}

/* Table */
.table-security {
    color: #fff;
    margin: 0;
    font-size: 14px;
}

.table-security thead th {
    background: rgba(255,255,255,.08);
    border-color: rgba(255,255,255,.12);
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .6px;
    padding: 12px 16px;
    white-space: nowrap;
    color: rgba(255,255,255,.7);
}

.table-security tbody td {
    border-color: rgba(255,255,255,.08);
    vertical-align: middle;
    padding: 12px 16px;
}

.table-security tbody tr:hover {
    background: rgba(255,255,255,.05);
}

.payload-preview {
    max-width: 220px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-family: monospace;
    font-size: 13px;
    color: #fca5a5;
    background: rgba(239,68,68,.1);
    padding: 4px 8px;
    border-radius: 6px;
    display: block;
}

.badge-attack {
    background: rgba(239,68,68,.2);
    color: #fca5a5;
    border: 1px solid rgba(239,68,68,.35);
    border-radius: 6px;
    padding: 3px 10px;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: .3px;
}

.badge-method {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .4px;
    border-radius: 6px;
    padding: 3px 8px;
}

.btn-action {
    border-radius: 8px;
    padding: 5px 12px;
    font-size: 12px;
    font-weight: 500;
}

/* Stat badge */
.stat-badge {
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 8px;
    padding: 4px 12px;
    font-size: 13px;
    color: rgba(255,255,255,.8);
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 70px 20px;
    color: rgba(255,255,255,.5);
}

.empty-state .empty-icon {
    font-size: 40px;
    margin-bottom: 16px;
    display: block;
    opacity: .4;
}

/* Pagination */
.pagination .page-link {
    background: rgba(255,255,255,.12);
    border-color: rgba(255,255,255,.15);
    color: #fff;
    border-radius: 8px;
    margin: 0 2px;
    font-size: 13px;
}

.pagination .page-link:hover {
    background: rgba(255,255,255,.22);
}

.pagination .page-item.active .page-link {
    background: #2563eb;
    border-color: #2563eb;
}

.pagination .page-item.disabled .page-link {
    background: rgba(255,255,255,.04);
    color: rgba(255,255,255,.25);
}

/* LIGHT MODE */
body.light-mode .security-bg {
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 50%, #94a3b8 100%);
}

body.light-mode .security-title { color: #0f172a; }
body.light-mode .security-title span { color: #64748b; }

body.light-mode .glass-card {
    background: rgba(255,255,255,.88);
    color: #0f172a;
}

body.light-mode .glass-card .card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    color: #0f172a;
}

body.light-mode .filter-row .form-control,
body.light-mode .filter-row .form-select {
    background: #fff;
    border-color: #cbd5e1;
    color: #0f172a;
}

body.light-mode .filter-row .form-control::placeholder { color: #94a3b8; }
body.light-mode .filter-row .form-select option { background: #fff; color: #0f172a; }

body.light-mode .table-security { color: #0f172a; }
body.light-mode .table-security thead th {
    background: #f1f5f9;
    border-color: #e2e8f0;
    color: #64748b;
}
body.light-mode .table-security tbody td { border-color: #f1f5f9; }
body.light-mode .table-security tbody tr:hover { background: #f8fafc; }

body.light-mode .payload-preview {
    color: #dc2626;
    background: rgba(239,68,68,.07);
}

body.light-mode .badge-attack {
    background: rgba(239,68,68,.08);
    color: #dc2626;
    border-color: rgba(239,68,68,.25);
}

body.light-mode .stat-badge {
    background: rgba(0,0,0,.06);
    border-color: #e2e8f0;
    color: #475569;
}

body.light-mode .pagination .page-link {
    background: #fff;
    border-color: #e2e8f0;
    color: #1e3a8a;
}

body.light-mode .pagination .page-item.active .page-link {
    background: #2563eb;
    border-color: #2563eb;
    color: #fff;
}

body.light-mode .empty-state { color: #94a3b8; }
</style>

<div class="security-bg">

    {{-- Header --}}
    <div class="security-header">
        <h1 class="security-title">
            Security Log
            <span>Daftar percobaan SQL Injection yang terdeteksi sistem</span>
        </h1>

        @if($logs->total() > 0)
            <form action="{{ route('security.logs.destroyAll') }}" method="POST"
                  onsubmit="return confirmHapusSemua()">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="border-radius:10px; font-size:14px;">
                    Hapus Semua Log
                </button>
            </form>
        @endif
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-dismissible fade show mb-4"
             style="border-radius:12px; background:rgba(34,197,94,.15); border:1px solid rgba(34,197,94,.35); color:#fff; font-size:14px;">
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter --}}
    <div class="card glass-card mb-4">
        <div class="card-header">Filter Log</div>
        <div class="card-body py-3 px-4">
            <form method="GET" action="{{ route('security.logs.index') }}">
                <div class="row g-3 filter-row align-items-end">

                    <div class="col-md-4">
                        <label class="form-label" style="font-size:12px; opacity:.65; margin-bottom:6px;">IP Address</label>
                        <input type="text" name="ip_address"
                               class="form-control"
                               placeholder="Cari IP Address..."
                               value="{{ request('ip_address') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" style="font-size:12px; opacity:.65; margin-bottom:6px;">Jenis Serangan</label>
                        <select name="attack_type" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="SQL Injection" {{ request('attack_type') == 'SQL Injection' ? 'selected' : '' }}>
                                SQL Injection
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" style="font-size:12px; opacity:.65; margin-bottom:6px;">Tanggal</label>
                        <input type="date" name="date"
                               class="form-control"
                               value="{{ request('date') }}">
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100" style="border-radius:10px; height:40px; font-size:13px;">
                            Cari
                        </button>
                        <a href="{{ route('security.logs.index') }}"
                           class="btn btn-secondary w-100" style="border-radius:10px; height:40px; font-size:13px;">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card glass-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Log</span>
            <span class="stat-badge">{{ $logs->total() }} log ditemukan</span>
        </div>

        <div class="card-body p-0">

            @if($logs->isEmpty())
                <div class="empty-state">
                    <span class="empty-icon">&#9673;</span>
                    <p class="mb-1" style="font-size:15px; font-weight:600;">Belum ada serangan terdeteksi</p>
                    <small>Sistem dalam kondisi aman</small>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-security">
                        <thead>
                            <tr>
                                <th style="width:44px;">#</th>
                                <th>Waktu</th>
                                <th>IP Address</th>
                                <th>User</th>
                                <th style="width:80px;">Method</th>
                                <th>Jenis Serangan</th>
                                <th>Payload</th>
                                <th style="width:120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $index => $log)
                                <tr>
                                    <td style="color:rgba(255,255,255,.4); font-size:12px;">
                                        {{ $logs->firstItem() + $index }}
                                    </td>

                                    <td style="white-space:nowrap;">
                                        <div style="font-size:13px;">{{ $log->created_at->format('d M Y') }}</div>
                                        <div style="font-size:12px; opacity:.5;">{{ $log->created_at->format('H:i:s') }}</div>
                                    </td>

                                    <td>
                                        <code style="color:#93c5fd; background:rgba(147,197,253,.1); padding:3px 8px; border-radius:5px; font-size:13px;">
                                            {{ $log->ip_address }}
                                        </code>
                                    </td>

                                    <td>
                                        @if($log->user)
                                            <div style="font-size:13px;">{{ $log->user->nama_lengkap }}</div>
                                            <div style="font-size:12px; opacity:.5;">{{ ucfirst($log->user->role) }}</div>
                                        @else
                                            <span style="font-size:13px; opacity:.4;">Tamu</span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge badge-method bg-secondary">{{ $log->method }}</span>
                                    </td>

                                    <td>
                                        <span class="badge-attack">{{ $log->attack_type }}</span>
                                    </td>

                                    <td>
                                        <span class="payload-preview" title="{{ $log->payload }}">
                                            {{ $log->payload }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('security.logs.show', $log->id) }}"
                                               class="btn btn-sm btn-outline-info btn-action">
                                                Detail
                                            </a>

                                            <form action="{{ route('security.logs.destroy', $log->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirmHapus()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($logs->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-4 py-3"
                         style="border-top:1px solid rgba(255,255,255,.08);">
                        <span style="font-size:13px; opacity:.5;">
                            Menampilkan {{ $logs->firstItem() }}–{{ $logs->lastItem() }} dari {{ $logs->total() }} log
                        </span>
                        {{ $logs->links('pagination::bootstrap-5') }}
                    </div>
                @endif

            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
    function confirmHapus() {
        return confirm('Yakin ingin menghapus log ini?');
    }

    function confirmHapusSemua() {
        return confirm('Yakin ingin menghapus SEMUA log? Tindakan ini tidak bisa dibatalkan!');
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (localStorage.getItem('theme') === 'light') {
            document.body.classList.add('light-mode');
        }
    });
</script>
@endpush

@endsection