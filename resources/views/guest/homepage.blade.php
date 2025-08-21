@extends('layouts.app')

@section('title', 'Beranda - LKSA Yatim Muhammadiyah Karangasem')

@section('content')

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay">
            <div class="hero-text">
                <h1 class="hero-title">Dari Panti, Lahir Kader Bangsa dan Da'i Umat.</h1>
            </div>
        </div>
    </section>

    <!-- Program Unggulan Section -->
    <section class="programs">
        <div class="container">
            <h2 class="section-title">Program Unggulan LKSA Yatim Muhammadiyah Karangasem</h2>
            <div class="programs-grid">
                <div class="program-card">
                    <div class="program-image">
                        <img src="https://via.placeholder.com/400x300/4A90E2/FFFFFF?text=Hafalan+Al-Qur'an" alt="Hafalan Al-Qur'an">
                    </div>
                    <div class="program-content">
                        <h3>Hafalan Al-Qur'an dengan Target lulus 15 juz</h3>
                        <p>Program hafalan Al-Qur'an yang dilaksanakan setiap hari dengan target lulus 15 juz. Dibimbing oleh guru berpengalaman, fokus tajwid & tahsin, untuk menumbuhkan generasi Qur'ani.</p>
                    </div>
                </div>

                <div class="program-card">
                    <div class="program-image">
                        <img src="https://via.placeholder.com/400x300/50C878/FFFFFF?text=Qiro\'ah" alt="Belajar Qiro'ah">
                    </div>
                    <div class="program-content">
                        <h3>Belajar Qiro'ah dengan Qori' Nasional Setiap Kamis Malam</h3>
                        <p>Program pembelajaran Qiro'ah setiap Kamis malam bersama Qori' Nasional, untuk meningkatkan kemampuan membaca Al-Qur'an secara tartil dan benar.</p>
                    </div>
                </div>

                <div class="program-card">
                    <div class="program-image">
                        <img src="https://via.placeholder.com/400x300/FF6B35/FFFFFF?text=Menjahit" alt="Latihan Menjahit">
                    </div>
                    <div class="program-content">
                        <h3>Latihan Menjahit dengan Penjahit Professional</h3>
                        <p>Pelatihan keterampilan menjahit, dari dasar hingga mahir, membekali anak-anak dengan life skill, wirausaha, kedisiplinan, dan kepercayaan diri.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fasilitas Section -->
    <section class="facilities">
        <div class="container">
            <h2 class="section-title">Fasilitas</h2>
            <div class="facilities-grid">
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://via.placeholder.com/300x200/8B4513/FFFFFF?text=Masjid+dan+Asrama" alt="Masjid dan Asrama">
                    </div>
                    <div class="facility-content">
                        <h3>Masjid dan Asrama</h3>
                        <p>Gedung masjid dan asrama sepenuhnya milik LKSA Yatim Muhammadiyah Karangasem.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://via.placeholder.com/300x200/228B22/FFFFFF?text=Sekolah" alt="Sekolah">
                    </div>
                    <div class="facility-content">
                        <h3>Sekolah</h3>
                        <p>Satu yayasan dengan Ponpes Karangasem, menyediakan pendidikan SD–SMA.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://via.placeholder.com/300x200/FFD700/000000?text=Dapur+Bersama" alt="Dapur Bersama">
                    </div>
                    <div class="facility-content">
                        <h3>Dapur Bersama</h3>
                        <p>Dapur pribadi dengan koki, juga tempat anak-anak belajar memasak.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-image">
                        <img src="https://via.placeholder.com/300x200/CD853F/FFFFFF?text=Pendopo+dan+Aula" alt="Pendopo dan Aula">
                    </div>
                    <div class="facility-content">
                        <h3>Pendopo dan Aula</h3>
                        <p>Ruang aktivitas bersama anak-anak, pertemuan, dan kegiatan keagamaan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="statistics">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-hand-holding-usd"></i></div>
                    <div class="stat-content">
                        <h3>300+</h3>
                        <p>Donatur Tetap</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-certificate"></i></div>
                    <div class="stat-content">
                        <h3>Terakreditasi A</h3>
                        <p>oleh Lembaga Kesejahteraan Sosial Pemerintah</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-content">
                        <h3>129</h3>
                        <p>Total anak asuh saat ini</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
                    <div class="stat-content">
                        <h3>Ratusan</h3>
                        <p>Alumni menjadi tenaga profesional</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection