<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi - LKSA Yatim Muhammadiyah Karangasem</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/donasi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <!-- Hero Banner Section -->
    <section class="hero-banner">
        <div class="hero-content">
            <h1 class="hero-title">Donasikan Segera Rezekimu Ke LKSA Yatim Muhammadiyah Karangasem</h1>
            <div class="hero-search">
                <input type="text" class="search-input" placeholder="Cari campaign donasi...">
                <button class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Campaign Section -->
    <section class="campaign-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Campaign Donasi</h2>
                <p class="section-subtitle">Kegiatan Panti Asuhan</p>
            </div>
            
            <!-- Campaign Grid -->
            <div class="campaign-grid">
                <!-- Campaign Item 1 -->
                <div class="campaign-item">
                    <img src="{{ asset('storage\donasi1.jpg') }}" alt="Donasi kreativ">
                    <div class="campaign-overlay">
                        <h3>Kegiatan Seni & Kreativitas</h3>
                        <p>Mengembangkan bakat seni anak-anak yatim</p>
                    </div>
                </div>
                
                <!-- Campaign Item 2 -->
                <div class="campaign-item">
                    <img src="{{ asset('storage\Qurban.jpg') }}" alt="peternakan">
                    <div class="campaign-overlay">
                        <h3>Program Peternakan</h3>
                        <p>Pengembangan usaha peternakan untuk kemandirian</p>
                    </div>
                </div>
                
                <!-- Campaign Item 3 -->
                <div class="campaign-item">
                    <img src="{{ asset('storage/qiroah.jpeg') }}" alt="Belajar agama">
                    <div class="campaign-overlay">
                        <h3>Pendidikan Agama</h3>
                        <p>Pembelajaran agama dan moral untuk anak-anak</p>
                    </div>
                </div>
                
                <!-- Campaign Item 4 -->
                <div class="campaign-item">
                    <img src="{{ asset('storage\masjid2.jpg') }}" alt="Masjid">
                    <div class="campaign-overlay">
                        <h3>Pembangunan Masjid</h3>
                        <p>Pembangunan tempat ibadah yang layak</p>
                    </div>
                </div>
                
                <!-- Campaign Item 5 -->
                <div class="campaign-item">
                    <img src="{{ asset('storage\pendidikan.jpg') }}" alt="pendidikan">
                    <div class="campaign-overlay">
                        <h3>Pendidikan Formal</h3>
                        <p>Pendidikan formal untuk masa depan yang lebih baik</p>
                    </div>
                </div>
                
                <!-- Campaign Item 6 -->
                <div class="campaign-item">
                    <img src="{{ asset('storage\fotokegiatan4.jpg') }}" alt="kesehatan">
                    <div class="campaign-overlay">
                        <h3>Kegiatan Bersama</h3>
                        <p>Membangun kebersamaan dan solidaritas</p>
                    </div>
                </div>
            </div>
            
            <!-- Read More Button -->
            <div class="read-more-container">
                <button class="read-more-btn">Selengkapnya</button>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <div class="footer-logo">
                    <i class="fas fa-quote-left"></i>
                    <span>FH</span>
                </div>
            </div>
            
            <div class="footer-divider"></div>
            
            <div class="footer-social">
                <a href="#" class="social-icon">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
            
            <div class="footer-copyright">
                <p>&copy; Since. 2025. Fahmi Huwaidi</p>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>
