<!-- resources/views/partials/navbar/public.blade.php -->
<header class="header">
  <div class="header-container d-flex align-items-center justify-content-between">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('storage/logolksa.png') }}" alt="logolksa" class="me-2" style="height: 50px;">
      <span class="logo-text fw-bold">LKSA PANTI ASUHAN YATIM</span>
    </a>

    <nav class="nav d-none d-md-flex align-items-center gap-3">
      <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
      <a href="/kegiatan" class="nav-link {{ request()->is('kegiatan*') ? 'active' : '' }}">Kegiatan</a>
      <a href="/about" class="nav-link {{ request()->is('about*') ? 'active' : '' }}">About</a>
      <a href="/donasi" class="nav-link {{ request()->is('donasi') ? 'active' : '' }}">Donasi</a>

      <div class="nav-dropdown {{ request()->is('donasi/*') ? 'active' : '' }}">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-chevron-down dropdown-arrow"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <a href="{{ route('login') }}" class="dropdown-item">
            <i class="fas fa-money-bill-wave"></i> Form Donasi (Login)
          </a>
          <a href="{{ route('login') }}" class="dropdown-item">
            <i class="fas fa-box"></i> Donasi Barang (Login)
          </a>
          <a href="{{ route('login') }}" class="dropdown-item">
            <i class="fas fa-check-circle"></i> Validasi Donasi (Login)
          </a>
          <a href="{{ route('login') }}" class="dropdown-item">
            <i class="fas fa-chart-bar"></i> Laporan Donasi (Login)
          </a>
        </div>
      </div>
    </nav>

    <div class="header-buttons d-none d-md-flex">
      <a class="btn btn-outline" href="{{ route('login') }}">Masuk</a>
      <a class="btn btn-primary ms-2" href="{{ route('register') }}">Daftar</a>
    </div>

    <button class="btn d-md-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav">
      <i class="fas fa-bars"></i>
    </button>
  </div>
</header>
