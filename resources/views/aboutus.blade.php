<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - LKSA Yatim Muhammadiyah Karangasem</title>
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
            <!-- Section 1: Tentang Panti Asuhan -->
            <section class="about-section">
                <h1 class="section-title">Tentang Panti Asuhan</h1>
                <h2 class="section-subtitle">Sejarah Awal LKSA Yatim Muhammadiyah Karangasem</h2>
                <div class="content-grid">
                    <div class="content-text">
                        <p>
                            LKSA Yatim Muhammadiyah Karangasem didirikan pada tahun 1994 oleh KH Abdurrahman Syamsuri (Yi Man). 
                            Lembaga ini fokus pada pembinaan anak yatim, fakir miskin, dan keluarga kurang mampu, terutama dalam 
                            bidang pendidikan dan pembinaan agama. Awalnya bernama PAYM Karangasem, kini beroperasi di bawah 
                            naungan Muhammadiyah dengan komitmen untuk menciptakan generasi yang berakhlak, mandiri, dan bermanfaat.
                        </p>
                    </div>
                    <div class="content-image">
                        <img src="{{ asset('storage\sejarah.jpg') }}" alt="Sejarah">
                    </div>
                </div>
            </section>

            <!-- Section 2: Anak Asuh -->
            <section class="about-section">
                <h2 class="section-title">Anak Asuh</h2>
                <div class="content-grid reverse">
                    <div class="content-image">
                        <img src="{{ asset('storage\anakasuh.jpg') }}" alt="Anak">
                    </div>
                    <div class="content-text">
                        <p>
                            Saat ini LKSA membina 129 anak asuh, terdiri dari 87 anak asrama dan 42 anak non-asrama. 
                            Anak-anak berasal dari berbagai daerah di Indonesia seperti Sumatera Utara, Aceh, Ambon, NTT, 
                            Timor Leste, dan Jawa. Pembinaan anak tidak hanya fokus pada akademik, tetapi juga untuk 
                            menjadi dai Muhammadiyah.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 3: Pimpinan -->
            <section class="about-section">
                <h2 class="section-title">Pimpinan LKSA Yatim Muhammadiyah Karangasem</h2>
                <div class="content-grid">
                    <div class="content-text">
                        <p>LKSA telah mengalami empat periode kepemimpinan:</p>
                        <ul class="leadership-list">
                            <li>KH Muhammad Jasin Syamsuri</li>
                            <li>Abdul Lathif Husnan</li>
                            <li>H Muzayyin</li>
                            <li>Drs. H Ahmad Amin, M.Pd (2023-sekarang)</li>
                        </ul>
                        <p>Dibantu oleh:</p>
                        <ul class="leadership-list">
                            <li>Fahrur Rosikh, S.Pd., M.Pd (Sekretaris)</li>
                            <li>H. Murifan (Bendahara)</li>
                        </ul>
                    </div>
                    <div class="content-image">
                        <img src="{{ asset('storage\pimpinan.jpg') }}" alt="Pimpinan LKSA">
                    </div>
                </div>
            </section>

            <!-- Section 4: Misi dan Kaderisasi -->
            <section class="about-section">
                <h2 class="section-title">Misi dan Kaderisasi</h2>
                <div class="content-grid reverse">
                    <div class="content-image">
                        <img src="{{ asset('storage\misi.jpg') }}" alt="VISI-MISI">
                    </div>
                    <div class="content-text">
                        <p>
                            Misi LKSA adalah mencetak kader dan dai Muhammadiyah dari seluruh penjuru tanah air. 
                            Anak-anak dikembalikan ke kampung halaman untuk mengabdi, menjadi guru, dai, kepala sekolah, 
                            bahkan pengusaha. Banyak alumni yang telah berhasil dalam berbagai karir, termasuk TNI, PNS, 
                            dan wirausaha.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section 5: Kontak dan Lokasi -->
            <section class="about-section">
                <h2 class="section-title">Tentang Kami</h2>
                <!-- Ganti gambar dengan embed Google Maps -->
        <div class="content-image">
            <iframe 
                src="https://bit.ly/41eEi0N" 
                width="100%" 
                height="300" 
                style="border:0; border-radius:12px;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
                    <div class="content-text">
                        <div class="contact-info">
                            <div class="contact-item">
                                <strong>Alamat:</strong>
                                <p>Jl. Sendang, Paciran, Kec. Paciran, Kabupaten Lamongan, Jawa Timur 62264</p>
                            </div>
                            <div class="contact-item">
                                <strong>Telepon:</strong>
                                <p>(+62)895-500-1223</p>
                            </div>
                            <div class="contact-item">
                                <strong>Email:</strong>
                                <p>LKSAMKarangasem@gmail.com</p>
                            </div>
                            <div class="contact-item">
                                <strong>Website:</strong>
                                <p>WWW.LKSAKarangasem.id</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="cta-section">
                <div class="cta-content">
                    <h2 class="cta-title">Mari bersama kami mencetak generasi masa depan. Donasi, dukungan, dan doa Anda sangat berarti.</h2>
                </div>
            </section>
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

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>
