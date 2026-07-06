@extends('layout.developer')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary"><i class="bi bi-inboxes-fill"></i> Kotak Saran & Keluhan Sistem</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('developer.suggestions.export') }}" class="btn btn-sm btn-success px-3">
                        <i class="bi bi-file-earmark-excel-fill"></i> Ekspor Excel (Bulan Ini)
                    </a>
                    
                    <a href="{{ route('developer.dashboard') }}" class="btn btn-sm btn-outline-secondary px-3">
                        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                    </a>
                    <span class="badge bg-dark px-3 py-2 font-monospace">Developer Mode</span>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th class="ps-3" style="width: 13%">Kode Tiket</th>
                                    <th style="width: 13%">Pengirim</th>
                                    <th style="width: 17%">Subjek</th>
                                    <th style="width: 22%">Isi Keluhan</th>
                                    <th style="width: 9%">Status</th>
                                    <th class="text-center" style="width: 13%">Aksi</th>
                                    <th class="text-center" style="width: 8%">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suggestions as $item)
                                    <tr>
                                        <td class="ps-3">
                                            <strong class="text-monospace text-danger">{{ $item->ticket_code }}</strong>
                                        </td>
                                        <td>
                                            @if($item->user)
                                                <span class="fw-semibold text-dark">{{ $item->user->nama_lengkap }}</span>
                                                <br><small class="text-muted">Siswa</small>
                                            @else
                                                <span class="text-muted italic"><i class="bi bi-person-fill-slash"></i> Anonim</span>
                                            @endif
                                        </td>
                                        <td><span class="fw-semibold">{{ $item->subjek }}</span></td>
                                        <td>
                                            <p class="mb-0 text-truncate" style="max-width: 250px;" title="{{ $item->isi_saran }}">
                                                {{ $item->isi_saran }}
                                            </p>
                                            <small class="text-muted d-block" style="font-size: 11px;">
                                                <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y - H:i') }} WIB
                                            </small>
                                        </td>
                                        <td>
                                            @if($item->status == 'unread')
                                                <span class="badge bg-danger">Unread</span>
                                            @elseif($item->status == 'read')
                                                <span class="badge bg-warning text-dark">Read</span>
                                            @else
                                                <span class="badge bg-success">Replied</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#replyModal{{ $item->id }}">
                                                @if($item->status == 'replied')
                                                    <i class="bi bi-eye"></i> Lihat / Edit
                                                @else
                                                    <i class="bi bi-pencil-square"></i> Balas
                                                @endif
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('developer.suggestions.destroy', $item->id) }}" method="POST" class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger px-2 btn-delete" title="Hapus laporan">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="replyModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title fw-bold">Detail Tiket: <span class="text-danger">{{ $item->ticket_code }}</span></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('developer.suggestions.reply', $item->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <label class="fw-bold text-muted small mb-0">Subjek Surat:</label>
                                                            <p class="fw-semibold text-dark mb-2">{{ $item->subjek }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="fw-bold text-muted small mb-0">Isi Pengajuan/Keluhan:</label>
                                                            <div class="p-3 bg-light rounded text-dark" style="white-space: pre-line;">{{ $item->isi_saran }}</div>
                                                        </div>
                                                        <hr>
                                                        <div class="mb-3">
                                                            <label for="reply_developer{{ $item->id }}" class="form-label fw-bold text-primary"><i class="bi bi-reply-fill"></i> Balasan Developer:</label>
                                                            <textarea class="form-control" id="reply_developer{{ $item->id }}" name="reply_developer" rows="4" placeholder="Ketik jawaban lo di sini bro..." required>{{ $item->reply_developer }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary px-4">Kirim Balasan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="bi bi-folder-x fs-2 d-block mb-2"></i> Belum ada saran atau keluhan yang masuk ke sistem.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// SweetAlert Success (pesan sukses dari session, misal setelah hapus/balas)
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
@endif

// Konfirmasi Hapus pakai SweetAlert
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function () {
        const form = this.closest('.delete-form');

        Swal.fire({
            title: 'Hapus Laporan?',
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
</script>
@endpush
@endsection