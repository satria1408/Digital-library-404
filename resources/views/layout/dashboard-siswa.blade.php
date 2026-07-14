<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Layanan Terpadu Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Konfigurasi Dasar Aplikasi */
        :root {
            --app-surface-bg: #f8fafc;
            --app-text-main: #212529;
            --navigation-bar-bg: #0d6efd;
            --navigation-text: #ffffff;
            --navigation-dimmed: rgba(255, 255, 255, 0.70);
            --navigation-divider: rgba(255, 255, 255, 0.12);
            --drawer-bg: #1e293b; /* Slate Dark premium */
            --drawer-text: #f8fafc;
        }

        body.dark-mode {
            --app-surface-bg: #121212;
            --app-text-main: #f3f4f6;
            --drawer-bg: #0f172a; 
            --drawer-text: #f3f4f6;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: var(--app-surface-bg) !important;
            color: var(--app-text-main) !important;
            transition: background-color 0.25s ease, color 0.25s ease;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .base-layout-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--app-surface-bg) !important;
        }

        .dynamic-view-viewport {
            flex: 1;
        }

        .custom-app-nav {
            margin: 0 !important;
            border-radius: 0 !important;
            border-bottom: 1px solid var(--navigation-divider);
            transition: background-color 0.3s ease;
        }

        /* Variasi warna tema bar atas saat menu diakses */
        .bg-theme-dashboard { background-color: #0d6efd !important; }
        .bg-theme-peminjaman { background-color: #198754 !important; }
        .bg-theme-pengembalian { background-color: #f59e0b !important; }
        .bg-theme-stats { background-color: #0dcaf0 !important; }

        body.dark-mode .custom-app-nav {
            background-color: #1f2937 !important;
        }

        .brand-ident, .nav-info-text, #liveClockDisplay {
            color: var(--navigation-text) !important;
        }

        /* FIX DARK MODE UNTUK TULISAN DASHBOARD ANAK */
        body.dark-mode .text-dark,
        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6,
        body.dark-mode .card h4,
        body.dark-mode .card h5 {
            color: #ffffff !important;
        }

        body.dark-mode .text-muted {
            color: #9ca3af !important;
        }

        body.dark-mode .card {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25) !important;
        }

        body.dark-mode .bg-white {
            background-color: #1f2937 !important;
        }

        /* ==========================================================================
           STYLE PREMIUM NAVIGASI MENU (SIDEBAR DRAWER)
           ========================================================================== */
        .custom-drawer {
            background-color: var(--drawer-bg) !important;
            color: var(--drawer-text) !important;
            backdrop-filter: blur(10px);
        }

        .drawer-profile-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .drawer-profile-card:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .menu-section-label {
            font-size: 0.68rem;
            font-weight: 800;
            text-uppercase: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.35);
            padding-left: 12px;
            margin-bottom: 8px;
            display: block;
        }

        .custom-drawer .nav-link {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 0.92rem;
            font-weight: 500;
            border-radius: 10px;
            padding: 10px 14px !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .custom-drawer .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.05) !important;
            transform: translateX(4px);
        }

        .custom-drawer .nav-link.active {
            color: #ffffff !important;
            background: linear-gradient(135deg, #0d6efd, #0a58ca) !important;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
        }

        /* Style Khusus Tombol Pemicu Dropdown Accordion */
        .drawer-dropdown-trigger {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 0.92rem;
            font-weight: 500;
            border-radius: 10px;
            padding: 10px 14px !important;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        
        .drawer-dropdown-trigger:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.05);
        }

        .drawer-dropdown-trigger.open-active {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.08);
            font-weight: 600;
        }

        /* Sub-menu box di dalam laci */
        .drawer-submenu-box {
            padding-left: 14px;
            margin-left: 14px;
            border-left: 1px solid rgba(255, 255, 255, 0.15);
            margin-top: 4px;
            margin-bottom: 8px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .drawer-submenu-box .nav-link {
            font-size: 0.86rem;
            padding: 8px 12px !important;
        }

        /* Variasi warna sub-menu saat aktif */
        .drawer-submenu-box .nav-link.active-peminjaman {
            background: linear-gradient(135deg, #198754, #146c43) !important;
            box-shadow: 0 4px 10px rgba(25, 135, 84, 0.25);
            color: #ffffff !important;
        }
        .drawer-submenu-box .nav-link.active-pengembalian {
            background: linear-gradient(135deg, #f59e0b, #d97706) !important;
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.25);
            color: #ffffff !important;
        }
        .drawer-submenu-box .nav-link.active-stats {
            background: linear-gradient(135deg, #0dcaf0, #0bacce) !important;
            box-shadow: 0 4px 10px rgba(13, 202, 240, 0.25);
            color: #212529 !important;
        }
        .drawer-submenu-box .nav-link.active-pengaduan {
            background: linear-gradient(135deg, #ffc107, #e0a800) !important;
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.25);
            color: #212529 !important;
        }

        /* ==========================================================================
           KOMPONEN BERSAMA: dipakai lintas halaman (form pengaduan, riwayat, dll)
           Tujuannya supaya tiap halaman blade tidak perlu nulis <style> sendiri lagi.
           ========================================================================== */
        :root {
            --school-blue: #1d4ed8;
            --school-blue-dark: #1e3a8a;
            --school-border: #d1d5db;
            --school-text-muted: #4b5563;
        }

        .page-title { color: #111827; }
        .required-mark { color: #b91c1c; }

        .form-card {
            background: #ffffff;
            border: 1px solid var(--school-border);
            border-radius: 10px;
            padding: 1.5rem;
        }
        @media (min-width: 768px) { .form-card { padding: 2rem; } }

        .form-label-clean { font-size: 0.9rem; font-weight: 600; color: #1f2937; }
        .helper-text { font-size: 0.8rem; color: var(--school-text-muted); }

        .form-control-clean {
            border: 1px solid var(--school-border);
            border-radius: 8px;
            font-size: 1rem;
            padding: 0.65rem 0.9rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .form-control-clean:focus {
            border-color: var(--school-blue);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.18);
            outline: none;
        }
        .form-control-clean.is-invalid { border-color: #b91c1c; }

        .char-counter { font-size: 0.8rem; color: var(--school-text-muted); transition: color 0.15s ease; }

        .btn-back {
            border: 1px solid var(--school-border);
            border-radius: 8px;
            font-weight: 600;
            color: #1f2937;
            transition: background-color 0.15s ease;
        }
        .btn-back:hover, .btn-back:focus { background-color: #f3f4f6; }

        .btn-submit, .btn-new-report {
            background-color: var(--school-blue);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: #fff;
            transition: background-color 0.15s ease, transform 0.1s ease;
        }
        .btn-submit:hover:not(:disabled), .btn-new-report:hover { background-color: var(--school-blue-dark); color: #fff; }
        .btn-submit:active:not(:disabled), .btn-new-report:active { transform: scale(0.98); }
        .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; }

        .btn-back:focus-visible, .btn-submit:focus-visible, .btn-new-report:focus-visible {
            outline: 3px solid rgba(29, 78, 216, 0.4);
            outline-offset: 2px;
        }

        .list-card { background: #ffffff; border: 1px solid var(--school-border); border-radius: 10px; overflow: hidden; }
        .ticket-code { font-family: monospace; background: #f3f4f6; border: 1px solid var(--school-border); color: #374151; border-radius: 6px; padding: 0.25rem 0.5rem; }

        .status-pill { font-size: 0.75rem; font-weight: 700; border-radius: 999px; padding: 0.35rem 0.75rem; display: inline-flex; align-items: center; }
        .status-diterima { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .status-diproses { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
        .status-selesai { background: #dcfce7; color: #166534; border: 1px solid #86efac; }

        .btn-detail {
            border: 1px solid var(--school-blue);
            color: var(--school-blue);
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: background-color 0.15s ease, color 0.15s ease;
        }
        .btn-detail:hover { background-color: var(--school-blue); color: #fff; }

        @media (max-width: 575.98px) {
            .btn-submit, .btn-back, .btn-new-report { width: 100%; }
        }

        /* Opt-in: tambahkan class "table-stack" di <table> untuk mode kartu di HP */
        @media (max-width: 767.98px) {
            .table-stack thead { display: none; }
            .table-stack, .table-stack tbody, .table-stack tr, .table-stack td { display: block; width: 100%; }
            .table-stack tr { border: 1px solid var(--school-border); border-radius: 10px; margin: 0.75rem; padding: 0.75rem 1rem; }
            .table-stack td { border: none !important; padding: 0.35rem 0 !important; text-align: left !important; }
            .table-stack td::before {
                content: attr(data-label);
                display: block;
                font-size: 0.72rem;
                font-weight: 700;
                color: var(--school-text-muted);
                text-transform: uppercase;
                letter-spacing: 0.03em;
                margin-bottom: 0.15rem;
            }
        }

        /* Penyesuaian dark mode untuk komponen bersama di atas */
        body.dark-mode .form-card,
        body.dark-mode .list-card {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
        }
        body.dark-mode .form-control-clean {
            background-color: #111827 !important;
            border-color: #374151 !important;
            color: #f3f4f6 !important;
        }
        body.dark-mode .ticket-code {
            background-color: #111827 !important;
            border-color: #374151 !important;
            color: #d1d5db !important;
        }
        body.dark-mode .helper-text,
        body.dark-mode .char-counter {
            color: #9ca3af !important;
        }
    </style>
</head>
<body>
    <div class="base-layout-container">
        @auth
        <nav class="navbar navbar-expand-lg custom-app-nav navbar-dark shadow-sm
            {{ request()->routeIs('siswa.dashboard') ? 'bg-theme-dashboard' : '' }}
            {{ request()->routeIs('siswa.peminjaman') ? 'bg-theme-peminjaman' : '' }}
            {{ request()->routeIs('siswa.pengembalian') ? 'bg-theme-pengembalian' : '' }}
            {{ request()->routeIs('siswa.stats') ? 'bg-theme-stats' : '' }}
        ">
            <div class="container">
                <button class="btn btn-link text-white p-0 border-0 me-3 d-lg-none shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#appMobileDrawer">
                    <i class="bi bi-text-left fs-2"></i>
                </button>

                <a class="brand-ident navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('siswa.dashboard') }}">
                    <i class="bi bi-grid-1x2-fill fs-5"></i> Oneschool
                    
                </a>

                <div class="collapse navbar-collapse" id="desktopNavRegistry">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" href="{{ route('siswa.dashboard') }}">Panel Utama</a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex align-items-center gap-3 ms-auto">
                    <button id="themeSwitcherToggle" class="btn btn-link p-0 border-0 text-white shadow-none" onclick="switchAppTheme()" title="Ganti Mode Visual">
                        <i id="themeToggleStateIcon" class="bi bi-moon-stars-fill fs-5"></i>
                    </button>

                    <span id="liveClockDisplay" class="d-none d-sm-inline small fw-medium text-opacity-75">00/00/0000 | 00:00:00</span>

                    <span class="nav-info-text d-none d-md-inline small">
                        <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->nama_lengkap ?? auth()->user()->username }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm px-2 py-1 border-0" title="Keluar Sistem">
                            <i class="bi bi-power fs-6"></i>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start custom-drawer border-0 shadow-lg" tabindex="-1" id="appMobileDrawer" style="width: 280px;"
             x-data="{ 
                perpusOpen: {{ (request()->routeIs('siswa.peminjaman') || request()->routeIs('wishlist.*') || request()->routeIs('siswa.pengembalian') || request()->routeIs('siswa.stats')) ? 'true' : 'false' }}, 
                pengaduanOpen: {{ request()->routeIs('siswa.complaints.*') ? 'true' : 'false' }} 
             }">
            <div class="offcanvas-header border-bottom border-secondary border-opacity-10 py-3.5 px-4">
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center gap-2.5" style="font-size: 1.1rem; letter-spacing: -0.02em;">
                    <i class="bi bi-shield-lock-fill text-primary"></i> Portal Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" style="font-size: 0.8rem;"></button>
            </div>

            <div class="offcanvas-body px-3 py-4">

                <div class="drawer-profile-card p-3 d-flex align-items-center gap-3 mb-4">
                    <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-extrabold shadow-sm" style="width: 46px; height: 46px; min-width: 46px; font-size: 1.2rem; background: linear-gradient(135deg, #0d6efd, #0b5ed7) !important;">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->username ?? 'S', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <span class="fw-bold d-block text-truncate text-white" style="font-size: 0.9rem;" title="{{ auth()->user()->nama_lengkap ?? auth()->user()->username }}">
                            {{ auth()->user()->nama_lengkap ?? auth()->user()->username ?? 'Nama Pengguna' }}
                        </span>
                        <div class="d-flex align-items-center gap-1.5 mt-0.5">
                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0.5" style="font-size: 0.6rem; font-weight: 700; letter-spacing: 0.02em;">ONLINE</span>
                            <span class="text-white-50 small text-uppercase" style="font-size: 0.65rem; font-weight: 600;">&bull; {{ auth()->user()->role ?? 'Siswa' }}</span>
                        </div>
                    </div>
                </div>

                <div class="menu-navigation-wrapper">
                    <span class="menu-section-label">Menu Utama</span>
                    <ul class="nav nav-pills flex-column gap-1.5 mb-4">
                        <li class="nav-item">
                            <a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-grid-1x2-fill fs-5"></i> Dashboard
                            </a>
                        </li>
                    </ul>

                    <span class="menu-section-label">Modul Layanan</span>
                    <div class="d-flex flex-column gap-2">
                        
                        <div>
                            <button @click="perpusOpen = !perpusOpen; if(perpusOpen) pengaduanOpen = false" 
                                    class="drawer-dropdown-trigger" 
                                    :class="perpusOpen ? 'open-active' : ''">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-book-half fs-5 text-primary"></i>
                                    <span>Perpustakaan Digital</span>
                                </div>
                                <i class="bi small" :class="perpusOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                            </button>

                            <div x-show="perpusOpen" x-collapse class="drawer-submenu-box">
                                <a href="{{ route('siswa.peminjaman') }}" class="nav-link {{ request()->routeIs('siswa.peminjaman') ? 'active active-peminjaman' : '' }}">
                                    <i class="bi bi-journal-plus fs-6"></i> Peminjaman Buku
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="nav-link {{ request()->routeIs('wishlist.*') ? 'active' : '' }}">
                                    <i class="bi bi-heart-fill fs-6"></i> Wishlist Buku
                                </a>
                                <a href="{{ route('siswa.pengembalian') }}" class="nav-link {{ request()->routeIs('siswa.pengembalian') ? 'active active-pengembalian' : '' }}">
                                    <i class="bi bi-journal-check fs-6"></i> Pengembalian Buku
                                </a>
                                <a href="{{ route('siswa.stats') }}" class="nav-link {{ request()->routeIs('siswa.stats') ? 'active active-stats' : '' }}">
                                    <i class="bi bi-bar-chart-line-fill fs-6"></i> Statistik &amp; Riwayat
                                </a>
                            </div>
                        </div>

                        <div>
                            <button @click="pengaduanOpen = !pengaduanOpen; if(pengaduanOpen) perpusOpen = false" 
                                    class="drawer-dropdown-trigger" 
                                    :class="pengaduanOpen ? 'open-active' : ''">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-chat-left-text-fill fs-5 text-warning"></i>
                                    <span>Pengaduan & Sarana</span>
                                </div>
                                <i class="bi small" :class="pengaduanOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                            </button>

                            <div x-show="pengaduanOpen" x-collapse class="drawer-submenu-box">
                                <a href="{{ route('siswa.complaints.create') }}" class="nav-link {{ request()->routeIs('siswa.complaints.create') ? 'active active-pengaduan' : '' }}">
                                    <i class="bi bi-pencil-square fs-6"></i> Buat Laporan Baru
                                </a>
                                <a href="{{ route('siswa.complaints.index') }}" class="nav-link {{ request()->routeIs('siswa.complaints.index') ? 'active active-pengaduan' : '' }}">
                                    <i class="bi bi-clock-history fs-6"></i> Riwayat Pengaduan
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endauth

        <div class="dynamic-view-viewport">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        function renderLiveDateTime() {
            const currentDateInstance = new Date();
            const containerElement = document.getElementById('liveClockDisplay');
            if(containerElement){
                containerElement.innerHTML = currentDateInstance.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'}) + ' | ' + currentDateInstance.toLocaleTimeString('id-ID');
            }
        }
        setInterval(renderLiveDateTime, 1000);
        renderLiveDateTime();

        function switchAppTheme() {
            document.body.classList.toggle('dark-mode');
            const contextualIcon = document.getElementById('themeToggleStateIcon');
            if (document.body.classList.contains('dark-mode')) {
                if(contextualIcon) contextualIcon.className = 'bi bi-sun-fill fs-5 text-warning';
            } else {
                if(contextualIcon) contextualIcon.className = 'bi bi-moon-stars-fill fs-5 text-white';
            }
        }
    </script>
</body>
</html>