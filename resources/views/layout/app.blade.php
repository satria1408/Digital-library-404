<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,
        body{
            margin:0;
            padding:0;
            min-height:100%;
            background:#0f172a;
        }

        .navbar{
            margin:0 !important;
            border-radius:0 !important;
        }

        #realtimeClock{
            color:#ffffff !important;
            font-size:14px;
            font-weight:600;
            white-space:nowrap;
        }

        .navbar-text{
            color:#ffffff !important;
        }

        @media (max-width: 768px){

            #realtimeClock{
                font-size:12px;
            }

            .navbar-text{
                font-size:13px;
            }

        }
    </style>
</head>

<body>

    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">

            <a class="navbar-brand fw-bold" href="#">
                Perpustakaan
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">

                    @if(Auth::user()->role == 'admin')

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}"
                               href="{{ route('books.index') }}">
                                Kelola Buku
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                               href="{{ route('users.index') }}">
                                Kelola Anggota
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}"
                               href="{{ route('transactions.index') }}">
                                Transaksi
                            </a>
                        </li>

                    @endif

                    @if(Auth::user()->role == 'siswa')

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"
                               href="{{ route('siswa.dashboard') }}">
                                Dashboard & Peminjaman
                            </a>
                        </li>

                    @endif

                </ul>

                <div class="d-flex align-items-center gap-3 flex-wrap">

                    {{-- Jam Realtime --}}
                    <span id="realtimeClock">
                        00/00/0000 | 00:00:00
                    </span>

                    {{-- Info User --}}
                    <span class="navbar-text">
                        Halo,
                        <strong>{{ Auth::user()->nama_lengkap }}</strong>

                        <span class="badge bg-light text-primary ms-1">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </span>

                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-danger btn-sm">
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </nav>
    @endauth

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Jam Realtime --}}
    <script>

        function updateClock() {

            const now = new Date();

            const tanggal = now.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

            const jam = now.toLocaleTimeString('id-ID');

            document.getElementById('realtimeClock').innerHTML =
                tanggal + ' | ' + jam;
        }

        updateClock();

        setInterval(updateClock, 1000);

    </script>

    @stack('scripts')

</body>
</html>