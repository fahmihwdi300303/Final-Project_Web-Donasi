{{-- resources/views/partials/navbar/role-aware.blade.php --}}
@php
  // Jika pakai Spatie Permission, direktif @role/@hasrole akan otomatis ada.
  // Kalau belum, fallback sederhana di bawah tetap jalan.
  $isAuth = auth()->check();
  $user = $isAuth ? auth()->user() : null;
@endphp

@auth
  @role('admin')
    @include('partials.navbar.admin')
  @else
    @role('donatur')
      @include('partials.navbar.donor')
    @else
      {{-- logged-in tapi tanpa role spesifik -> tampilkan navbar visitor --}}
      @include('partials.navbar.public')
    @endrole
  @endrole
@else
  {{-- guest/visitor --}}
  @include('partials.navbar.public')
@endauth
