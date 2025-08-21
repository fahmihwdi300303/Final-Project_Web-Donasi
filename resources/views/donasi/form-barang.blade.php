<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi Barang - LKSA Yatim Muhammadiyah Karangasem</title>
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
                <h1 class="form-title">Donasi Barang</h1>
                <p class="form-subtitle">Bantu anak-anak yatim dengan donasi barang yang masih layak pakai</p>
                
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
                            <label for="jenisBarang" class="form-label">Jenis Barang *</label>
                            <select id="jenisBarang" name="jenis_barang" class="form-select" required>
                                <option value="">Pilih jenis barang</option>
                                <option value="pakaian">Pakaian</option>
                                <option value="buku">Buku & Alat Tulis</option>
                                <option value="mainan">Mainan</option>
                                <option value="elektronik">Elektronik</option>
                                <option value="makanan">Makanan & Minuman</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <div class="error-message" id="jenisBarangError"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="jumlahBarang" class="form-label">Jumlah Barang *</label>
                            <input type="number" id="jumlahBarang" name="jumlah_barang" class="form-input" min="1" required>
                            <div class="error-message" id="jumlahBarangError"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="kondisiBarang" class="form-label">Kondisi Barang *</label>
                            <select id="kondisiBarang" name="kondisi_barang" class="form-select" required>
                                <option value="">Pilih kondisi barang</option>
                                <option value="baru">Baru</option>
                                <option value="bekas_layak">Bekas Layak Pakai</option>
                                <option value="bekas_rusak">Bekas Rusak Ringan</option>
                            </select>
                            <div class="error-message" id="kondisiBarangError"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-field">
                            <label for="metodePengiriman" class="form-label">Metode Pengiriman *</label>
                            <select id="metodePengiriman" name="metode_pengiriman" class="form-select" required>
                                <option value="">Pilih metode pengiriman</option>
                                <option value="antar">Antar Sendiri</option>
                                <option value="jemput">Jemput</option>
                                <option value="kurir">Kurir</option>
                            </select>
                            <div class="error-message" id="metodePengirimanError"></div>
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
                    <input type="hidden" name="jenis_donasi" value="barang">

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

            <!-- Information Section -->
            <div class="payment-section">
                <h2 class="payment-title">Informasi Donasi Barang</h2>
                <div class="payment-content">
                    <div class="info-section">
                        <h3 class="info-title">Barang yang Diterima</h3>
                        <ul class="info-list">
                            <li><i class="fas fa-check"></i> Pakaian layak pakai (anak-anak & dewasa)</li>
                            <li><i class="fas fa-check"></i> Buku pelajaran & bacaan</li>
                            <li><i class="fas fa-check"></i> Alat tulis & perlengkapan sekolah</li>
                            <li><i class="fas fa-check"></i> Mainan edukatif</li>
                            <li><i class="fas fa-check"></i> Makanan & minuman dalam kemasan</li>
                            <li><i class="fas fa-check"></i> Peralatan elektronik yang masih berfungsi</li>
                        </ul>
                    </div>
                    
                    <div class="info-section">
                        <h3 class="info-title">Syarat & Ketentuan</h3>
                        <ul class="info-list">
                            <li><i class="fas fa-info-circle"></i> Barang harus dalam kondisi layak pakai</li>
                            <li><i class="fas fa-info-circle"></i> Pakaian harus bersih dan tidak robek</li>
                            <li><i class="fas fa-info-circle"></i> Makanan harus belum kadaluarsa</li>
                            <li><i class="fas fa-info-circle"></i> Elektronik harus masih berfungsi</li>
                            <li><i class="fas fa-info-circle"></i> Kami akan menghubungi untuk konfirmasi</li>
                        </ul>
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
