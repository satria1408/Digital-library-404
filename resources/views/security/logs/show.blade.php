@extends('layout.app')

@section('content')

<style>
.security-bg {
    min-height: calc(100vh - 56px);
    padding: 30px;
    background: linear-gradient(
        135deg,
        #0f172a 0%,
        #1e3a8a 50%,
        #2563eb 100%
    );
    transition: .3s;
}

.security-title {
    color: #fff;
    font-weight: 700;
    margin: 0;
    font-size: 24px;
}

.security-title span {
    font-size: 14px;
    font-weight: 400;
    opacity: .65;
    display: block;
    margin-top: 4px;
}

.glass-card {
    border: none;
    border-radius: 16px;
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,.12);
    color: #fff;
    transition: .3s;
}

.glass-card .card-header {
    background: rgba(255,255,255,.1);
    border-bottom: 1px solid rgba(255,255,255,.15);
    font-weight: 600;
    font-size: 14px;
    letter-spacing: .4px;
    border-radius: 16px 16px 0 0 !important;
    padding: 14px 20px;
}

.detail-row {
    display: flex;
    padding: 14px 0;
    border-bottom: 1px solid rgba(255,255,255,.08);
    gap: 16px;
    align-items: flex-start;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    min-width: 160px;
    font-size: 12px;
    opacity: .55;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding-top: 3px;
}

.detail-value {
    flex: 1;
    font-size: 14px;
    word-break: break-all;
    line-height: 1.6;
}

.payload-box {
    background: rgba(239,68,68,.12);
    border: 1px solid rgba(239,68,68,.3);
    border-radius: 10px;
    padding: 14px 16px;
    font-family: monospace;
    font-size: 13px;
    color: #fca5a5;
    word-break: break-all;
    white-space: pre-wrap;
    line-height: 1.6;
}

.url-box {
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 10px;
    padding: 10px 14px;
    font-family: monospace;
    font-size: 13px;
    color: #93c5fd;
    word-break: break-all;
    line-height: 1.5;
}

.badge-attack {
    background: rgba(239,68,68,.2);
    color: #fca5a5;
    border: 1px solid rgba(239,68,68,.35);
    border-radius: 6px;
    padding: 4px 12px;
    font-size: 13px;
    font-weight: 500;
}

.btn-back {
    border-radius: 10px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    color: #fff;
    font-size: 14px;
}

.btn-back:hover {
    background: rgba(255,255,255,.2);
    color: #fff;
}

/* LIGHT MODE */
body.light-mode .security-bg {
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 50%, #94a3b8 100%);
}

body.light-mode .security-title { color: #0f172a; }
body.light-mode .security-title span { color: #64748b; }

body.light-mode .glass-card {
    background: rgba(255,255,255,.88);
    color: #0f172a;
}

body.light-mode .glass-card .card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    color: #0f172a;
}

body.light-mode .detail-row { border-bottom-color: #f1f5f9; }

body.light-mode .detail-label { color: #64748b; }

body.light-mode .payload-box {
    background: rgba(239,68,68,.06);
    border-color: rgba(239,68,68,.2);
    color: #dc2626;
}

body.light-mode .url-box {
    background: #f1f5f9;
    border-color: #e2e8f0;
    color: #1e40af;
}

body.light-mode .badge-attack {
    background: rgba(239,68,68,.08);
    color: #dc2626;
    border-color: rgba(239,68,68,.25);
}

body.light-mode .btn-back {
    background: #fff;
    border-color: #cbd5e1;
    color: #1e3a8a;
}

body.light-mode .btn-back:hover {
    background: #f1f5f9;
    color: #1e3a8a;
}
</style>

<div class="security-bg">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h1 class="security-title">
            Detail Security Log
            <span>ID #{{ $securityLog->id }} &mdash; {{ $securityLog->created_at->format('d M Y, H:i:s') }}</span>
        </h1>

        <a href="{{ route('security.logs.index') }}" class="btn btn-back">
            &larr; Kembali
        </a>
    </div>

    <div class="row g-4">

        {{-- Info Serangan --}}
        <div class="col-lg-7">
            <div class="card glass-card h-100">
                <div class="card-header">Informasi Serangan</div>
                <div class="card-body px-4">

                    <div class="detail-row">
                        <div class="detail-label">Jenis Serangan</div>
                        <div class="detail-value">
                            <span class="badge-attack">{{ $securityLog->attack_type }}</span>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Waktu Deteksi</div>
                        <div class="detail-value">
                            {{ $securityLog->created_at->format('d M Y, H:i:s') }}
                            <small style="opacity:.5; display:block; font-size:12px; margin-top:2px;">
                                {{ $securityLog->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">HTTP Method</div>
                        <div class="detail-value">
                            <span class="badge bg-secondary" style="font-size:13px; border-radius:6px;">
                                {{ $securityLog->method }}
                            </span>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">URL Target</div>
                        <div class="detail-value">
                            <div class="url-box">{{ $securityLog->url }}</div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Payload</div>
                        <div class="detail-value">
                            <div class="payload-box">{{ $securityLog->payload }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Info Penyerang --}}
        <div class="col-lg-5">
            <div class="card glass-card mb-4">
                <div class="card-header">Informasi Penyerang</div>
                <div class="card-body px-4">

                    <div class="detail-row">
                        <div class="detail-label">IP Address</div>
                        <div class="detail-value">
                            <code style="color:#93c5fd; background:rgba(147,197,253,.1); padding:4px 10px; border-radius:6px; font-size:14px;">
                                {{ $securityLog->ip_address }}
                            </code>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">User Login</div>
                        <div class="detail-value">
                            @if($securityLog->user)
                                <div style="font-weight:600;">{{ $securityLog->user->nama_lengkap }}</div>
                                <div style="font-size:12px; opacity:.5; margin-top:2px;">
                                    {{ $securityLog->user->email }} &mdash; {{ ucfirst($securityLog->user->role) }}
                                </div>
                            @else
                                <span style="opacity:.4; font-size:13px;">Tidak login / Tamu</span>
                            @endif
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">User Agent</div>
                        <div class="detail-value" style="font-size:12px; opacity:.7; line-height:1.6;">
                            {{ $securityLog->user_agent ?? '-' }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- Aksi --}}
            <div class="card glass-card">
                <div class="card-header">Aksi</div>
                <div class="card-body px-4">
                    <p style="font-size:13px; opacity:.55; margin-bottom:14px; line-height:1.5;">
                        Hapus log ini jika sudah tidak diperlukan untuk keperluan audit.
                    </p>

                    <form action="{{ route('security.logs.destroy', $securityLog->id) }}"
                          method="POST"
                          onsubmit="return confirmHapus()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" style="border-radius:10px; font-size:14px;">
                            Hapus Log Ini
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    function confirmHapus() {
        return confirm('Yakin ingin menghapus log ini?');
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (localStorage.getItem('theme') === 'light') {
            document.body.classList.add('light-mode');
        }
    });
</script>
@endpush

@endsection