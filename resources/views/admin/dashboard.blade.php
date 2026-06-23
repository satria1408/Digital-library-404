@extends('layout.app')

@section('content')

<style>
.dashboard-bg{
    min-height:calc(100vh - 56px);
    padding:30px;
    background:linear-gradient(
        135deg,
        #0f172a 0%,
        #1e3a8a 50%,
        #2563eb 100%
    );
    transition:.3s;
}

.dashboard-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.dashboard-title{
    color:#fff;
    font-weight:700;
    margin:0;
}

.theme-switch{
    background:rgba(255,255,255,.15);
    padding:10px 15px;
    border-radius:12px;
    backdrop-filter:blur(10px);
}

.theme-switch .form-check-label{
    color:#fff;
    font-size:14px;
    font-weight:500;
    cursor:pointer;
}

.theme-switch .form-check-input{
    cursor:pointer;
}

.dashboard-card{
    border:none;
    border-radius:16px;
    backdrop-filter:blur(10px);
    background:rgba(255,255,255,.12);
    color:#fff;
    transition:.3s;
    height:100%;
}

.dashboard-card:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 30px rgba(0,0,0,.25);
}

.dashboard-card .card-header{
    background:rgba(255,255,255,.1);
    border-bottom:1px solid rgba(255,255,255,.15);
    font-weight:600;
}

.dashboard-card .card-text{
    color:rgba(255,255,255,.85);
}

.dashboard-card .btn{
    border-radius:10px;
}

/* LIGHT MODE */
body.light-mode .dashboard-bg{
    background:linear-gradient(
        135deg,
        #e2e8f0 0%,
        #cbd5e1 50%,
        #94a3b8 100%
    );
}

body.light-mode .dashboard-title{
    color:#0f172a;
}

body.light-mode .theme-switch{
    background:rgba(255,255,255,.8);
}

body.light-mode .theme-switch .form-check-label{
    color:#0f172a;
}

body.light-mode .dashboard-card{
    background:rgba(255,255,255,.85);
    color:#0f172a;
}

body.light-mode .dashboard-card .card-header{
    background:#f8fafc;
    border-bottom:1px solid #e2e8f0;
}

body.light-mode .dashboard-card .card-text{
    color:#475569;
}
</style>

<div class="dashboard-bg">

    <div class="dashboard-header">

        <h1 class="dashboard-title">
            Dashboard Admin
        </h1>

        <div class="theme-switch">
            <div class="form-check form-switch m-0">

                <input
                    class="form-check-input"
                    type="checkbox"
                    id="themeSwitch">

                <label
                    class="form-check-label"
                    for="themeSwitch"
                    id="themeLabel">
                    Light Mode
                </label>

            </div>
        </div>

    </div>

    <div class="row g-4">

        <div class="col-md-4">

            <div class="card dashboard-card">

                <div class="card-header">
                    Kelola Data Buku
                </div>

                <div class="card-body">

                    <p class="card-text">
                        Tambah, edit, hapus dan kelola data buku perpustakaan.
                    </p>

                    <a href="{{ route('books.index') }}"
                       class="btn btn-primary">
                        Buka Menu
                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card dashboard-card">

                <div class="card-header">
                    Kelola Anggota
                </div>

                <div class="card-body">

                    <p class="card-text">
                        Manajemen data anggota dan siswa perpustakaan.
                    </p>

                    <a href="{{ route('users.index') }}"
                       class="btn btn-primary">
                        Buka Menu
                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card dashboard-card">

                <div class="card-header">
                    Laporan Transaksi
                </div>

                <div class="card-body">

                    <p class="card-text">
                        Lihat riwayat peminjaman dan pengembalian buku.
                    </p>

                    <a href="{{ route('transactions.index') }}"
                       class="btn btn-primary">
                        Buka Menu
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const switchBtn = document.getElementById('themeSwitch');
    const label = document.getElementById('themeLabel');

    if(localStorage.getItem('theme') === 'light'){
        document.body.classList.add('light-mode');
        switchBtn.checked = true;
        label.innerText = 'Dark Mode';
    }

    switchBtn.addEventListener('change', function(){

        document.body.classList.toggle('light-mode');

        if(document.body.classList.contains('light-mode')){
            localStorage.setItem('theme', 'light');
            label.innerText = 'Dark Mode';
        }else{
            localStorage.setItem('theme', 'dark');
            label.innerText = 'Light Mode';
        }

    });

});
</script>

@endsection