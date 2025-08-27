<header class="header">
  <div class="header-container d-flex align-items-center justify-content-between">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
      <img src="{{ asset('storage/logolksa.png') }}" class="me-2" style="height:50px;" alt="logo">
      <span class="logo-text fw-bold">Admin Panel</span>
    </a>

    <nav class="nav d-none d-md-flex align-items-center gap-3">
      <a href="{{ route('admin.dashboard') }}"
         class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-grid-2 me-1"></i> Dashboard
      </a>

      <a href="{{ route('admin.donations.index') }}"
         class="nav-link {{ request()->is('admin/donations*') ? 'active' : '' }}">
        <i class="fas fa-hand-holding-heart me-1"></i> Donasi
      </a>

      <a href="{{ route('admin.users.index') }}"
         class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
        <i class="fas fa-users me-1"></i> Pengguna
      </a>

      <a href="{{ route('admin.reports.donation') }}"
         class="nav-link {{ request()->is('admin/reports/donation') ? 'active' : '' }}">
        <i class="fas fa-chart-bar me-1"></i> Laporan Donasi
      </a>
    </nav>

    <div class="d-none d-md-flex align-items-center gap-2">
      <span class="text-muted small me-2"><i class="fas fa-user-shield me-1"></i>{{ auth()->user()->name }}</span>
      <a href="{{ url('/') }}" class="btn btn-outline">Lihat Situs</a>
      <form action="{{ route('logout') }}" method="POST" class="ms-1">@csrf
        <button class="btn btn-primary">Logout</button>
      </form>
    </div>

    <button class="btn d-md-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav">
      <i class="fas fa-bars"></i>
    </button>
  </div>
</header>
