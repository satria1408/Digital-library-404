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

    /* BACKGROUND TEMA PERPUSTAKAAN CERAH */
    background-image:url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=3000&q=100');
    background-size:cover;
    background-position:center center;
    background-repeat:no-repeat;
}

.page::before{
    content:'';
    position:absolute;
    inset:0;
    background:rgba(255,255,255,.25);
}

.glass-card{
    position:relative;
    z-index:1;
    width:100%;
    max-width:360px;
    background:rgba(255,255,255,.45);
    border:1px solid rgba(255,255,255,.4);
    border-radius:14px;
    backdrop-filter:blur(16px);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
    overflow:hidden;
}

.card-header-custom{
    padding:28px 32px 24px;
    text-align:center;
    border-bottom:1px solid rgba(0,0,0,.08);
}

.card-header-custom h1{
    color:#1e293b;
    font-size:20px;
    font-weight: 700;
    margin-bottom:5px;
}

.card-header-custom p{
    color:#475569;
    font-size:13px;
    margin:0;
}

.form-label{
    color:#334155;
    font-size:12px;
    font-weight: 600;
    text-transform:uppercase;
    letter-spacing:.05em;
}

.form-control{
    background:rgba(255,255,255,.6)!important;
    border:1px solid rgba(0,0,0,.15)!important;
    color:#0f172a!important;
    border-radius:8px;
}

.form-control::placeholder{
    color:#94a3b8!important;
}

.form-control:focus{
    border-color:#2563eb!important;
    box-shadow:0 0 0 .2rem rgba(37,99,235,.15)!important;
}

.divider-line{
    border-color:rgba(0,0,0,.15);
}

.divider-text{
    color:#475569;
    font-size:12px;
}

.btn-daftar{
    color:#2563eb;
    border-color:rgba(37,99,235,.4);
    font-weight: 500;
}

.btn-daftar:hover{
    background:rgba(37,99,235,.08);
    color:#1d4ed8;
    border-color:#2563eb;
}

.alert-danger{
    background:rgba(220,53,69,.15);
    border:1px solid rgba(220,53,69,.3);
    color:#b91c1c;
    font-weight: 500;
}

/* Floating Action Button (FAB) */
.fab-container {
    position: fixed;
    bottom: 25px;
    right: 25px;
    z-index: 1050;
}

.btn-fab {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(10px);
    color: #1e293b;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.btn-fab:hover {
    background: rgba(37, 99, 235, 0.2);
    border-color: #2563eb;
    color: #1e293b;
    transform: scale(1.08);
}

/* Glassmorphism khusus untuk isi Modal Bootstrap */
.modal-glass {
    background: rgba(255, 255, 255, 0.9) !important;
    backdrop-filter: blur(20px);
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #1e293b;
}

.modal-glass .modal-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.modal-glass .modal-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.08);
}

.modal-glass .btn-close {
    filter: none;
}
</style>

<div class="page">
    <div class="glass-card">

        <div class="card-header-custom">
            <h1>Portal Perpustakaan</h1>
            
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
                    <label class="form-label">NISN / Username</label>
                    <input
                        type="text"
                        name="login_input"
                        class="form-control"
                        placeholder="Username atau 10 digit NISN"
                        value="{{ old('login_input') }}"
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
                       style="font-size:12px;color:#2563eb;font-weight:500;">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">
                    Masuk Aplikasi
                </button>
            </form>

            <div class="d-flex align-items-center my-3">
                <hr class="divider-line flex-grow-1">
                <span class="divider-text px-2">atau</span>
                <hr class="divider-line flex-grow-1">
            </div>

            <a href="{{ route('register') }}"
               class="btn btn-outline-secondary w-100 btn-daftar">
                Daftar Anggota (Siswa)
            </a>

        </div>

    </div>
</div>

<div class="fab-container">
    <button type="button" class="btn btn-fab" data-bs-toggle="modal" data-bs-target="#suggestionHubModal" title="Kotak Saran & Keluhan">
        <i class="bi bi-chat-left-text-fill"></i>
    </button>
</div>

<div class="modal fade" id="suggestionHubModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-glass">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-laptop"></i> Layanan Pengaduan Sistem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="text-secondary small mb-4">Punya kendala eror di aplikasi perpustakaan atau saran untuk developer? Silakan pilih menu di bawah ini.</p>
                <div class="row g-3">
                    <div class="col-6">
                        <button class="btn btn-outline-primary w-100 py-3 fw-bold" data-bs-target="#createSuggestionModal" data-bs-toggle="modal">
                            <i class="bi bi-pencil-square d-block fs-3 mb-2"></i> Kirim Masukan
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-outline-success w-100 py-3 fw-bold" data-bs-target="#checkTicketModal" data-bs-toggle="modal">
                            <i class="bi bi-ticket-perforated d-block fs-3 mb-2"></i> Cek Status Tiket
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createSuggestionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-glass">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square"></i> Tulis Keluhan / Saran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formKirimSaran" action="{{ route('saran.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="alertSaran" class="alert d-none py-2" style="font-size:13px;"></div>
                    
                    <div class="mb-3">
                        <label class="form-label text-dark">Subjek Masukan</label>
                        <input type="text" name="subjek" class="form-control" style="color:#000!important;" placeholder="Contoh: Eror saat klik pinjam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark">Detail Keluhan / Saran</label>
                        <textarea name="isi_saran" class="form-control" style="color:#000!important;" rows="4" placeholder="Tulis rincian kendala yang lo alami secara detail..." required></textarea>
                    </div>
                    <span class="text-secondary d-block" style="font-size:11px;">
                        *Pesan ini dikirim anonim jika lo belum masuk ke akun.
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-target="#suggestionHubModal" data-bs-toggle="modal">Kembali</button>
                    <button type="submit" id="btnSubmitSaran" class="btn btn-sm btn-primary px-3">Kirim Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="checkTicketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-glass">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-search"></i> Lacak Status Balasan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCekTiket" action="{{ route('saran.check') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="ticket_code" id="ticket_code_input" class="form-control" style="color:#000!important;" placeholder="Masukkan Kode Tiket (Contoh: DEV-XXXXXX)" required>
                        <button class="btn btn-success" type="submit" id="btnCekTiket"><i class="bi bi-search"></i> Cek</button>
                    </div>
                </form>

                <div id="hasilCekTiket" class="d-none mt-3 p-3 rounded" style="background: rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.08);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0 text-primary" id="resSubjek"></h6>
                        <span class="badge" id="resStatus"></span>
                    </div>
                    <p class="small text-secondary mb-1" style="font-size:11px;" id="resTanggal"></p>
                    <div class="p-2 mb-3 rounded text-dark small" style="background:rgba(0,0,0,0.05RAM);" id="resIsi"></div>
                    
                    <div class="p-2 rounded small border border-primary" style="background:rgba(37,99,235,0.05);">
                        <label class="fw-bold text-primary mb-1 d-block"><i class="bi bi-reply-fill"></i> Respon Developer:</label>
                        <p class="mb-0 text-dark" id="resBalasan" style="white-space: pre-line;"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-target="#suggestionHubModal" data-bs-toggle="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>

<script>
  document.querySelector('form').addEventListener('submit', function () {
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
  });

  document.getElementById('formKirimSaran').addEventListener('submit', function(e) {
      e.preventDefault();
      const btn = document.getElementById('btnSubmitSaran');
      const alertBox = document.getElementById('alertSaran');
      
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

      fetch(this.action, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': this.querySelector('input[name="_token"]').value
          },
          body: JSON.stringify({
              subjek: this.querySelector('input[name="subjek"]').value,
              isi_saran: this.querySelector('textarea[name="isi_saran"]').value,
          })
      })
      .then(res => res.json())
      .then(data => {
          alertBox.classList.remove('d-none', 'alert-danger', 'alert-success');
          if(data.success) {
              alertBox.classList.add('alert-success');
              alertBox.innerHTML = `<strong>Sukses!</strong> ${data.message}<br><br>Gunakan kode tiket ini untuk melacak balasan:<br><strong class="fs-5 text-success font-monospace d-block text-center mt-1">${data.ticket_code}</strong><br><small>*Salin kode ini sekarang.</small>`;
              this.reset();
          } else {
              alertBox.classList.add('alert-danger');
              alertBox.innerText = data.message;
          }
      })
      .catch(() => {
          alertBox.classList.remove('d-none', 'alert-success');
          alertBox.classList.add('alert-danger');
          alertBox.innerText = 'Terjadi kesalahan sistem, coba lagi nanti.';
      })
      .finally(() => {
          btn.disabled = false;
          btn.innerText = 'Kirim Sekarang';
      });
  });

  document.getElementById('formCekTiket').addEventListener('submit', function(e) {
      e.preventDefault();
      const btn = document.getElementById('btnCekTiket');
      const hasilBox = document.getElementById('hasilCekTiket');
      
      btn.disabled = true;
      btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
      hasilBox.classList.add('d-none');

      fetch(this.action, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': this.querySelector('input[name="_token"]').value
          },
          body: JSON.stringify({
              ticket_code: document.getElementById('ticket_code_input').value
          })
      })
      .then(res => {
          if (!res.ok) throw res;
          return res.json();
      })
      .then(res => {
          if(res.success) {
              document.getElementById('resSubjek').innerText = res.data.subjek;
              document.getElementById('resTanggal').innerHTML = `<i class="bi bi-clock"></i> Dikirim: ${res.data.tanggal_kirim}`;
              document.getElementById('resIsi').innerText = res.data.isi_saran;
              document.getElementById('resBalasan').innerText = res.data.reply_developer;

              const badge = document.getElementById('resStatus');
              badge.className = 'badge';
              if(res.data.status === 'unread') {
                  badge.classList.add('bg-danger');
                  badge.innerText = 'Unread';
              } else if(res.data.status === 'read') {
                  badge.classList.add('bg-warning', 'text-dark');
                  badge.innerText = 'Read';
              } else {
                  badge.classList.add('bg-success');
                  badge.innerText = 'Replied';
              }

              hasilBox.classList.remove('d-none');
          }
      })
      .catch(async (err) => {
          let msg = 'Kode tiket tidak ditemukan atau salah ketik.';
          if(err.json) {
              const errData = await err.json();
              msg = errData.message;
          }
          alert(msg);
      })
      .finally(() => {
          btn.disabled = false;
          btn.innerHTML = '<i class="bi bi-search"></i> Cek';
      });
  });
</script>
@endsection