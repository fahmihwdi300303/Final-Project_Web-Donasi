<!-- Header Section -->
<header class="header">
    <div class="header-container">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
    <img src="{{ asset('storage/logolksa.png') }}" alt="logolksa" class="me-2" style="height: 50px;">
    <span class="logo-text fw-bold">LKSA PANTI ASUHAN YATIM</span>
</a>

        <!-- Navigation -->
        <nav class="nav">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
            <a href="/kegiatan" class="nav-link {{ request()->is('kegiatan*') ? 'active' : '' }}">Kegiatan</a>
            <a href="/about" class="nav-link {{ request()->is('about*') ? 'active' : '' }}">About</a>
            <a href="/donasi" class="nav-link {{ request()->is('donasi*') ? 'active' : '' }}">Donasi</a>

            <!-- Donasi Dropdown -->
            <div class="nav-dropdown {{ request()->is('donasi*') ? 'active' : '' }}">
                <a href="#" class="nav-link dropdown-toggle">
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="/donasi/uang" class="dropdown-item">
                        <i class="fas fa-money-bill-wave"></i>
                        Form Donasi
                    </a>
                    <a href="/donasi/barang" class="dropdown-item">
                        <i class="fas fa-box"></i>
                        Donasi Barang
                    </a>
                    <a href="/donasi/validasi-donasi" class="dropdown-item">
                        <i class="fas fa-check-circle"></i>
                        Validasi Donasi
                    </a>
                    <a href="/donasi/laporanpage" class="dropdown-item">
                        <i class="fas fa-chart-bar"></i>
                        Laporan Donasi
                    </a>
                </div>
            </div>
        </nav>
        <!--login-->
            <div class="header-buttons">
                <button class="btn btn-outline" onclick="goToLogin()">Masuk</button>
                <button class="btn btn-primary" onclick="goToRegister()">Daftar</button>
            </div>

        <!-- Mobile Menu Toggle -->
        <div class="mobile-menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</header>
