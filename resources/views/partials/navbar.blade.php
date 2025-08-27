<!-- Header Section -->
<header class="header">
    <div class="header-container">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
    <img src="{{ asset('/storage\logolksa.png') }}" alt="logolksa" class="me-2" style="height: 50px;">
    <span class="logo-text fw-bold">LKSA PANTI ASUHAN YATIM</span>
</a>
        <!-- Navigation -->
        <nav class="nav">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
            <a href="/kegiatan" class="nav-link {{ request()->is('kegiatan*') ? 'active' : '' }}">Kegiatan</a>
            <a href="/about" class="nav-link {{ request()->is('about*') ? 'active' : '' }}">About</a>
            {{-- <a href="/donasi" class="nav-link {{ request()->is('donasi*') ? 'active' : '' }}">Donasi</a> --}}

            <!-- Donasi Dropdown -->
            {{-- ===== Donasi (SINGLE ENTRY — tidak dobel lagi) ===== --}}
            <div class="nav-dropdown {{ (request()->is('donasi') || request()->is('member/donasi*')) ? 'current' : '' }}">
            {{-- Link ke halaman donasi publik selalu ada --}}
            <a href="{{ route('donasi.index') }}"
                class="nav-link {{ (request()->is('donasi') || request()->is('member/donasi*')) ? 'active' : '' }}">
                Donasi
            </a>

            @auth
                {{-- Tombol kecil untuk buka/tutup dropdown (tidak mengganggu link di atas) --}}
                <button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" aria-label="Buka menu Donasi">
                <i class="fas fa-chevron-down dropdown-arrow"></i>
                </button>

                {{-- Menu donasi (hanya muncul saat login) --}}
                <div class="dropdown-menu">
                <a href="{{ route('donor.money.create') }}" class="dropdown-item">
                    <i class="fas fa-money-bill-wave"></i> Form Donasi
                </a>
                <a href="{{ route('donor.goods.create') }}" class="dropdown-item">
                    <i class="fas fa-box"></i> Donasi Barang
                </a>
                <a href="{{ route('donor.proof.create') }}" class="dropdown-item">
                    <i class="fas fa-check-circle"></i> Validasi Donasi
                </a>
                <a href="{{ route('donor.history') }}" class="dropdown-item">
                    <i class="fas fa-chart-bar"></i> Laporan Donasi
                </a>
                </div>
            @endauth
            </div>

            {{-- ====== Style & script kecil untuk dropdown (discope ke .nav-dropdown) ====== --}}
            <style>
            .nav-dropdown{position:relative;display:flex;align-items:center;gap:.25rem}
            .nav-dropdown .dropdown-toggle{background:transparent;border:0;cursor:pointer;padding:.25rem}
            .nav-dropdown .dropdown-menu{
                display:none; position:absolute; top:calc(100% + .5rem); left:0;
                min-width:220px; background:#fff; border-radius:12px;
                box-shadow:0 10px 24px rgba(255, 255, 255, 0.12); padding:.5rem 0; z-index:50
            }
            /* buka saat ada class .open (JS) atau saat hover di desktop */
            .nav-dropdown.open .dropdown-menu{display:block}
            @media (hover:hover){ .nav-dropdown:hover .dropdown-menu{display:block} }
            </style>

            <script>
            // Toggle dropdown hanya untuk klik tombol panah; klik teks "Donasi" tetap ke /donasi
            (function(){
                const root = document.currentScript.closest('.header') || document; // sesuaikan wrapper bila perlu
                root.addEventListener('click', function(e){
                // Tutup dropdown lain dulu
                document.querySelectorAll('.nav-dropdown.open').forEach(d=>{
                    if(!d.contains(e.target)) d.classList.remove('open');
                });

                const btn = e.target.closest('.nav-dropdown .dropdown-toggle');
                if(btn){
                    e.preventDefault();
                    const wrap = btn.closest('.nav-dropdown');
                    wrap.classList.toggle('open');
                }
                });
                // Klik di luar menutup dropdown
                document.addEventListener('click', function(e){
                document.querySelectorAll('.nav-dropdown.open').forEach(d=>{
                    if(!d.contains(e.target)) d.classList.remove('open');
                });
                });
            })();
            </script>
        </nav>
        <!--login-->
            @guest
        <div class="header-buttons">
            <a class="btn btn-outline" href="{{ route('login') }}">Masuk</a>
            <a class="btn btn-primary" href="{{ route('register') }}">Daftar</a>
        </div>
        @else
        <div class="header-buttons">
            <span class="me-2"><i class="fas fa-user"></i> {{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">@csrf
            <button class="btn btn-primary">Logout</button>
            </form>
        </div>
        @endguest
        <!-- Mobile Menu Toggle -->
        <div class="mobile-menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</header>
