@extends('layout.app')

@section('content')
<div class="container-fluid py-3 px-3 px-md-4">

    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-secondary border-opacity-10">
        <div>
            <span class="badge bg-danger-subtle text-danger rounded-pill mb-1 px-2.5 py-1 fw-bold text-uppercase" style="font-size: 0.65rem;">Manajemen Denda</span>
            <h2 class="fw-extrabold mb-0" style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;">Data Keterlambatan</h2>
        </div>
        <div class="text-end d-none d-sm-block">
            <small class="text-muted d-block">Total Denda</small>
            <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill px-2.5">{{ $dendas->count() }} Transaksi</span>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">No</th>
                            <th>Buku</th>
                            <th>User</th>
                            <th class="text-center">Status</th>
                            <th class="text-center pe-4" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dendas as $index => $denda)
                            <tr>
                                <td class="ps-4">{{ $index + 1 }}</td>
                                <td>
                                    <span class="fw-semibold d-block">{{ $denda->transaction->book->judul ?? '-' }}</span>
                                    <small class="text-muted">Terlambat {{ $denda->hari_terlambat }} hari</small>
                                </td>
                                <td>
                                    {{ $denda->transaction->user->nama_lengkap ?? '-' }}
                                </td>
                                <td class="text-center">
                                    @if ($denda->status === 'lunas')
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">Lunas</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    @if ($denda->status !== 'lunas')
                                        <form action="{{ route('digitallibrary.admin.dendas.bayar', $denda->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                                <i class="bi bi-check-circle me-1"></i> Tandai Lunas
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-emoji-smile fs-2 d-block mb-2"></i>
                                    Tidak ada data keterlambatan saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection