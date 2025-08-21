<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Donasi - LKSA Yatim Muhammadiyah Karangasem</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="validation-container">
                <!-- Page Title -->
                <div class="page-header">
                    <h1 class="page-title">Validasi Donasi</h1>
                </div>

                <!-- Validation Form -->
                <div class="validation-form-container">
                    <form class="validation-form" id="validationForm">
                        <div class="form-left">
                            <div class="form-group">
                                <label for="donorName">Nama</label>
                                <input type="text" id="donorName" name="donorName" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label for="donorWhatsapp">Nomor Whatsapp</label>
                                <input type="tel" id="donorWhatsapp" name="donorWhatsapp" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label for="donorEmail">Email</label>
                                <input type="email" id="donorEmail" name="donorEmail" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label for="donationType">Jenis donasi</label>
                                <input type="text" id="donationType" name="donationType" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label for="donationAmount">Nominal</label>
                                <div class="amount-input">
                                    <span class="currency">Rp.</span>
                                    <input type="number" id="donationAmount" name="donationAmount" class="form-input" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-right">
                            <div class="upload-section">
                                <label for="donationReceipt" class="upload-label">Upload bukti donasi *</label>
                                <div class="upload-area" id="uploadArea">
                                    <div class="upload-gambar">
                                        <img src="https://via.placeholder.com/50x50/cccccc/666666?text=📷" alt="Upload Gambar">
                                    </div>
                                    <p class="upload-text">drop atau klik disini</p>
                                    <input type="file" id="donationReceipt" name="donationReceipt" class="file-input" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="form-actions">
                        <button type="submit" form="validationForm" class="btn btn-primary btn-submit">Kirim</button>
                    </div>
                </div>
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
            </div>
            <div class="footer-copyright">
                © Since 2025, Fahmi Huwadi
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
