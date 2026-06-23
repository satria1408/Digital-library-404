@extends('layout.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Kelola Transaksi</h2>

    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
        Tambah Peminjaman
    </a>
</div>

{{-- Filter & Search --}}
<form method="GET" action="{{ route('transactions.index') }}" class="row g-2 mb-3">

    <div class="col-md-5">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari nama peminjam..."
            value="{{ request('search') }}">
    </div>

    <div class="col-md-3">
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

    <div class="col-md-2">
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

    <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100">
            Cari
        </button>

        <a href="{{ route('transactions.index') }}" class="btn btn-secondary w-100">
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
    <div class="card-body">

        <table class="table table-bordered table-striped align-middle">

            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
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

                            <span class="badge {{ $trans->status == 'pinjam' ? 'bg-warning text-dark' : 'bg-success' }}">
                                {{ ucfirst($trans->status) }}
                            </span>

                        </td>

                        <td>

                            @if($trans->denda)

                                <span class="badge {{ $trans->denda->status == 'lunas' ? 'bg-success' : 'bg-danger' }}">

                                    Rp {{ number_format($trans->denda->nominal, 0, ',', '.') }}

                                    ({{ $trans->denda->status == 'lunas' ? 'Lunas' : 'Belum Bayar' }})

                                </span>

                            @else

                                <span class="text-muted">-</span>

                            @endif

                        </td>

                        <td>

                            <a
                                href="{{ route('transactions.edit', $trans->id) }}"
                                class="btn btn-info btn-sm">
                                Edit
                            </a>

                            <form
                                action="{{ route('transactions.destroy', $trans->id) }}"
                                method="POST"
                                class="d-inline delete-form">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm btn-delete">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Tidak ada data transaksi.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection

@push('scripts')
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