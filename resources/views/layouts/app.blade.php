<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <script src="https://cdn.tailwindcss.com"></script>
  <head>
    @stack('styles')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name','Laravel'))</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Bootstrap CSS (untuk UI dashboard & navbar existing) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome (ikon yang dipakai di dashboard & navbar) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- Tailwind (dipertahankan bila halaman lain ada yang pakai) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- Styles khusus halaman --}}
    @stack('styles')

    <style>
  /* === THEME: BLUE (scoped) ========================================= */

  .theme-blue{
    --bs-primary:#2563eb; --bs-primary-rgb:37,99,235;
    --bs-info:#38bdf8; --bs-warning:#fbbf24; --bs-success:#22c55e; --bs-danger:#ef4444;
  }
  .theme-blue .nav-link.active{color:var(--bs-primary)!important;border-bottom:2px solid var(--bs-primary);font-weight:600}
  .theme-blue .card{box-shadow:0 8px 20px rgba(2,6,23,.06);border:1px solid rgba(2,6,23,.06)}
  .theme-blue table thead th{background:rgba(var(--bs-primary-rgb),.06);border-bottom:1px solid rgba(2,6,23,.06)}
  .theme-blue .table-hover tbody tr:hover{background:rgba(var(--bs-primary-rgb),.04)}
  .theme-blue {
    /* Bootstrap CSS variables */
    --bs-primary: #2563eb;      /* blue-600 */
    --bs-primary-rgb: 37, 99, 235;
    --bs-link-color: #2563eb;
    --bs-link-hover-color: #1d4ed8;
    --bs-info: #38bdf8;         /* sky-400 */
    --bs-warning: #fbbf24;      /* amber-400 */
    --bs-success: #22c55e;      /* green-500 */
    --bs-danger: #ef4444;       /* red-500 */

    /* Optional: card & border tones */
    --card-shadow: 0 8px 20px rgba(2, 6, 23, 0.06);
    --soft-border: 1px solid rgba(2, 6, 23, 0.06);
  }

  /* Headings/sections feel */
  .theme-blue .section-title{
    font-weight:700; color:#0f172a; /* slate-900 */
    border-left:4px solid var(--bs-primary); padding-left:.75rem;
  }

  /* Button & link consistency (no UI redesign, hanya warna) */
  .theme-blue .btn-primary{
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color:#fff;                          /* <- ini kunci */
  }
.theme-blue .btn-outline{
  border:1px solid var(--bs-primary);
  color:var(--bs-primary);
}
.theme-blue .btn-primary:hover{
  filter: brightness(.95);
  color:#fff;
}
.theme-blue .btn-outline{
  border:1px solid var(--bs-primary);
  color:var(--bs-primary);
}
.theme-blue .btn-outline:hover{
  background: rgba(var(--bs-primary-rgb), .08);
}
  /* Tables */
  .theme-blue table thead th{
    background: rgba(var(--bs-primary-rgb), .06);
    color:#0f172a;
    border-bottom: var(--soft-border);
  }
  .theme-blue .table-hover tbody tr:hover{
    background: rgba(var(--bs-primary-rgb), .04);
  }

  /* Cards */
  .theme-blue .card{ box-shadow: var(--card-shadow); border: var(--soft-border); }

  /* Badges defaulting closer to theme */
  .theme-blue .badge.bg-info{ background-color: var(--bs-info)!important; }
  .theme-blue .badge.bg-warning{ background-color: var(--bs-warning)!important; }
  .theme-blue .badge.bg-success{ background-color: var(--bs-success)!important; }
  .theme-blue .badge.bg-danger{ background-color: var(--bs-danger)!important; }

  /* ===== Dashboard specific: stat-card & action-card ================== */
  .theme-blue .stat-card{
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); /* deep blue → blue */
    color:#fff; border-radius:12px; padding:1.5rem;
    transition: transform .3s ease, box-shadow .3s ease;
  }
  .theme-blue .stat-card:hover{ transform:translateY(-5px); box-shadow: var(--card-shadow); }
  .theme-blue .stat-icon{ font-size:2rem; opacity:.9; }

  .theme-blue .action-card{
    text-decoration:none; color:#0f172a; transition: all .3s ease;
  }
  .theme-blue .action-card:hover{
    transform:translateY(-5px); color:var(--bs-primary);
    box-shadow: var(--card-shadow);
  }
</style>

  </head>
  <body class="font-sans antialiased bg-gray-100">
    {{-- Navbar global: akan menampilkan menu berbeda tergantung role --}}
    @include('partials.navbar.role-aware')

        @if (session('warning'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-md p-3">
        {{ session('warning') }}
        </div>
    </div>
    @endif
    {{-- Page Heading (opsional, dipakai jika $header diset) --}}
    @if (isset($header))
      <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          {{ $header }}
        </div>
      </header>
    @endif

    {{-- Page Content --}}
    <main class="py-4">
    <div class="theme-blue">
        @yield('content')
    </div>
    </main>
    {{-- Bootstrap JS bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Scripts khusus halaman --}}
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.0.8/r-3.0.2/datatables.min.css">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/r-3.0.2/datatables.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('table.table-admin').forEach(tbl => {
        new DataTable(tbl, {
            responsive:true, autoWidth:false, pageLength:10,
            language:{ url:'https://cdn.datatables.net/plug-ins/2.0.8/i18n/id.json' }
        });
        });
    });
    </script>
@stack('scripts')
  </body>
</html>
