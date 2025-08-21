<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LKSA Yatim Muhammadiyah Karangasem</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

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
                        <img src="{{ asset('storage/hafalan.jpg') }}" alt="Hafalan Al-Qur'an">
                    </div>
                    <div class="program-content">
                        <h3>Hafalan Al-Qur'an dengan Target lulus 15 juz</h3>
                        <p>Program hafalan Al-Qur'an yang dilaksanakan setiap hari dengan target lulus 15 juz. Dibimbing oleh guru-guru yang berpengalaman dengan fokus pada tajwid dan tahsin. Bertujuan untuk menumbuhkan kecintaan terhadap Al-Qur'an dan menghasilkan generasi yang berilmu dan berakhlak mulia.</p>
                    </div>
                </div>

                <div class="program-card">
                    <div class="program-image">
                        <img src="{{ asset('storage/qiroah.jpeg') }}" alt="Belajar Qiro'ah">
                    </div>
                    <div class="program-content">
                        <h3>Belajar Qiro'ah dengan Qori' Nasional Setiap Kamis Malam</h3>
                        <p>Program pembelajaran Qiro'ah yang dilaksanakan setiap Kamis malam dengan bimbingan Qori' Nasional. Bertujuan untuk meningkatkan kemampuan membaca Al-Qur'an dengan tartil dan tajwid yang benar, serta menumbuhkan motivasi dan kepercayaan diri.</p>
                    </div>
                </div>

                <div class="program-card">
                    <div class="program-image">
                        <img src="{{ asset('storage/menjahit.jpg') }}" alt="Latihan Menjahit">
                    </div>
                    <div class="program-content">
                        <h3>Latihan Menjahit di Bimbing langsung Oleh Penjahit Professional</h3>
                        <p>Program pelatihan menjahit sebagai bagian dari pengembangan life skill yang dibimbing langsung oleh penjahit profesional. Anak-anak belajar menjahit dari tingkat dasar hingga mahir, bertujuan untuk membekali mereka dengan keterampilan wirausaha, ketekunan, kedisiplinan, dan kepercayaan diri untuk masa depan.</p>
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
                        <img src="{{ asset('storage/asrama.jpg') }}" alt="Masjid dan Asrama">
                    </div>
                    <div class="facility-content">
                        <h3>Asrama</h3>
                        <p>Gedung asrama ada 2 asrama putra dan asrama putri sepenuhnya milik LKSA Yatim Muhammadiyah Karangasem.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-image">
                        <img src="{{ asset('storage/masjid.jpg') }}" alt="Masjid dan Asrama">
                    </div>
                    <div class="facility-content">
                        <h3>Masjid </h3>
                        <p>Gedung masjid sepenuhnya milik LKSA Yatim Muhammadiyah Karangasem.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-image">
                        <img src="{{ asset('storage/aula.jpg') }}" alt="Sekolah">
                    </div>
                    <div class="facility-content">
                        <h3>Sekolah</h3>
                        <p>Aktivitas sekolah berlokasi di Ponpes Karangasem yang masih satu yayasan dengan panti asuhan, meliputi jenjang pendidikan SD hingga SMA.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-image">
                        <img src="{{ asset('storage/dapur.jpg') }}" alt="Dapur Bersama">
                    </div>
                    <div class="facility-content">
                        <h3>Dapur Bersama</h3>
                        <p>Memiliki dapur pribadi dan koki, anak-anak juga bisa memasak di sana.</p>
                    </div>
                </div>

                <div class="facility-card">
                    <div class="facility-image">
                        <img src="{{ asset('storage/pendopo.jpg') }}" alt="Pendopo dan Aula">
                    </div>
                    <div class="facility-content">
                        <h3>Pendopo dan Aula</h3>
                        <p>Pendopo dan aula sebagai fasilitas untuk aktivitas bersama anak-anak.</p>
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
                    <div class="stat-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <div class="stat-content">
                        <h3>300+</h3>
                        <p>Donatur Tetap</p>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="stat-content">
                        <h3>TerakreditasiA</h3>
                        <p>oleh Lembaga Kesejahteraan Sosial Pemerintah</p>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3>129</h3>
                        <p>Total anak asuh saat ini</p>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Ratusan</h3>
                        <p>alumni telah berhasil menjadi Tenaga Profesional</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <div class="footer-logo-circle">
                        <span>FH</span>
                    </div>
                </div>
                <div class="footer-social">
                    <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-copyright">
                <p>© Since. 2025. Fahmi Huwaidi & Adellya Puja Kesuma</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>