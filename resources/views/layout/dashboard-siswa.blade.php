<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-body: #f8fafc;
            --text-body: #212529;
            --bg-navbar: #0d6efd; 
            --text-navbar: #ffffff;
            --text-navbar-muted: rgba(255, 255, 255, 0.75);
            --border-navbar-item: rgba(255, 255, 255, 0.15);
        }
        body.dark-mode {
            --bg-body: #121212;
            --text-body: #ffffff;
            --bg-navbar: #1e1e1e; 
            --text-navbar: #ffffff;
            --text-navbar-muted: #bdbdbd;
            --border-navbar-item: #3a3a3a;
        }
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: var(--bg-body) !important;
            color: var(--text-body);
            transition: background-color 0.3s, color 0.3s;
        }
        .main-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--bg-body) !important;
        }
        .content-area {
            flex: 1;
        }
        .navbar {
            margin: 0 !important;
            border-radius: 0 !important;
            background-color: var(--bg-navbar) !important;
            border-bottom: 1px solid var(--border-navbar-item);
        }
        .navbar-brand, .navbar-text, #realtimeClock {
            color: var(--text-navbar) !important;
        }
        .nav-link {
            color: var(--text-navbar-muted) !important;
        }
        .nav-link.active, .nav-link:hover {
            color: var(--text-navbar) !important;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        @auth
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('siswa.dashboard') }}">Perpustakaan</a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('siswa.dashboard') }}">Dashboard Utama</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <span id="realtimeClock">00/00/0000 | 00:00:00</span>
                        <span class="navbar-text">
                            Halo, <strong>{{ Auth::user()->nama_lengkap ?? Auth::user()->username }}</strong>
                            <span class="badge bg-light text-primary ms-1">{{ ucfirst(Auth::user()->role) }}</span>
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        @endauth

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateClock() {
            const now = new Date();
            const clock = document.getElementById('realtimeClock');
            if(clock){
                clock.innerHTML = now.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'}) + ' | ' + now.toLocaleTimeString('id-ID');
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>