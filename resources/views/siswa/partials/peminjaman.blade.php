@extends('layout.dashboard-siswa')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Peminjaman Buku</h5>
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-light btn-sm fw-bold text-primary">
                ← Kembali
            </a>
        </div>
        <div class="card-body">

            <div class="table-responsive d-none d-md-block">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                        <tr>
                            <td><strong>{{ $book->judul }}</strong></td>
                            <td>{{ $book->penulis ?? '-' }}</td>
                            <td>{{ $book->penerbit ?? '-' }}</td>
                            <td><span class="badge {{ $book->stok > 0 ? 'bg-success' : 'bg-danger' }}">{{ $book->stok }}</span></td>
                            <td>
                                @if($book->stok > 0)
                                    <button class="btn btn-primary btn-sm" onclick="pinjamBukuLangsung('{{ $book->id }}', '{{ addslashes($book->judul) }}')">Pinjam</button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Habis</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                    <small class="text-muted">
                        Menampilkan {{ $books->firstItem() }}–{{ $books->lastItem() }} dari {{ $books->total() }} buku
                    </small>
                    {{ $books->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <div class="d-md-none px-1 pt-2">
                @forelse($books as $book)
                    <div class="card mb-3 border-0 shadow-sm"
                         style="border-left: 3px solid {{ $book->stok > 0 ? '#378ADD' : '#888780' }} !important;
                                border-radius: 0 12px 12px 0;">
                        <div class="card-body p-3">

                            <p class="fw-bold mb-1" style="font-size: 15px;">{{ $book->judul }}</p>
                            <p class="text-muted mb-3" style="font-size: 12px;">
                                {{ $book->penulis ?? 'Tanpa Penulis' }} &nbsp;·&nbsp; {{ $book->penerbit ?? '-' }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                @if($book->stok > 0)
                                    <span style="background:#EAF3DE; color:#27500A; font-size:12px;
                                                 padding:4px 10px; border-radius:99px; font-weight:500;">
                                        Stok: {{ $book->stok }}
                                    </span>
                                    <button class="btn btn-sm"
                                            style="background:#185FA5; color:#E6F1FB; font-size:13px;
                                                   padding:7px 18px; border-radius:8px; border:none;"
                                            onclick="pinjamBukuLangsung('{{ $book->id }}', '{{ addslashes($book->judul) }}')">
                                        Pinjam
                                    </button>
                                @else
                                    <span style="background:#F1EFE8; color:#5F5E5A; font-size:12px;
                                                 padding:4px 10px; border-radius:99px; font-weight:500;">
                                        Stok: 0
                                    </span>
                                    <button class="btn btn-sm" disabled
                                            style="background:#e9ecef; color:#888; font-size:13px;
                                                   padding:7px 18px; border-radius:8px; border:none;">
                                        Habis
                                    </button>
                                @endif
                            </div>

                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted py-4">Tidak ada data buku.</p>
                @endforelse

                <div class="d-flex flex-column align-items-center gap-1 mt-2 pb-2">
                    <small class="text-muted">
                        Menampilkan {{ $books->firstItem() }}–{{ $books->lastItem() }} dari {{ $books->total() }} buku
                    </small>
                    {{ $books->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
</div>

<form id="formKirimPinjam" method="POST" action="" style="display: none;">
    @csrf
    <input type="hidden" id="submit_tanggal_pinjam" name="tanggal_pinjam">
    <input type="hidden" id="submit_tanggal_kembali" name="tanggal_kembali">
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function pinjamBukuLangsung(bookId, judulBuku) {
        const today = new Date().toISOString().split('T')[0];
        Swal.fire({
            title: 'Tentukan Tanggal',
            html: `
                <div class="text-start mb-2"><label class="small fw-bold">Tanggal Pinjam:</label><input type="date" id="swal_tgl_pinjam" class="form-control" value="${today}" min="${today}"></div>
                <div class="text-start mb-2"><label class="small fw-bold">Tanggal Pengembalian:</label><input type="date" id="swal_tgl_kembali" class="form-control" min="${today}"></div>
            `,
            confirmButtonText: 'Lanjut',
            confirmButtonColor: '#0d6efd',
            preConfirm: () => {
                const tglPinjam = document.getElementById('swal_tgl_pinjam').value;
                const tglKembali = document.getElementById('swal_tgl_kembali').value;
                if (!tglPinjam || !tglKembali || new Date(tglKembali) < new Date(tglPinjam)) {
                    Swal.showValidationMessage('Pastikan tanggal valid!'); return false;
                }
                return { tglPinjam, tglKembali }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Konfirmasi', text: "Yakin ingin meminjam buku ini?", icon: 'question', showCancelButton: true, confirmButtonText: 'Ya, Proses!', confirmButtonColor: '#0d6efd'
                }).then((konfirmasi) => {
                    if (konfirmasi.isConfirmed) {
                        const form = document.getElementById('formKirimPinjam');
                        form.action = "/siswa/pinjam/" + bookId;
                        document.getElementById('submit_tanggal_pinjam').value = result.value.tglPinjam;
                        document.getElementById('submit_tanggal_kembali').value = result.value.tglKembali;
                        form.submit();
                    }
                });
            }
        });
    }
</script>
@endsection