@extends('layouts.app')

@section('title', 'Form Donasi - LKSA Yatim Muhammadiyah Karangasem')

@section('content')
<main class="main-content">
    <div class="container">

        <!-- Form Section -->
        <div class="form-section">
            <h1 class="form-title">Form Donasi</h1>
            <p class="form-subtitle">Bantu anak-anak yatim dengan donasi Anda</p>
            
            <form method="POST" action="{{ route('donatur.submit-donation') }}" id="donationForm" class="donasi-form" novalidate>
                @csrf

                <!-- Informasi Donatur -->
                <div class="form-group">
                    <label class="form-label fw-bold"><i class="fas fa-user me-2"></i>Informasi Donatur</label>
                    <div class="form-row">
                        <div class="form-field">
                            <label for="donor_name" class="form-label">Nama Lengkap</label>
                            <input type="text" id="donor_name" name="donor_name" class="form-input" 
                                   value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <div class="form-field">
                            <label for="donor_email" class="form-label">Email</label>
                            <input type="email" id="donor_email" name="donor_email" class="form-input" 
                                   value="{{ auth()->user()->email }}" readonly>
                        </div>
                    </div>
                </div>

                <!-- Jenis Donasi -->
                <div class="form-group">
                    <label class="form-label fw-bold"><i class="fas fa-gift me-2"></i>Jenis Donasi</label>
                    <div class="form-row">
                        <div class="form-check-field">
                            <input class="form-check-input" type="radio" name="type" id="type_money" value="uang" checked>
                            <label for="type_money"><i class="fas fa-money-bill-wave text-success me-2"></i>Donasi Uang</label>
                        </div>
                        <div class="form-check-field">
                            <input class="form-check-input" type="radio" name="type" id="type_goods" value="barang">
                            <label for="type_goods"><i class="fas fa-box text-info me-2"></i>Donasi Barang</label>
                        </div>
                    </div>
                </div>

                <!-- Donasi Uang -->
                <div id="moneyFields" class="form-group">
                    <div class="form-row">
                        <div class="form-field">
                            <label for="amount" class="form-label">Jumlah Donasi (Rp)</label>
                            <div class="input-group">
                                <span class="input-prefix">Rp</span>
                                <input type="number" id="amount" name="amount" class="form-input" min="1000" step="1000" placeholder="100000">
                            </div>
                            <small class="form-hint">Minimal donasi Rp 1.000</small>
                        </div>
                        <div class="form-field">
                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                            <select id="payment_method" name="payment_method" class="form-select">
                                <option value="">Pilih metode pembayaran</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="qris">QRIS</option>
                                <option value="cash">Tunai</option>
                                <option value="e-wallet">E-Wallet</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Donasi Barang -->
                <div id="goodsFields" class="form-group" style="display: none;">
                    <div class="form-row">
                        <div class="form-field">
                            <label for="description" class="form-label">Deskripsi Barang</label>
                            <textarea id="description" name="description" class="form-textarea" rows="3" placeholder="Contoh: Buku pelajaran, pakaian, makanan..."></textarea>
                        </div>
                        <div class="form-field">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="number" id="quantity" name="quantity" class="form-input" min="1" placeholder="1">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-field">
                            <label for="condition" class="form-label">Kondisi Barang</label>
                            <select id="condition" name="condition" class="form-select">
                                <option value="">Pilih kondisi</option>
                                <option value="new">Baru</option>
                                <option value="good">Bekas (Masih Bagus)</option>
                                <option value="fair">Bekas (Layak Pakai)</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="delivery_method" class="form-label">Metode Pengiriman</label>
                            <select id="delivery_method" name="delivery_method" class="form-select">
                                <option value="">Pilih metode</option>
                                <option value="drop_off">Antar ke Panti</option>
                                <option value="pickup">Jemput</option>
                                <option value="courier">Kurir</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Pesan -->
                <div class="form-group">
                    <label for="message" class="form-label"><i class="fas fa-comment me-2"></i>Pesan (Opsional)</label>
                    <textarea id="message" name="message" class="form-textarea" rows="3" placeholder="Tulis pesan atau doa untuk anak-anak panti"></textarea>
                </div>

                <!-- Anonim -->
                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" id="anonymous" name="anonymous" class="form-check-input">
                        <span>Saya ingin donasi ini bersifat anonim</span>
                    </label>
                </div>

                <!-- Tombol -->
                <div class="form-group">
                    <button type="submit" class="submit-btn">
                        <span class="btn-text"><i class="fas fa-paper-plane me-2"></i>Kirim Donasi</span>
                    </button>
                    <a href="{{ route('donatur.dashboard') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </form>
        </div>

        <!-- Payment Section (seperti Figma) -->
        <div class="payment-section">
            <h2 class="payment-title">Pilih Metode Pembayaran</h2>
            <div class="payment-content">
                <div class="qr-section">
                    <div class="qr-code">
                        <img src="https://via.placeholder.com/200x200/000000/ffffff?text=QR+Code" alt="QR Code Pembayaran">
                    </div>
                    <div class="qr-info">
                        <div class="qr-logo">QRIS</div>
                        <p class="qr-description">QR Code Standar Pembayaran Nasional</p>
                    </div>
                </div>
                <div class="bank-section">
                    <h3 class="bank-title">Transfer Bank</h3>
                    <div class="bank-grid">
                        <div class="bank-item"><img src="https://via.placeholder.com/80x40/1e3a8a/ffffff?text=Mandiri"><span>Mandiri</span></div>
                        <div class="bank-item"><img src="https://via.placeholder.com/80x40/1e3a8a/ffffff?text=BCA"><span>BCA</span></div>
                        <div class="bank-item"><img src="https://via.placeholder.com/80x40/f97316/ffffff?text=BNI"><span>BNI</span></div>
                        <div class="bank-item"><img src="https://via.placeholder.com/80x40/1e3a8a/ffffff?text=BRI"><span>BRI</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
    <script src="{{ asset('js/form-donasi.js') }}"></script>
@endsection