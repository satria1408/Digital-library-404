@extends('layout.dashboard-siswa')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                <i class="bi bi-journal-arrow-down"></i> Pengembalian Buku
            </h5>
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-light btn-sm fw-bold text-success rounded-pill px-3">
                ← Kembali ke Menu
            </a>
        </div>
        <div class="card-body p-4">
            @if($myBooks->isEmpty())
                <div class="alert alert-info mb-0 text-center rounded-3">Tidak ada data buku yang sedang kamu pinjam.</div>
            @else
                
                <div class="table-responsive d-none d-md-block">
                    <table class="table align-middle table-hover">
                        <thead class="table-light text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">
                            <tr>
                                <th>Detail Informasi Buku</th>
                                <th width="180">Tanggal Pinjam</th>
                                <th width="180">Batas Pengembalian</th>
                                <th width="220">Denda / Status</th>
                                <th width="140" class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($myBooks as $trans)
                                @php
                                    $deadline = $trans->tanggal_deadline ? \Carbon\Carbon::parse($trans->tanggal_deadline) : null;
                                    $today = \Carbon\Carbon::today();
                                    $terlambat = $deadline && $today->gt($deadline) && $trans->status == 'pinjam';
                                    $hariTerlambat = $terlambat ? $today->diffInDays($deadline) : 0;
                                    
                                    // SERAGAMKAN LOGIKA DENDA BERTINGKAT
                                    $dendaPerHari = match(true) {
                                        $hariTerlambat >= 30 => 10000,
                                        $hariTerlambat >= 14 => 8000,
                                        $hariTerlambat >= 7  => 5000,
                                        $hariTerlambat >= 3  => 2000,
                                        $hariTerlambat >= 1  => 1000,
                                        default              => 0,
                                    };
                                    $denda = $hariTerlambat * $dendaPerHari;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="shadow-sm rounded overflow-hidden border bg-light d-flex align-items-center justify-content-center" style="width: 36px; height: 48px; min-width: 36px;">
                                                <img src="{{ $trans->book->cover_url }}" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div>
                                                <strong class="text-dark d-block" style="font-size: 0.95rem;">{{ $trans->book->judul }}</strong>
                                                <span class="text-muted small text-uppercase" style="font-size: 0.7rem;">ID: #{{ str_pad($trans->book_id, 4, '0', STR_PAD_LEFT) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-secondary fw-medium">{{ \Carbon\Carbon::parse($trans->tanggal_pinjam)->format('d M Y') }}</span></td>
                                    <td>
                                        <span class="text-danger fw-bold">
                                            {{ $deadline ? $deadline->format('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($trans->status == 'pending')
                                            <span class="badge bg-info text-dark rounded-pill px-2.5 py-1">⏳ Menunggu Persetujuan</span>
                                        @elseif($terlambat)
                                            <span class="badge bg-danger rounded-3 p-2 text-start d-block" style="font-size: 0.75rem; font-weight: 500; line-height: 1.4;">
                                                ⚠ Terlambat {{ $hariTerlambat }} hari<br>
                                                Total: Rp {{ number_format($denda, 0, ',', '.') }} (Rp {{ number_format($dendaPerHari, 0, ',', '.') }}/hari)
                                            </span>
                                        @else
                                            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1">Aman / Tidak Denda</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('siswa.kembali', $trans->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold rounded-pill shadow-sm" {{ $trans->status == 'pending' ? 'disabled' : '' }}>
                                                {{ $trans->status == 'pending' ? 'Pending' : 'Kembalikan' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-md-none px-1 pt-2">
                    @foreach($myBooks as $trans)
                        @php
                            $deadline = $trans->tanggal_deadline ? \Carbon\Carbon::parse($trans->tanggal_deadline) : null;
                            $today = \Carbon\Carbon::today();
                            $terlambat = $deadline && $today->gt($deadline) && $trans->status == 'pinjam';
                            $hariTerlambat = $terlambat ? $today->diffInDays($deadline) : 0;
                            $dendaPerHari = match(true) {
                                $hariTerlambat >= 30 => 10000,
                                $hariTerlambat >= 14 => 8000,
                                $hariTerlambat >= 7  => 5000,
                                $hariTerlambat >= 3  => 2000,
                                $hariTerlambat >= 1  => 1000,
                                default              => 0,
                            };
                            $denda = $hariTerlambat * $dendaPerHari;
                        @endphp
                        <div class="card mb-3 border-0 shadow-sm"
                             style="border-left: 4px solid {{ $trans->status == 'pending' ? '#0dcaf0' : ($terlambat ? '#dc3545' : '#198754') }} !important;
                                    border-radius: 0 16px 16px 0;">
                            <div class="card-body p-3">

                                <div class="d-flex align-items-start gap-3 mb-2">
                                    <div class="shadow-sm rounded border bg-light overflow-hidden d-flex align-items-center justify-content-center" style="width: 45px; height: 60px; min-width: 45px;">
                                        <img src="{{ $trans->book->cover_url }}" alt="Cover" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="overflow-hidden flex-grow-1">
                                        <p class="fw-bold mb-0.5 text-dark" style="font-size: 14px; line-height: 1.3;">{{ $trans->book->judul }}</p>
                                        <span class="text-muted small text-uppercase" style="font-size: 0.65rem;">ID: #{{ str_pad($trans->book_id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>

                                <div class="mb-2.5" style="font-size: 12px; color: #6c757d;">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span style="min-width: 100px;">Tanggal Pinjam</span>
                                        <span>: {{ \Carbon\Carbon::parse($trans->tanggal_pinjam)->format('d M Y') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span style="min-width: 100px;">Batas Kembali</span>
                                        <span style="color:#dc3545; font-weight:600;">
                                            : {{ $deadline ? $deadline->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                </div>

                                @if($trans->status == 'pending')
                                    <div class="mb-3 px-2 py-2"
                                         style="background:#f0f8ff; border:1px solid #bfe3f7;
                                                border-radius:8px; font-size:12px; color:#084298; font-weight:600;">
                                        ⏳ Menunggu Persetujuan Admin
                                    </div>
                                @elseif($terlambat)
                                    <div class="mb-3 px-2 py-2"
                                         style="background:#fff5f5; border:1px solid #f5c2c7;
                                                border-radius:8px; font-size:12px;">
                                        <div style="color:#dc3545; font-weight:600; margin-bottom:2px;">
                                            ⚠ Terlambat {{ $hariTerlambat }} hari
                                        </div>
                                        <div style="color:#842029;">
                                            Rp {{ number_format($dendaPerHari, 0, ',', '.') }}/hari ·
                                            Total denda: <strong>Rp {{ number_format($denda, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3 px-2 py-2"
                                         style="background:#f0fdf4; border:1px solid #bbf7d0;
                                                border-radius:8px; font-size:12px; color:#166534;">
                                        Denda: <strong>- (Bebas Denda)</strong>
                                    </div>
                                @endif

                                <form action="{{ route('siswa.kembali', $trans->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm w-100 fw-bold shadow-sm"
                                            {{ $trans->status == 'pending' ? 'disabled' : '' }}
                                            style="background:{{ $trans->status == 'pending' ? '#e9ecef' : '#ffc107' }}; 
                                                   color:{{ $trans->status == 'pending' ? '#6c757d' : '#412f00' }}; border:none;
                                                   padding:9px; border-radius:20px; font-size:13px;">
                                        {{ $trans->status == 'pending' ? 'Menunggu Persetujuan' : 'Kembalikan Buku' }}
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                 </div>

            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#198754',
            customClass: { popup: 'rounded-4' }
        });
    @endif
</script>
@endsection