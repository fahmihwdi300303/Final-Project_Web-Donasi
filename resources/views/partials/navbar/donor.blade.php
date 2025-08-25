<!-- resources/views/partials/navbar/donor.blade.php -->
<header class="header">
  <div class="header-container d-flex align-items-center justify-content-between">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('storage/logolksa.png') }}" alt="logolksa" class="me-2" style="height: 50px;">
      <span class="logo-text fw-bold">LKSA Donatur</span>
    </a>

    <nav class="nav d-none d-md-flex align-items-center gap-3">
      <a href="/donasi/uang" class="nav-link {{ request()->is('donasi/uang') ? 'active' : '' }}">
        <i class="fas fa-money-bill-wave me-1"></i> Form Donasi
      </a>
      <a href="/donasi/barang" class="nav-link {{ request()->is('donasi/barang') ? 'active' : '' }}">
        <i class="fas fa-box me-1"></i> Donasi Barang
      </a>
      <a href="/donasi/validasi-donasi" class="nav-link {{ request()->is('donasi/validasi-donasi') ? 'active' : '' }}">
        <i class="fas fa-check-circle me-1"></i> Validasi Donasi
      </a>
      <a href="/donasi/laporanpage" class="nav-link {{ request()->is('donasi/laporanpage') ? 'active' : '' }}">
        <i class="fas fa-chart-bar me-1"></i> Laporan Donasi
      </a>
    </nav>

    <div class="d-none d-md-flex align-items-center gap-2">
      <span class="text-muted small me-2"><i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}</span>
      <form action="{{ route('logout') }}" method="POST">@csrf
        <button class="btn btn-outline">Logout</button>
      </form>
    </div>

    <button class="btn d-md-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav">
      <i class="fas fa-bars"></i>
    </button>
  </div>
</header>
