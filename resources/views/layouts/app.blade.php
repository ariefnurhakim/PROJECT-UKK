<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Qashier')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        #sidebar {
            width: 230px;
            background-color: #002B5B;
            color: white;
            min-height: 100vh;
            padding: 25px 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* LOGO */
        #sidebar img {
            width: 115px;
            height: auto;
            object-fit: contain;
            padding: 10px;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            box-shadow: 0 0 6px rgba(0,0,0,0.2);
            margin-bottom: 15px;
        }

        #sidebar hr {
            width: 100%;
            border-color: rgba(255,255,255,0.3);
        }

        #sidebar .nav {
            width: 100%;
            margin-top: 10px;
        }

        #sidebar .nav-link {
            color: #e5e5e5;
            font-weight: 500;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 6px;
            transition: 0.15s;
        }

        #sidebar .nav-link:hover {
            background-color: #004C8C;
            color: white;
        }

        #sidebar .nav-link.active {
            background-color: #007BFF;
            color: white;
        }

        #content {
            flex: 1;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div id="sidebar">

        <img src="{{ asset('image/logo.png') }}" alt="Logo">
       
        <hr>

        <ul class="nav nav-pills flex-column mb-auto">

            <li class="nav-item">
                <a href="{{ route('dashboard') }}" 
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    🏠 Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('transactions.index') }}"
                   class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                    💰 Transaksi
                </a>
            </li>

            <li class="nav-item">
    <div class="dropdown">
        <a class="nav-link dropdown-toggle {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'active' : '' }}"
           data-bs-toggle="dropdown" href="#">
            📦 Produk
        </a>

        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item {{ request()->routeIs('products.*') ? 'active' : '' }}"
                   href="{{ route('products.index') }}">
                    📦 Produk
                </a>
            </li>

            <li>
                <a class="dropdown-item {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                   href="{{ route('categories.index') }}">
                    🗂 Kategori
                </a>
            </li>
        </ul>
    </div>
</li>

            <li class="nav-item">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                       data-bs-toggle="dropdown" href="#">
                        📁 Laporan
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('reports.transactions') }}">
                                📄 Laporan Transaksi
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('reports.products') }}">
                                📊 Laporan Produk
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>

    <!-- CONTENT -->
    <div id="content">
        <div class="d-flex justify-content-between align-items-center p-2 border-bottom bg-white">
            <h5 class="text-#e5e5e5 ms-5">TSIQOH SECONDSTORE</h5>

            <div class="dropdown">
                <button class="btn dropdown-toggle d-flex align-items-center"
                        data-bs-toggle="dropdown" style="border:none;">
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                         width="35" height="35" class="rounded-circle me-2">
                    <span>{{ Auth::user()->name }}</span>
                </button>
                
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile') }}">👤 Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button type="button" class="dropdown-item text-danger"
                                data-bs-toggle="modal" data-bs-target="#logoutModal">
                            Logout
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="p-4">
            @yield('content')
        </div>
    </div>

    <!-- LOGOUT MODAL -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Apakah kamu yakin ingin logout?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
