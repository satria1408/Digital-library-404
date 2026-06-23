@extends('layout.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Kelola Anggota</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Anggota</a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('users.index') }}" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="text" name="search" class="form-control"
               placeholder="Cari nama, username, atau alamat..."
               value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Cari</button>
    </div>
    <div class="col-md-2">
        <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">Reset</a>
    </div>
</form>

@if(request('search'))
    <p class="text-muted small mb-2">
        Menampilkan {{ $users->count() }} hasil untuk "<strong>{{ request('search') }}</strong>"
    </p>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->nama_lengkap }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->alamat ?? '-' }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}"
                           class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}"
                              method="POST" class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data anggota.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false,
    });
@endif

document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function () {
        const form = this.closest('.delete-form');
        Swal.fire({
            title: 'Hapus Anggota?',
            text: 'Semua data peminjaman terkait juga akan terhapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
        }).then(result => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush