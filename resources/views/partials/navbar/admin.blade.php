@php use Illuminate\Support\Facades\Route; @endphp
<!-- resources/views/partials/navbar/admin.blade.php -->
<header class="header">
  <div class="header-container d-flex align-items-center justify-content-between">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
      <img src="{{ asset('storage/logolksa.png') }}" alt="logolksa" class="me-2" style="height: 50px;">
      <span class="logo-text fw-bold">Admin Panel</span>
    </a>

    <nav class="nav d-none d-md-flex align-items-center gap-3">
<!-- Dashboard (boleh tetap pakai named route karena sudah ada) -->
<a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : url('/admin/dashboard') }}"
   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
  <i class="fas fa-grid-2 me-1"></i> Dashboard
</a>

<!-- Donasi -->
<a href="{{ Route::has('admin.donations.index') ? route('admin.donations.index') : url('/admin/donations') }}"
   class="nav-link {{ request()->is('admin/donations*') ? 'active' : '' }}">
  <i class="fas fa-hand-holding-heart me-1"></i> Donasi
</a>

<!-- Pengguna -->
<a href="{{ Route::has('admin.users.index') ? route('admin.users.index') : url('/admin/users') }}"
   class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
  <i class="fas fa-users me-1"></i> Pengguna
</a>

<!-- Laporan Keuangan -->
<a href="{{ Route::has('admin.financial-report') ? route('admin.financial-report') : url('/admin/financial-report') }}"
   class="nav-link {{ request()->is('admin/financial-report') ? 'active' : '' }}">
  <i class="fas fa-chart-line me-1"></i> Laporan Keuangan
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
