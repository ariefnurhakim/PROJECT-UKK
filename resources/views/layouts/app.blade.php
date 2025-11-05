<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Qashier')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        min-height: 100vh;
        display: flex;
        background-color: #f8f9fa;
        overflow-x: hidden;
    }

    /* === SIDEBAR === */
    #sidebar {
        width: 230px;
        background-color: #002B5B;
        color: white;
        min-height: 100vh;
    }

    #sidebar .nav-link {
        color: #e5e5e5;
        font-weight: 500;
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 5px;
        transition: 0.15s;
    }

    #sidebar .nav-link:hover {
        background-color: #00509E;
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

    <!-- Sidebar -->
    <div id="sidebar" class="d-flex flex-column p-3">
        <h4 class="text-center fw-bold">Qashier</h4>
        <hr class="border-light">

        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
            </li>
            <li>
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">📦 Produk</a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">🗂 Kategori</a>
            </li>
            <li>
                <a href="{{ route('transactions.index') }}" class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}">💰 Transaksi</a>
            </li>
            <li>
                <a href="{{ route('reports.products') }}" class="nav-link {{ request()->routeIs('reports.products') ? 'active' : '' }}">📊 Laporan Produk</a>
            </li>
            <li>
                <a href="{{ route('reports.transactions') }}" class="nav-link {{ request()->routeIs('reports.transactions') ? 'active' : '' }}">📈 Laporan Transaksi</a>
            </li>
        </ul>
    </div>

    <!-- Konten -->
    <div id="content">

        <!-- TOPBAR -->
        <div class="d-flex justify-content-end align-items-center p-2 border-bottom bg-white">
            <div class="dropdown">
                <button class="btn dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" style="border:none;">
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="35" height="35" class="rounded-circle me-2">
                    <span>{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">👤 Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            Logout
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-4">
            @yield('content')
        </div>

    </div>

    <!-- Logout Modal -->
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
