@extends('layout.auth')

@section('content')
<style>
html,
body{
    width:100%;
    height:100%;
    margin:0;
    overflow:hidden;
}

.page{
    position:fixed;
    inset:0;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;

    background:url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=3000&q=100')
    center center/cover no-repeat;
}

.page::before{
    content:'';
    position:absolute;
    inset:0;
    background:rgba(0,0,0,.45);
}

.glass-card{
    position:relative;
    z-index:1;
    width:100%;
    max-width:360px;

    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.15);
    backdrop-filter:blur(14px);
    border-radius:16px;
}

.card-header{
    background:transparent;
    border-bottom:1px solid rgba(255,255,255,.1);
}

.card-title{
    color:#fff;
    font-size:20px;
    margin-bottom:4px;
}

.text-muted-custom{
    color:rgba(255,255,255,.65);
    font-size:13px;
}

.form-label{
    color:#fff;
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:.05em;
    margin-bottom:6px;
}

.form-control{
    background:rgba(255,255,255,.08)!important;
    border:1px solid rgba(255,255,255,.2)!important;
    color:#fff!important;
    border-radius:8px;
}

.form-control::placeholder{
    color:rgba(255,255,255,.4)!important;
}

.form-control:focus{
    border-color:rgba(100,180,255,.7)!important;
    box-shadow:0 0 0 .2rem rgba(100,180,255,.15)!important;
}

textarea{
    resize:none;
}

.btn-outline-light:hover{
    color:#000;
}
</style>

<div class="page">

    <div class="card glass-card shadow-lg border-0">

        <div class="card-header text-center py-3">
            <h4 class="card-title">
                Daftar Anggota
            </h4>

            <p class="text-muted-custom mb-0">
                Buat akun baru untuk mulai meminjam buku
            </p>
        </div>

        <div class="card-body p-3">

            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama_lengkap"
                        class="form-control"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('nama_lengkap') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        class="form-control"
                        placeholder="Masukkan username"
                        value="{{ old('username') }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Ulangi password"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        rows="2"
                        class="form-control"
                        placeholder="Masukkan alamat"
                    >{{ old('alamat') }}</textarea>
                </div>

                <button
                    type="submit"
                    class="btn btn-success w-100">
                    Daftar
                </button>
            </form>

            <hr class="my-3 text-light">

            <a
                href="{{ route('login') }}"
                class="btn btn-outline-light w-100">
                Kembali ke Login
            </a>

        </div>

    </div>

</div>

<script>
  document.querySelector('form').addEventListener('submit', function () {
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
  });
</script>

@endsection