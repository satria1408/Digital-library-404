@extends('layout.app')

@section('content')

<div class="mx-auto" style="max-width:1100px;">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <h2 class="mb-0">Kelola Transaksi</h2>

        <a href="{{ route('digitallibrary.admin.transactions.create') }}" class="btn btn-primary">
            Tambah Peminjaman
        </a>
    </div>

    {{-- Filter & Search --}}
    <form method="GET"
          action="{{ route('digitallibrary.admin.transactions.index') }}"
          class="row g-2 mb-3">

        <div class="col-12 col-md-5">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari nama peminjam..."
                value="{{ request('search') }}">
        </div>

        <div class="col-12 col-md-3">
            <select name="keterlambatan" class="form-select">

                <option value="">Semua Keterlambatan</option>

                <option
                    value="terlambat"
                    {{ request('keterlambatan') == 'terlambat' ? 'selected' : '' }}>
                    Terlambat
                </option>

                <option
                    value="tidak_terlambat"
                    {{ request('keterlambatan') == 'tidak_terlambat' ? 'selected' : '' }}>
                    Tidak Terlambat
                </option>

            </select>
        </div>

        <div class="col-12 col-md-2">
            <select name="status" class="form-select">

                <option value="">Semua Status</option>

                <option
                    value="pinjam"
                    {{ request('status') == 'pinjam' ? 'selected' : '' }}>
                    Dipinjam
                </option>

                <option
                    value="kembali"
                    {{ request('status') == 'kembali' ? 'selected' : '' }}>
                    Dikembalikan
                </option>

            </select>
        </div>

        <div class="col-12 col-md-2 d-flex gap-2">

            <button type="submit" class="btn btn-primary w-100">
                Cari
            </button>

            <a href="{{ route('digitallibrary.admin.transactions.index') }}"
               class="btn btn-secondary w-100">
                Reset
            </a>

        </div>

    </form>

    {{-- Info Hasil Filter --}}
    @if(request('search') || request('keterlambatan') || request('status'))

        <div class="alert alert-light border">

            Menampilkan
            <strong>{{ $transactions->count() }}</strong>
            hasil

            @if(request('search'))
                untuk
                <strong>"{{ request('search') }}"</strong>
            @endif

            @if(request('keterlambatan'))
                —
                <strong>
                    {{ request('keterlambatan') == 'terlambat' ? 'Terlambat' : 'Tidak Terlambat' }}
                </strong>
            @endif

            @if(request('status'))
                —
                Status:
                <strong>{{ ucfirst(request('status')) }}</strong>
            @endif

        </div>

    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-bordered mb-0 align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th width="60">No</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th width="120">Tgl Pinjam</th>
                            <th width="160">Batas Kembali</th>
                            <th width="100">Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($transactions as $trans)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $trans->user->nama_lengkap }}</td>

                                <td>{{ $trans->book->judul }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($trans->tanggal_pinjam)->format('d M Y') }}
                                </td>

                                <td>

                                    @if($trans->tanggal_kembali)

                                        @php
                                            $terlambat =
                                                \Carbon\Carbon::parse($trans->tanggal_kembali)->isPast()
                                                && $trans->status == 'pinjam';
                                        @endphp

                                        <span class="{{ $terlambat ? 'text-danger fw-bold' : '' }}">

                                            {{ \Carbon\Carbon::parse($trans->tanggal_kembali)->format('d M Y') }}

                                            @if($terlambat)
                                                <span class="badge bg-danger ms-1">
                                                    Terlambat
                                                </span>
                                            @endif

                                        </span>

                                    @else

                                        <span class="text-muted">-</span>

                                    @endif

                                </td>

                                <td>

                                    <span class="badge {{ $trans->status == 'pinjam' ? 'bg-warning text-dark' : ($trans->status == 'pending' ? 'bg-info text-dark' : 'bg-success') }}">
                                        {{ ucfirst($trans->status) }}
                                    </span>

                                </td>

                                <td>

                                    <div class="d-flex flex-wrap gap-1">

                                        @if($trans->status == 'pending')
                                            <form action="{{ route('digitallibrary.admin.transactions.setujui', $trans->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm fw-bold">Setuju</button>
                                            </form>

                                            <form action="{{ route('digitallibrary.admin.transactions.tolak', $trans->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-secondary btn-sm">Tolak</button>
                                            </form>
                                        @endif

                                        <a
                                            href="{{ route('digitallibrary.admin.transactions.edit', $trans->id) }}"
                                            class="btn btn-info btn-sm">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('digitallibrary.admin.transactions.destroy', $trans->id) }}"
                                            method="POST"
                                            class="delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="button"
                                                class="btn btn-danger btn-sm btn-delete">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Tidak ada data transaksi.
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

@push('scripts')

<style>
@media (max-width: 768px){

    h2{
        font-size:1.35rem;
    }

    .table{
        font-size:.85rem;
    }

    .table th,
    .table td{
        white-space:nowrap;
        vertical-align:middle;
    }

    .btn{
        font-size:.8rem;
    }

    .alert{
        font-size:.9rem;
    }

    .card{
        border-radius:12px;
    }
}
</style>

<script>

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session('error') }}'
});
@endif

document.querySelectorAll('.btn-delete').forEach(button => {

    button.addEventListener('click', function () {

        const form = this.closest('.delete-form');

        Swal.fire({
            title: 'Hapus Transaksi?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});

document.querySelectorAll('select[name="keterlambatan"], select[name="status"]').forEach(select => {

    select.addEventListener('change', function () {
        this.closest('form').submit();
    });

});

</script>
@endpush