<!-- resources/views/partials/navbar/offcanvas.blade.php -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNav">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    {{-- Kamu bisa @include partial menu sesuai role, atau tulis ulang link-list pendek --}}
    @include('partials.navbar.role-aware') {{-- hati-hati: ini bisa menampilkan header lagi.
      Alternatif: buat versi "list-only" khusus offcanvas. --}}
  </div>
</div>
