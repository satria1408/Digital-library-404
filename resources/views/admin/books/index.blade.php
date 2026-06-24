@extends('layout.app')

@section('content')

<div class="mx-auto" style="max-width:1100px;">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <h2 class="mb-0">Data Buku</h2>

        <a href="{{ route('books.create') }}" class="btn btn-primary">
            Tambah Buku
        </a>
    </div>

    <form
        id="filterForm"
        method="GET"
        action="{{ route('books.index') }}"
        class="row g-2 mb-3">

        <div class="col-12 col-md-6">
            <input
                id="searchInput"
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari judul, penulis, penerbit..."
                value="{{ request('search') }}">
        </div>

        <div class="col-12 col-md-4">
            <select
                id="kategoriSelect"
                name="kategori"
                class="form-select">

                <option value="">Semua Kategori</option>

                @foreach($kategoris as $k)
                    <option
                        value="{{ $k }}"
                        {{ request('kategori') == $k ? 'selected' : '' }}>
                        {{ $k }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="col-12 col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">
                Cari
            </button>

            <a href="{{ route('books.index') }}"
               class="btn btn-secondary w-100">
                Reset
            </a>
        </div>

    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-bordered mb-0 align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th width="60">No</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Kategori</th>
                            <th width="80">Stok</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($books as $book)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $book->judul }}</td>

                                <td>{{ $book->penulis }}</td>

                                <td>{{ $book->penerbit }}</td>

                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $book->kategori ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="fw-bold {{ $book->stok > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $book->stok }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-1">

                                        <a
                                            href="{{ route('books.edit', $book->id) }}"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('books.destroy', $book->id) }}"
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
                                    Tidak ada buku ditemukan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

    @if(request('search') || request('kategori'))

        <div class="alert alert-light border mt-3">

            Menampilkan
            <strong>{{ $books->count() }}</strong>
            hasil

            @if(request('search'))
                untuk
                <strong>"{{ request('search') }}"</strong>
            @endif

            @if(request('kategori'))
                dalam kategori
                <strong>"{{ request('kategori') }}"</strong>
            @endif

        </div>

    @endif

</div>

@endsection

@push('scripts')

<style>
@media (max-width: 768px){

    h2{
        font-size: 1.35rem;
    }

    .table{
        font-size: .85rem;
    }

    .table th,
    .table td{
        white-space: nowrap;
        vertical-align: middle;
    }

    .btn{
        font-size: .8rem;
    }

    .alert{
        font-size: .9rem;
    }

    .card{
        border-radius: 12px;
    }
}
</style>

<script>

// SweetAlert Success
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
@endif

// Konfirmasi Hapus
document.querySelectorAll('.btn-delete').forEach(button => {

    button.addEventListener('click', function () {

        const form = this.closest('.delete-form');

        Swal.fire({
            title: 'Hapus Buku?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
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

// Live Search
const searchInput = document.getElementById('searchInput');
const kategoriSelect = document.getElementById('kategoriSelect');
const filterForm = document.getElementById('filterForm');

let searchTimeout;

if (searchInput) {

    searchInput.addEventListener('input', function () {

        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(() => {
            filterForm.submit();
        }, 500);

    });

}

if (kategoriSelect) {

    kategoriSelect.addEventListener('change', function () {
        filterForm.submit();
    });

}

</script>
@endpush 