@extends('layout.auth')

@section('content')
<style>
.page{
    position:fixed;
    inset:0;
    width:100vw;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;

    background-image:url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=3000&q=100');
    background-size:cover;
    background-position:center center;
    background-repeat:no-repeat;
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
    border-radius:14px;
    backdrop-filter:blur(14px);
    overflow:hidden;
}

.card-header-custom{
    padding:28px 32px 24px;
    text-align:center;
    border-bottom:1px solid rgba(255,255,255,.1);
}

.card-header-custom h1{
    color:#fff;
    font-size:20px;
    margin-bottom:5px;
}

.card-header-custom p{
    color:rgba(255,255,255,.7);
    font-size:13px;
    margin:0;
}

.form-label{
    color:rgba(255,255,255,.65);
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:.05em;
}

.form-control{
    background:rgba(255,255,255,.08)!important;
    border:1px solid rgba(255,255,255,.2)!important;
    color:#fff!important;
    border-radius:8px;
}

.form-control::placeholder{
    color:rgba(255,255,255,.35)!important;
}

.form-control:focus{
    border-color:rgba(100,180,255,.7)!important;
    box-shadow:0 0 0 .2rem rgba(100,180,255,.15)!important;
}

.divider-line{
    border-color:rgba(255,255,255,.15);
}

.divider-text{
    color:rgba(255,255,255,.4);
    font-size:12px;
}

.btn-daftar{
    color:rgba(255,255,255,.8);
    border-color:rgba(255,255,255,.2);
}

.btn-daftar:hover{
    background:rgba(255,255,255,.08);
    color:#fff;
    border-color:rgba(255,255,255,.4);
}

.alert-danger{
    background:rgba(220,53,69,.15);
    border:1px solid rgba(220,53,69,.3);
    color:#fff;
}
</style>

<div class="page">
    <div class="glass-card">

        <div class="card-header-custom">
            <h1>Login Perpustakaan</h1>
            <p>Masukkan akun Anda untuk melanjutkan</p>
        </div>

        <div class="p-4">

            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success py-2">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username</label>
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
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <div class="text-end mb-3">
                    <a href="#"
                       class="text-decoration-none"
                       style="font-size:12px;color:rgba(100,180,255,.85);">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Masuk
                </button>
            </form>

            <div class="d-flex align-items-center my-3">
                <hr class="divider-line flex-grow-1">
                <span class="divider-text px-2">atau</span>
                <hr class="divider-line flex-grow-1">
            </div>

            <a href="{{ route('register') }}"
               class="btn btn-outline-secondary w-100 btn-daftar">
                Daftar Anggota
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