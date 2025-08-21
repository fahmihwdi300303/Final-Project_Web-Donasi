<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi Uang - LKSA Yatim Muhammadiyah Karangasem</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-donasi.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="form-section">
                <h1 class="form-title">Donasi Uang</h1>
                <p class="form-subtitle">Bantu anak-anak yatim dengan donasi uang Anda</p>
                
                <form id="donasiForm" class="donasi-form" novalidate>
                    <!-- Personal Information -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="form-field">
                                <label for="namaDepan" class="form-label">Nama Depan *</label>
                                <input type="text" id="namaDepan" name="nama_depan" class="form-input" required>
                                <div class="error-message" id="namaDepanError"></div>
                            </div>
                            <div class="form-field">
                                <label for="namaBelakang" class="form-label">Nama Belakang *</label>
                                <input type="text" id="namaBelakang" name="nama_belakang" class="form-input" required>
                                <div class="error-message" id="namaBelakangError"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" class="form-input" required>
                            <div class="error-message" id="emailError"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="whatsapp" class="form-label">Nomor WhatsApp *</label>
                            <input type="tel" id="whatsapp" name="whatsapp" class="form-input" required>
                            <div class="error-message" id="whatsappError"></div>
                        </div>
                    </div>

                    <!-- Donation Information -->
                    <div class="form-group">
                        <div class="form-field">
                            <label for="jumlah" class="form-label">Jumlah Donasi (Rp) *</label>
                            <div class="input-group">
                                <span class="input-prefix">Rp</span>
                                <input type="number" id="jumlah" name="jumlah" class="form-input" min="1000" step="1000" required>
                            </div>
                            <div class="error-message" id="jumlahError"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="metodePembayaran" class="form-label">Metode Pembayaran *</label>
                            <select id="metodePembayaran" name="metode_pembayaran" class="form-select" required>
                                <option value="">Pilih metode pembayaran</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="qris">QRIS</option>
                                <option value="cash">Tunai</option>
                                <option value="ewallet">E-Wallet</option>
                            </select>
                            <div class="error-message" id="metodePembayaranError"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea id="catatan" name="catatan" class="form-textarea" rows="4" placeholder="Ketik di sini..."></textarea>
                            <div class="error-message" id="catatanError"></div>
                        </div>
                    </div>

                    <!-- Hidden field for donation type -->
                    <input type="hidden" name="jenis_donasi" value="uang">

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="submit-btn" id="submitBtn">
                            <span class="btn-text">Kirim Donasi</span>
                            <span class="btn-loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i>
                                Mengirim...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Payment Method Section -->
            <div class="payment-section">
                <h2 class="payment-title">Pilih Metode Pembayaran</h2>
                <div class="payment-content">
                    <div class="qr-section">
                        <div class="qr-code">
                            <img src="{{ asset('storage\qriskode.png') }}" alt="QR Code Pembayaran">
                        </div>
                        <div class="qr-info">
                            <div class="qr-logo">QRIS</div>
                            <p class="qr-description">QR Code Standar Pembayaran Nasional</p>
                        </div>
                    </div>
                    
                    <div class="bank-section">
                        <h3 class="bank-title">Transfer Bank</h3>
                        <div class="bank-grid">
                            <div class="bank-item">
                                <img src="{{ asset('storage\bank-mandiri.png') }}" alt="Bank Mandiri">
                                <span>Mandiri</span>
                            </div>
                            <div class="bank-item">
                                <img src="{{ asset('storage\bca.jpg') }}" alt="Bank BCA">
                                <span>BCA</span>
                            </div>
                            <div class="bank-item">
                                <img src="{{ asset('storage\bni.jpg') }}" alt="Bank BNI">
                                <span>BNI</span>
                            </div>
                            <div class="bank-item">
                                <img src="{{ asset('storage\BRI.jpeg') }}" alt="Bank BRI">
                                <span>BANK BRI</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
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

    <!-- Scripts -->
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/form-donasi.js') }}"></script>
</body>
</html>
