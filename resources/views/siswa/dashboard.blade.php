@extends('layout.app')

@section('content')

<div class="container py-4">

    {{-- Header --}}
    <div class="dashboard-header mb-4">

        <div>
            <h1 id="dashboardTitle" class="fw-bold mb-1">
                Dashboard Siswa
            </h1>

            <p class="text-secondary mb-0">
                Kelola peminjaman dan pengembalian buku
            </p>
        </div>

        <button id="themeBtn" class="btn btn-dark">
            Dark Mode
        </button>

    </div>

    {{-- Statistik --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Total Buku</h6>
                    <h2 class="fw-bold mb-0">
                        {{ $books->count() }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Buku Dipinjam</h6>
                    <h2 class="fw-bold mb-0">
                        {{ $myBooks->count() }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Buku Tersedia</h6>
                    <h2 class="fw-bold mb-0">
                        {{ $books->where('stok', '>', 0)->count() }}
                    </h2>
                </div>
            </div>
        </div>

    </div>

    {{-- PEMINJAMAN --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Peminjaman Buku</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table custom-table align-middle">

                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th width="100">Stok</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($books as $book)

                            <tr>

                                <td data-label="Judul Buku">
                                    <strong>{{ $book->judul }}</strong>
                                </td>

                                <td data-label="Penulis">
                                    {{ $book->penulis ?? '-' }}
                                </td>

                                <td data-label="Penerbit">
                                    {{ $book->penerbit ?? '-' }}
                                </td>

                                <td data-label="Stok">

                                    @if($book->stok > 0)

                                        <span class="badge bg-success">
                                            {{ $book->stok }}
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Habis
                                        </span>

                                    @endif

                                </td>

                                <td data-label="Aksi">

                                    @if($book->stok > 0)

                                        <button class="btn btn-primary btn-sm w-100 btn-trigger-pinjam" 
                                                data-id="{{ $book->id }}" 
                                                data-judul="{{ $book->judul }}">
                                            Pinjam
                                        </button>

                                    @else

                                        <button class="btn btn-secondary btn-sm w-100" disabled>
                                            Tidak Tersedia
                                        </button>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center py-4 layout-empty">
                                    Tidak ada buku tersedia.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- PENGEMBALIAN --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Pengembalian Buku</h5>
        </div>

        <div class="card-body">

            @if($myBooks->isEmpty())

                <div class="alert alert-info mb-0">
                    Tidak ada buku yang sedang dipinjam.
                </div>

            @else

                <div class="table-responsive">

                    <table class="table custom-table align-middle">

                        <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th width="150">Tanggal Pinjam</th>
                                <th width="150">Batas Pengembalian</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($myBooks as $trans)

                                <tr>

                                    <td data-label="Judul Buku">
                                        {{ $trans->book->judul }}
                                    </td>

                                    <td data-label="Tanggal Pinjam">
                                        {{ \Carbon\Carbon::parse($trans->tanggal_pinjam)->format('d M Y') }}
                                    </td>

                                    <td data-label="Batas Pengembalian">
                                        <span class="text-danger fw-bold">
                                            {{ $trans->tanggal_deadline ? \Carbon\Carbon::parse($trans->tanggal_deadline)->format('d M Y') : '-' }}
                                        </span>
                                    </td>

                                    <td data-label="Aksi">

                                        <form action="/siswa/kembali/{{ $trans->id }}" method="POST">
                                            @csrf

                                            <button class="btn btn-warning btn-sm w-100">
                                                Kembalikan
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>

</div>

{{-- MODAL KALENDER PEMINJAMAN --}}
<div class="modal fade" id="kalenderPinjamModal" tabindex="-1" aria-labelledby="kalenderPinjamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="kalenderPinjamModalLabel">Tentukan Tanggal Peminjaman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formKalenderPinjam" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="mb-3">Buku yang dipilih: <strong id="modalBukuJudul"></strong></p>
                    
                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label fw-bold">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label fw-bold">Tanggal Pengembalian</label>
                        <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi Pinjam</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>

/* ===== HEADER ===== */

.dashboard-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
}

#dashboardTitle{
    transition:.3s;
}

/* ===== LIGHT MODE ===== */

body{
    background:#f8fafc !important;
    color:#212529;
    transition:.3s;
}

.card{
    border-radius:16px;
}

.custom-table{
    margin-bottom:0;
}

.custom-table th{
    font-weight:600;
}

.stat-card{
    transition:.3s;
}

/* ===== DARK MODE ===== */

body.dark-mode{
    background:#121212 !important;
    color:#ffffff !important;
}

body.dark-mode #dashboardTitle{
    color:#ffffff !important;
}

body.dark-mode .card{
    background:#1e1e1e !important;
    color:#ffffff !important;
}

body.dark-mode .card-body,
body.dark-mode .card-title,
body.dark-mode h1,
body.dark-mode h2,
body.dark-mode h3,
body.dark-mode h4,
body.dark-mode h5,
body.dark-mode h6,
body.dark-mode p{
    color:#ffffff !important;
}

body.dark-mode .text-muted{
    color:#bdbdbd !important;
}

body.dark-mode .custom-table{
    color:#ffffff !important;
}

body.dark-mode .custom-table th,
body.dark-mode .custom-table td{
    background:#1e1e1e !important;
    color:#ffffff !important;
    border-color:#3a3a3a !important;
}

body.dark-mode .alert{
    background:#2a2a2a;
    color:#ffffff;
    border-color:#444;
}

/* Dark Mode Penyesuaian untuk Modal */
body.dark-mode .modal-content {
    background: #1e1e1e;
    color: #ffffff;
    border: 1px solid #3a3a3a;
}

body.dark-mode .modal-footer {
    border-top: 1px solid #3a3a3a;
}

body.dark-mode .form-control {
    background: #2a2a2a;
    border-color: #444;
    color: #ffffff;
}

body.dark-mode .form-control:focus {
    background: #2a2a2a;
    color: #ffffff;
}

/* ===== MOBILE RESPONSIVE (FIXED & ALIGNED) ===== */

@media(max-width:768px){

    .dashboard-header{
        flex-direction:column;
        align-items:stretch;
    }

    #themeBtn{
        width:100%;
    }

    #dashboardTitle{
        text-align:center;
        font-size:1.8rem;
    }

    .dashboard-header p{
        text-align:center;
    }

    .custom-table thead {
        display: none;
    }

    .custom-table, 
    .custom-table tbody, 
    .custom-table tr, 
    .custom-table td {
        display: block;
        width: 100%;
    }

    .custom-table tr {
        margin: 15px 10px;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 10px;
        background: #ffffff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    
    body.dark-mode .custom-table tr {
        border-color: #3a3a3a !important;
        background: #1e1e1e !important;
    }

    .custom-table td {
        text-align: right;
        padding: 10px 12px;
        border-bottom: 1px dashed #edf2f7 !important;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Baris terakhir (tombol) tidak butuh border bawah */
    .custom-table td:last-child {
        border-bottom: none !important;
        padding-top: 12px;
    }

    .custom-table td::before {
        content: attr(data-label);
        font-weight: 600;
        text-align: left;
        font-size: 0.85rem;
        color: #6c757d;
        flex-shrink: 0;
        margin-right: 15px;
    }
    
    body.dark-mode .custom-table td::before {
        color: #bdbdbd;
    }

    /* Memastikan isi teks rata kanan dan tidak meluber keluar box */
    .custom-table td strong,
    .custom-table td span,
    .custom-table td form {
        text-align: right;
        word-break: break-word;
    }

    .custom-table td.layout-empty {
        display: block;
        text-align: center;
    }
    .custom-table td.layout-empty::before {
        display: none;
    }

    .btn-sm{
        min-width: 100px;
    }

}

@media(max-width:576px){

    .container{
        padding-left:12px;
        padding-right:12px;
    }

    #dashboardTitle{
        font-size:1.5rem;
    }

    .card-header h5{
        font-size:1rem;
    }

}

</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

const themeBtn = document.getElementById('themeBtn');

function updateThemeButton(){
    if(document.body.classList.contains('dark-mode')){
        themeBtn.textContent = 'Light Mode';
        themeBtn.classList.remove('btn-dark');
        themeBtn.classList.add('btn-light');
    }else{
        themeBtn.textContent = 'Dark Mode';
        themeBtn.classList.remove('btn-light');
        themeBtn.classList.add('btn-dark');
    }
}

if(localStorage.getItem('theme') === 'dark'){
    document.body.classList.add('dark-mode');
}

updateThemeButton();

themeBtn.addEventListener('click', function(){
    document.body.classList.toggle('dark-mode');
    localStorage.setItem(
        'theme',
        document.body.classList.contains('dark-mode') ? 'dark' : 'light'
    );
    updateThemeButton();
});

/* ===== JS LOGIC MODAL KALENDER WITH 1 MONTH LIMIT ===== */
document.querySelectorAll('.btn-trigger-pinjam').forEach(button => {
    button.addEventListener('click', function() {
        const bookId = this.getAttribute('data-id');
        const bookJudul = this.getAttribute('data-judul');
        
        document.getElementById('modalBukuJudul').textContent = bookJudul;
        document.getElementById('formKalenderPinjam').setAttribute('action', `/siswa/pinjam/${bookId}`);
        
        const dtHariIni = new Date();
        const formatHariIni = dtHariIni.toISOString().split('T')[0];
        
        const dtMaksimal = new Date();
        dtMaksimal.setDate(dtHariIni.getDate() + 30);
        const formatMaksimal = dtMaksimal.toISOString().split('T')[0];
        
        const inputPinjam = document.getElementById('tanggal_pinjam');
        inputPinjam.value = formatHariIni;
        inputPinjam.setAttribute('min', formatHariIni);
        
        const inputKembali = document.getElementById('tanggal_kembali');
        inputKembali.value = formatHariIni;
        inputKembali.setAttribute('min', formatHariIni);
        inputKembali.setAttribute('max', formatMaksimal);

        inputPinjam.addEventListener('change', function() {
            inputKembali.setAttribute('min', this.value);
            
            const dtPinjamBaru = new Date(this.value);
            const dtMaksBaru = new Date(dtPinjamBaru);
            dtMaksBaru.setDate(dtPinjamBaru.getDate() + 30);
            
            inputKembali.setAttribute('max', dtMaksBaru.toISOString().split('T')[0]);
        });

        const kalenderModal = new bootstrap.Modal(document.getElementById('kalenderPinjamModal'));
        kalenderModal.show();
    });
});

/* ===== SWEETALERT POP-UP HANDLING ===== */
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2500
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
        confirmButtonColor: '#3085d6'
    });
@endif

@if($errors->any())
    Swal.fire({
        icon: 'warning',
        title: 'Periksa Kembali!',
        text: "{{ $errors->first() }}",
        confirmButtonColor: '#e11d48'
    });
@endif

</script>

@endsection