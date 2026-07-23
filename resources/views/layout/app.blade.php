<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Perpustakaan & Portal Sekolah</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --app-surface-bg: #f8fafc;
        --app-text-main: #0f172a;
        --drawer-bg: #0f172a;
        --drawer-text: #f8fafc;
    }

    body.dark-mode {
        --app-surface-bg: #0b0f17;
        --app-text-main: #f3f4f6;
        --drawer-bg: #0b0f17;
        --drawer-text: #f3f4f6;
    }

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        background-color: var(--app-surface-bg) !important;
        color: var(--app-text-main) !important;
        transition: background-color 0.25s ease, color 0.25s ease;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .base-layout-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-color: var(--app-surface-bg) !important;
    }

    .dynamic-view-viewport { flex: 1; }

    /* Custom Clean Top Navbar */
    .custom-app-nav {
        background-color: #ffffff !important;
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    body.dark-mode .custom-app-nav {
        background-color: #1e293b !important;
        border-bottom-color: #334155;
    }

    .nav-pill-custom {
        color: #64748b;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 0.5rem 0.9rem;
        border-radius: 9999px;
        transition: all 0.2s ease;
    }

    .nav-pill-custom:hover {
        background-color: #f1f5f9;
        color: #0d6efd;
    }

    .nav-pill-custom.active {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd !important;
    }

    body.dark-mode .nav-pill-custom { color: #94a3b8; }
    body.dark-mode .nav-pill-custom:hover { background-color: #334155; color: #38bdf8; }
    body.dark-mode .nav-pill-custom.active { background-color: rgba(56, 189, 248, 0.15); color: #38bdf8 !important; }

    /* Dark mode override */
    body.dark-mode .text-dark,
    body.dark-mode h1, body.dark-mode h2, body.dark-mode h3,
    body.dark-mode h4, body.dark-mode h5, body.dark-mode h6,
    body.dark-mode .card h4, body.dark-mode .card h5 { color: #ffffff !important; }

    body.dark-mode .text-muted { color: #9ca3af !important; }

    body.dark-mode .card {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25) !important;
    }

    body.dark-mode .bg-white { background-color: #1e293b !important; }

    /* Offcanvas Drawer Styling */
    .custom-drawer {
        background-color: var(--drawer-bg) !important;
        color: var(--drawer-text) !important;
    }

    .drawer-profile-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
    }

    .menu-section-label {
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(255, 255, 255, 0.35);
        padding-left: 12px;
        margin-bottom: 8px;
        display: block;
    }

    .custom-drawer .nav-link {
        color: rgba(255, 255, 255, 0.7) !important;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: 10px;
        padding: 10px 14px !important;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .custom-drawer .nav-link:hover {
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.08) !important;
        transform: translateX(3px);
    }

    .custom-drawer .nav-link.active {
        color: #ffffff !important;
        background: linear-gradient(135deg, #0d6efd, #0a58ca) !important;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
    }
</style>

</head>
<body>
    <div class="base-layout-container">
    @auth

    <!-- TOP NAVBAR CLEAN & MODERN -->
    <nav class="navbar navbar-expand-lg custom-app-nav sticky-top py-2 shadow-sm">
        <div class="container-fluid px-3 px-lg-4">
            
            <!-- Mobile Menu Toggle Button -->
            <button class="btn btn-link text-dark p-0 border-0 me-3 d-lg-none shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#appMobileDrawer">
                <i class="bi bi-list fs-2"></i>
            </button>

            <!-- Brand Logo -->
            <a class="navbar-brand d-flex align-items-center gap-2 me-4" href="{{ route('digitallibrary.admin.dashboard') }}">
                <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-building-gear fs-5"></i>
                </div>
                <div>
                    <span class="fw-bold text-dark fs-6 d-block lh-1">Oneschool</span>
                    <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 rounded-pill mt-1" style="font-size: 0.62rem;">Admin Hub</span>
                </div>
            </a>

            <!-- Desktop Nav Menu -->
            <div class="collapse navbar-collapse" id="desktopNavRegistry">
                <ul class="navbar-nav me-auto gap-1">
                    
                    <!-- 1. Dashboard Utama -->
                    <li class="nav-item">
                        <a class="nav-link nav-pill-custom d-flex align-items-center gap-1.5 {{ request()->routeIs('digitallibrary.admin.dashboard') ? 'active' : '' }}" href="{{ route('digitallibrary.admin.dashboard') }}">
                            <i class="bi bi-grid-fill text-primary"></i> Dashboard Utama
                        </a>
                    </li>

                    <!-- 2. Dropdown Pilih Modul Active -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-pill-custom dropdown-toggle d-flex align-items-center gap-1.5" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-layers-fill text-secondary"></i> Kelola Modul
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg rounded-4 p-2 mt-2" style="width: 260px;">
                            
                            <!-- Sub Modul 1: Digital Library -->
                            <li>
                                <a class="dropdown-item rounded-3 py-2 d-flex align-items-center gap-2.5" href="{{ route('digitallibrary.admin.books.index') }}">
                                    <div class="bg-purple-subtle text-purple p-2 rounded-3 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-book-half text-primary fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">Perpustakaan Digital</div>
                                        <small class="text-muted d-block" style="font-size: 0.72rem;">Buku, Anggota, Transaksi</small>
                                    </div>
                                </a>
                            </li>

                            <li><hr class="dropdown-divider my-1"></li>

                            <!-- Sub Modul 2: Sarana Pengaduan -->
                            <li>
                                <a class="dropdown-item rounded-3 py-2 d-flex align-items-center gap-2.5" href="{{ route('saranapengaduan.admin.dashboard') }}">
                                    <div class="bg-warning-subtle text-warning p-2 rounded-3 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-chat-square-text-fill text-warning fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">Sarana Pengaduan</div>
                                        <small class="text-muted d-block" style="font-size: 0.72rem;">Kelola aduan fasilitas</small>
                                    </div>
                                </a>
                            </li>

                            <li><hr class="dropdown-divider my-1"></li>

                            <!-- Sub Modul 3: Security Log -->
                            <li>
                                <a class="dropdown-item rounded-3 py-2 d-flex align-items-center gap-2.5" href="{{ route('security.logs.index') }}">
                                    <div class="bg-danger-subtle text-danger p-2 rounded-3 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-shield-lock-fill text-danger fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">Security Log</div>
                                        <small class="text-muted d-block" style="font-size: 0.72rem;">Pantau riwayat aktivitas</small>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </li>

                </ul>
            </div>

            <!-- Right Controls: Theme Switcher, Clock, Profile -->
            <div class="d-flex align-items-center gap-3 ms-auto">
                
                <!-- Dark Mode Toggle -->
                <button id="themeSwitcherToggle" class="btn btn-light rounded-circle border-0 p-2 shadow-none d-flex align-items-center justify-content-center" onclick="switchAppTheme()" title="Ganti Mode Visual" style="width: 36px; height: 36px;">
                    <i id="themeToggleStateIcon" class="bi bi-moon-stars-fill text-dark fs-6"></i>
                </button> 

                <!-- Jam Realtime -->
                <span id="liveClockDisplay" class="d-none d-xl-inline small fw-semibold text-secondary">00/00/0000 | 00:00:00</span>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary border-0 rounded-pill btn-sm dropdown-toggle d-flex align-items-center gap-2 p-1 pe-3" data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 0.8rem;">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'A', 0, 1)) }}
                        </div>
                        <span class="fw-semibold small text-dark d-none d-md-inline">{{ auth()->user()->nama_lengkap }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 mt-2">
                        <li>
                            <div class="px-3 py-2">
                                <span class="d-block fw-bold small text-dark">{{ auth()->user()->nama_lengkap }}</span>
                                <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 rounded-pill" style="font-size: 0.65rem;">
                                    {{ ucfirst(auth()->user()->role ?? 'Admin') }}
                                </span>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger rounded-3 fw-semibold small d-flex align-items-center gap-2">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <!-- MOBILE DRAWER (OFFCANVAS) -->
    <div class="offcanvas offcanvas-start custom-drawer border-0 shadow-lg" tabindex="-1" id="appMobileDrawer" style="width: 280px;">
        <div class="offcanvas-header border-bottom border-secondary border-opacity-10 py-3 px-4">
            <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center gap-2" style="font-size: 1.1rem;">
                <i class="bi bi-shield-lock-fill text-primary"></i> Portal Admin
            </h5>
            <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" style="font-size: 0.8rem;"></button>
        </div>

        <div class="offcanvas-body px-3 py-4">

            <!-- Profile Card -->
            <div class="drawer-profile-card p-3 d-flex align-items-center gap-3 mb-4">
                <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 42px; height: 42px; min-width: 42px; font-size: 1.1rem; background: linear-gradient(135deg, #0d6efd, #0b5ed7) !important;">
                    {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <span class="fw-bold d-block text-truncate text-white" style="font-size: 0.88rem;">
                        {{ auth()->user()->nama_lengkap }}
                    </span>
                    <div class="d-flex align-items-center gap-1 mt-0.5">
                        <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0" style="font-size: 0.6rem; font-weight: 700;">ONLINE</span>
                        <span class="text-white-50 small text-uppercase" style="font-size: 0.65rem;">• {{ ucfirst(auth()->user()->role ?? 'Admin') }}</span>
                    </div>
                </div>
            </div>

            <!-- Drawer Menu Navigation -->
            <div class="menu-navigation-wrapper">
                <span class="menu-section-label">Menu Utama</span>
                <ul class="nav nav-pills flex-column gap-1 mb-4">
                    <li class="nav-item">
                        <a href="{{ route('digitallibrary.admin.dashboard') }}" class="nav-link {{ request()->routeIs('digitallibrary.admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-fill fs-5 text-primary"></i> Dashboard Utama
                        </a>
                    </li>
                </ul>

                <span class="menu-section-label">Perpustakaan Digital</span>
                <ul class="nav nav-pills flex-column gap-1 mb-4">
                    <li class="nav-item">
                        <a href="{{ route('digitallibrary.admin.books.index') }}" class="nav-link {{ request()->routeIs('digitallibrary.admin.books.*') ? 'active' : '' }}">
                            <i class="bi bi-book-half fs-5"></i> Kelola Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('digitallibrary.admin.users.index') }}" class="nav-link {{ request()->routeIs('digitallibrary.admin.users.*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill fs-5"></i> Anggota
                        </a>
                    </li> 
                    <li class="nav-item">
                        <a href="{{ route('digitallibrary.admin.transactions.index') }}" class="nav-link {{ request()->routeIs('digitallibrary.admin.transactions.*') ? 'active' : '' }}">
                            <i class="bi bi-arrow-left-right fs-5"></i> Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('digitallibrary.admin.dendas.index') }}" class="nav-link {{ request()->routeIs('digitallibrary.admin.dendas.*') ? 'active' : '' }}">
                            <i class="bi bi-cash-stack fs-5"></i> Denda
                        </a>
                    </li>
                </ul>

                <span class="menu-section-label">Sarana Pengaduan</span>
                <ul class="nav nav-pills flex-column gap-1 mb-4">
                    <li class="nav-item">
                        <a href="{{ route('saranapengaduan.admin.dashboard') }}" class="nav-link {{ request()->routeIs('saranapengaduan.admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 fs-5"></i> Dashboard Pengaduan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('saranapengaduan.admin.index') }}" class="nav-link {{ request()->routeIs('saranapengaduan.admin.index') || request()->routeIs('saranapengaduan.admin.show') ? 'active' : '' }}">
                            <i class="bi bi-card-list fs-5"></i> Daftar Laporan
                        </a>
                    </li>
                </ul>

                <span class="menu-section-label">Keamanan</span>
                <ul class="nav nav-pills flex-column gap-1">
                    <li class="nav-item">
                        <a href="{{ route('security.logs.index') }}" class="nav-link {{ request()->routeIs('security.logs.*') ? 'active' : '' }}">
                            <i class="bi bi-shield-lock-fill fs-5"></i> Security Log
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endauth

    <!-- VIEWPORT CONTENT -->
    <div class="dynamic-view-viewport">
        @yield('content')
    </div>
    </div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    function renderLiveDateTime() {
        const currentDateInstance = new Date();
        const containerElement = document.getElementById('liveClockDisplay');
        if (containerElement) {
            containerElement.innerHTML = currentDateInstance.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'}) + ' | ' + currentDateInstance.toLocaleTimeString('id-ID');
        }
    }
    setInterval(renderLiveDateTime, 1000);
    renderLiveDateTime();

    function switchAppTheme() {
        document.body.classList.toggle('dark-mode');
        const contextualIcon = document.getElementById('themeToggleStateIcon');
        if (document.body.classList.contains('dark-mode')) {
            if (contextualIcon) contextualIcon.className = 'bi bi-sun-fill fs-6 text-warning';
        } else {
            if (contextualIcon) contextualIcon.className = 'bi bi-moon-stars-fill fs-6 text-dark';
        }
    }
</script>

@stack('scripts')
</body>
</html>