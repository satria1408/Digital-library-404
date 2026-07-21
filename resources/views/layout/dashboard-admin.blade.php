<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Admin Terpadu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Konfigurasi Dasar Aplikasi */
        :root {
            --app-surface-bg: #f8fafc;
            --app-text-main: #212529;
            --navigation-bar-bg: #6f42c1;
            --navigation-text: #ffffff;
            --navigation-dimmed: rgba(255, 255, 255, 0.70);
            --navigation-divider: rgba(255, 255, 255, 0.12);
            --drawer-bg: #1e1b2e; /* Ungu gelap premium, beda sama siswa (slate) */
            --drawer-text: #f8fafc;
        }

        body.dark-mode {
            --app-surface-bg: #121212;
            --app-text-main: #f3f4f6;
            --drawer-bg: #0f0c1a;
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
        .bg-theme-dashboard { background-color: #6f42c1 !important; }
        .bg-theme-digitallibrary { background-color: #0d6efd !important; }
        .bg-theme-saranapengaduan { background-color: #f59e0b !important; }
        .bg-theme-security { background-color: #dc3545 !important; }

        body.dark-mode .custom-app-nav {
            background-color: #1f2937 !important;
        }

        .brand-ident, .nav-info-text, #liveClockDisplay {
            color: var(--navigation-text) !important;
        }

        /* FIX DARK MODE UNTUK TULISAN DASHBOARD ADMIN */
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
            background: linear-gradient(135deg, #6f42c1, #59359b) !important;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(111, 66, 193, 0.25);
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
        .drawer-submenu-box .nav-link.active-books {
            background: linear-gradient(135deg, #0d6efd, #0a58ca) !important;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.25);
            color: #ffffff !important;
        }
        .drawer-submenu-box .nav-link.active-users {
            background: linear-gradient(135deg, #198754, #146c43) !important;
            box-shadow: 0 4px 10px rgba(25, 135, 84, 0.25);
            color: #ffffff !important;
        }
        .drawer-submenu-box .nav-link.active-transactions {
            background: linear-gradient(135deg, #0dcaf0, #0bacce) !important;
            box-shadow: 0 4px 10px rgba(13, 202, 240, 0.25);
            color: #212529 !important;
        }
        .drawer-submenu-box .nav-link.active-dendas {
            background: linear-gradient(135deg, #dc3545, #b02a37) !important;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.25);
            color: #ffffff !important;
        }
        .drawer-submenu-box .nav-link.active-pengaduan {
            background: linear-gradient(135deg, #ffc107, #e0a800) !important;
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.25);
            color: #212529 !important;
        }
        .drawer-submenu-box .nav-link.active-security {
            background: linear-gradient(135deg, #dc3545, #b02a37) !important;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.25);
            color: #ffffff !important;
        }

        @media (max-width: 575.98px) {
            .btn-submit, .btn-back, .btn-new-report { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="base-layout-container">
        @auth
        <nav class="navbar navbar-expand-lg custom-app-nav navbar-dark shadow-sm
            {{ request()->routeIs('admin.dashboard') ? 'bg-theme-dashboard' : '' }}
            {{ request()->routeIs('digitallibrary.admin.*') ? 'bg-theme-digitallibrary' : '' }}
            {{ request()->routeIs('saranapengaduan.admin.*') ? 'bg-theme-saranapengaduan' : '' }}
            {{ request()->routeIs('security.logs.*') ? 'bg-theme-security' : '' }}
        ">
            <div class="container">
                <button class="btn btn-link text-white p-0 border-0 me-3 d-lg-none shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#appMobileDrawer">
                    <i class="bi bi-text-left fs-2"></i>
                </button>

                <a class="brand-ident navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-shield-lock-fill fs-5"></i> Oneschool Admin
                </a>

                <div class="collapse navbar-collapse" id="desktopNavRegistry">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Panel Utama</a>
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
                digilibOpen: {{ request()->routeIs('digitallibrary.admin.*') ? 'true' : 'false' }},
                pengaduanOpen: {{ request()->routeIs('saranapengaduan.admin.*') ? 'true' : 'false' }}
             }">
            <div class="offcanvas-header border-bottom border-secondary border-opacity-10 py-3.5 px-4">
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center gap-2.5" style="font-size: 1.1rem; letter-spacing: -0.02em;">
                    <i class="bi bi-shield-lock-fill text-primary"></i> Portal Admin
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" style="font-size: 0.8rem;"></button>
            </div>

            <div class="offcanvas-body px-3 py-4">

                <div class="drawer-profile-card p-3 d-flex align-items-center gap-3 mb-4">
                    <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-extrabold shadow-sm" style="width: 46px; height: 46px; min-width: 46px; font-size: 1.2rem; background: linear-gradient(135deg, #6f42c1, #59359b) !important;">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->username ?? 'A', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <span class="fw-bold d-block text-truncate text-white" style="font-size: 0.9rem;" title="{{ auth()->user()->nama_lengkap ?? auth()->user()->username }}">
                            {{ auth()->user()->nama_lengkap ?? auth()->user()->username ?? 'Nama Admin' }}
                        </span>
                        <div class="d-flex align-items-center gap-1.5 mt-0.5">
                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0.5" style="font-size: 0.6rem; font-weight: 700; letter-spacing: 0.02em;">ONLINE</span>
                            <span class="text-white-50 small text-uppercase" style="font-size: 0.65rem; font-weight: 600;">&bull; {{ auth()->user()->role ?? 'Admin' }}</span>
                        </div>
                    </div>
                </div>

                <div class="menu-navigation-wrapper">
                    <span class="menu-section-label">Menu Utama</span>
                    <ul class="nav nav-pills flex-column gap-1.5 mb-4">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-grid-1x2-fill fs-5"></i> Dashboard
                            </a>
                        </li>
                    </ul>

                    <span class="menu-section-label">Modul Layanan</span>
                    <div class="d-flex flex-column gap-2">

                        <div>
                            <button @click="digilibOpen = !digilibOpen; if(digilibOpen) pengaduanOpen = false"
                                    class="drawer-dropdown-trigger"
                                    :class="digilibOpen ? 'open-active' : ''">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-book-half fs-5 text-primary"></i>
                                    <span>Perpustakaan Digital</span>
                                </div>
                                <i class="bi small" :class="digilibOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                            </button>

                            <div x-show="digilibOpen" x-collapse class="drawer-submenu-box">
                                <a href="{{ route('digitallibrary.admin.dashboard') }}" class="nav-link {{ request()->routeIs('digitallibrary.admin.dashboard') ? 'active' : '' }}">
                                    <i class="bi bi-speedometer2 fs-6"></i> Dashboard Perpus
                                </a>
                                <a href="{{ route('digitallibrary.admin.books.index') }}" class="nav-link {{ request()->routeIs('digitallibrary.admin.books.*') ? 'active active-books' : '' }}">
                                    <i class="bi bi-journal-bookmark-fill fs-6"></i> Kelola Buku
                                </a>
                                <a href="{{ route('digitallibrary.admin.users.index') }}" class="nav-link {{ request()->routeIs('digitallibrary.admin.users.*') ? 'active active-users' : '' }}">
                                    <i class="bi bi-people-fill fs-6"></i> Kelola Pengguna
                                </a>
                                <a href="{{ route('digitallibrary.admin.transactions.index') }}" class="nav-link {{ request()->routeIs('digitallibrary.admin.transactions.*') ? 'active active-transactions' : '' }}">
                                    <i class="bi bi-arrow-left-right fs-6"></i> Transaksi Pinjam
                                </a>
                                <a href="{{ route('digitallibrary.admin.dendas.index') }}" class="nav-link {{ request()->routeIs('digitallibrary.admin.dendas.*') ? 'active active-dendas' : '' }}">
                                    <i class="bi bi-cash-coin fs-6"></i> Denda
                                </a>
                            </div>
                        </div>

                        <div>
                            <button @click="pengaduanOpen = !pengaduanOpen; if(pengaduanOpen) digilibOpen = false"
                                    class="drawer-dropdown-trigger"
                                    :class="pengaduanOpen ? 'open-active' : ''">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-chat-left-text-fill fs-5 text-warning"></i>
                                    <span>Pengaduan & Sarana</span>
                                </div>
                                <i class="bi small" :class="pengaduanOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                            </button>

                            <div x-show="pengaduanOpen" x-collapse class="drawer-submenu-box">
                                <a href="{{ route('saranapengaduan.admin.dashboard') }}" class="nav-link {{ request()->routeIs('saranapengaduan.admin.dashboard') ? 'active active-pengaduan' : '' }}">
                                    <i class="bi bi-speedometer2 fs-6"></i> Dashboard Pengaduan
                                </a>
                                <a href="{{ route('saranapengaduan.admin.index') }}" class="nav-link {{ request()->routeIs('saranapengaduan.admin.index') || request()->routeIs('saranapengaduan.admin.show') ? 'active active-pengaduan' : '' }}">
                                    <i class="bi bi-card-list fs-6"></i> Daftar Laporan
                                </a>
                            </div>
                        </div>

                    </div>

                    <span class="menu-section-label mt-4">Sistem</span>
                    <ul class="nav nav-pills flex-column gap-1.5">
                        <li class="nav-item">
                            <a href="{{ route('security.logs.index') }}" class="nav-link {{ request()->routeIs('security.logs.*') ? 'active active-security' : '' }}">
                                <i class="bi bi-shield-exclamation fs-5"></i> Security Logs
                            </a>
                        </li>
                    </ul>
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