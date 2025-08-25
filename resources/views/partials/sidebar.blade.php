<aside class="d-none d-lg-block bg-white border-end" style="width:260px; position:fixed; top:0; bottom:0;">
  <div class="p-3 border-bottom">
    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none fw-bold">Admin Panel</a>
  </div>
  <nav class="nav flex-column p-2">
    <a class="nav-link {{ request()->routeIs('admin.dashboard')?'active':'' }}" href="{{ route('admin.dashboard') }}">
      <i class="bi bi-grid me-2"></i> Dashboard
    </a>
    <a class="nav-link {{ request()->is('admin/donations*')?'active':'' }}" href="{{ route('admin.donations.index') }}">
      <i class="bi bi-cash-coin me-2"></i> Donasi
    </a>
    <a class="nav-link {{ request()->is('admin/users*')?'active':'' }}" href="{{ route('admin.users.index') }}">
      <i class="bi bi-people me-2"></i> Pengguna
    </a>
  </nav>
</aside>
