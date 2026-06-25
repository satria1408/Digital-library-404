@extends('layout.dashboard-siswa')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Pengembalian Buku</h5>
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-light btn-sm fw-bold text-success">
                ← Kembali ke Menu
            </a>
        </div>
        <div class="card-body">
            @if($myBooks->isEmpty())
                <div class="alert alert-info mb-0 text-center">Tidak ada data buku yang sedang kamu pinjam.</div>
            @else
                <div class="table-responsive d-none d-md-block">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th width="180">Tanggal Pinjam</th>
                                <th width="180">Batas Pengembalian</th>
                                <th width="150">Denda / Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($myBooks as $trans)
                                @php
                                    $deadline = $trans->tanggal_deadline ? \Carbon\Carbon::parse($trans->tanggal_deadline) : null;
                                    $today = \Carbon\Carbon::today();
                                    $terlambat = $deadline && $today->gt($deadline) && $trans->status == 'pinjam';
                                    $hariTerlambat = $terlambat ? $today->diffInDays($deadline) : 0;
                                    $denda = $terlambat ? $hariTerlambat * 1000 : 0;
                                @endphp
                                <tr>
                                    <td><strong>{{ $trans->book->judul }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($trans->tanggal_pinjam)->format('d M Y') }}</td>
                                    <td>
                                        <span class="text-danger fw-bold">
                                            {{ $deadline ? $deadline->format('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($trans->status == 'pending')
                                            <span class="badge bg-info text-dark">Menunggu Persetujuan</span>
                                        @elseif($terlambat)
                                            <span class="badge bg-danger">
                                                Terlambat {{ $hariTerlambat }} hari · Rp {{ number_format($denda, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('siswa.kembali', $trans->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold" {{ $trans->status == 'pending' ? 'disabled' : '' }}>
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
                             style="border-left: 3px solid {{ $trans->status == 'pending' ? '#0dcaf0' : ($terlambat ? '#dc3545' : '#198754') }} !important;
                                    border-radius: 0 12px 12px 0;">
                            <div class="card-body p-3">

                                <p class="fw-bold mb-1" style="font-size: 15px;">{{ $trans->book->judul }}</p>

                                <div class="mb-2" style="font-size: 12px; color: #6c757d;">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span style="min-width: 110px;">Tanggal Pinjam</span>
                                        <span>: {{ \Carbon\Carbon::parse($trans->tanggal_pinjam)->format('d M Y') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span style="min-width: 110px;">Batas Kembali</span>
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
                                        Denda: <strong>-</strong>
                                    </div>
                                @endif

                                <form action="{{ route('siswa.kembali', $trans->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm w-100 fw-bold"
                                            {{ $trans->status == 'pending' ? 'disabled' : '' }}
                                            style="background:{{ $trans->status == 'pending' ? '#6c757d' : '#ffc107' }}; 
                                                   color:{{ $trans->status == 'pending' ? '#ffffff' : '#5a3e00' }}; border:none;
                                                   padding:8px; border-radius:8px; font-size:13px;">
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
            confirmButtonColor: '#198754'
        });
    @endif
</script>
@endsection