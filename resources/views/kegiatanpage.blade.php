<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan - LKSA Yatim Muhammadiyah Karangasem</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kegiatan.css') }}">
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
            <h1 class="hero-title">KEGIATAN.</h1>
        </div>
    </div>
</section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <h2 class="section-title">Foto Kegiatan Panti Asuhan</h2>
            
            <div class="activities-grid">
                @foreach($activities as $activity)
                <div class="activity-card" data-activity-id="{{ $activity['id'] }}">
                    <div class="activity-image">
                        <img src="{{ $activity['image'] }}" alt="{{ $activity['title'] }}" loading="lazy">
                    </div>
                    <div class="activity-content">
                        <h3>{{ $activity['title'] }}</h3>
                        <p class="activity-date">{{ \Carbon\Carbon::parse($activity['date'])->format('d F Y') }}</p>
                        <p class="activity-description">{{ $activity['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Quote Section -->
            <div class="quote-section">
                <blockquote class="quote">
                    "Mari bersama kami mencetak generasi masa depan. Donasi, dukungan, dan doa Anda sangat berarti."
                </blockquote>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <div class="footer-icon">FH</div>
            </div>
            <div class="footer-divider"></div>
            <div class="footer-social">
                <div class="social-icon"></div>
                <div class="social-icon"></div>
                <div class="social-icon"></div>
                <div class="social-icon"></div>
                <div class="social-icon"></div>
            </div>
            <div class="footer-copyright">
                © Since 2025 Fahmi Huwaidi
            </div>
        </div>
    </footer>

    <!-- Activity Modal -->
    <div id="activityModal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div class="modal-body">
                <div class="modal-image">
                    <img id="modalImage" src="" alt="">
                </div>
                <div class="modal-info">
                    <h2 id="modalTitle"></h2>
                    <p id="modalDate" class="modal-date"></p>
                    <p id="modalDescription" class="modal-description"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/kegiatan.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>
