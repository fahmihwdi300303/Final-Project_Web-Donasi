@extends('layouts.app')

@section('title', 'Dashboard Donatur - LKSA Yatim Muhammadiyah Karangasem')

@section('content')
<div class="donatur-dashboard">

    <!-- Hero Welcome -->
    <section class="hero hero-dashboard">
        <div class="hero-overlay">
            <div class="hero-text text-center">
                <h1 class="hero-title">Selamat Datang, {{ $user->name }}!</h1>
                <p class="hero-subtitle">Dashboard Donatur - LKSA Yatim Muhammadiyah Karangasem</p>
                <span class="badge badge-donatur">Donatur</span>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center mb-4">Aksi Cepat</h2>
            <div class="programs-grid">
                <a href="{{ route('donatur.donation-form') }}" class="program-card text-center">
                    <div class="program-image"><i class="fas fa-plus-circle fa-3x text-success"></i></div>
                    <div class="program-content"><h3>Form Donasi</h3></div>
                </a>
                <a href="{{ route('donatur.my-donations') }}" class="program-card text-center">
                    <div class="program-image"><i class="fas fa-list fa-3x text-primary"></i></div>
                    <div class="program-content"><h3>Donasi Saya</h3></div>
                </a>
                <a href="{{ route('donatur.donation-validation') }}" class="program-card text-center">
                    <div class="program-image"><i class="fas fa-check-circle fa-3x text-warning"></i></div>
                    <div class="program-content"><h3>Validasi Donasi</h3></div>
                </a>
                <a href="{{ route('donatur.donation-report') }}" class="program-card text-center">
                    <div class="program-image"><i class="fas fa-chart-bar fa-3x text-info"></i></div>
                    <div class="program-content"><h3>Laporan Donasi</h3></div>
                </a>
            </div>
        </div>
    </section>

    <!-- My Donations & Statistics -->
    <section class="my-donations py-5">
        <div class="container">
            <div class="row">
                <!-- My Donations -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5><i class="fas fa-list me-2"></i>Donasi Terbaru Saya</h5>
                            <a href="{{ route('donatur.my-donations') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>Lihat Semua
                            </a>
                        </div>
                        <div class="card-body">
                            @if(count($myDonations) > 0)
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Jenis</th>
                                                <th>Jumlah/Deskripsi</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($myDonations as $donation)
                                            <tr>
                                                <td>#{{ $donation['id'] }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $donation['type'] == 'Uang' ? 'success' : 'info' }}">
                                                        {{ $donation['type'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($donation['type'] == 'Uang')
                                                        Rp {{ number_format($donation['amount'], 0, ',', '.') }}
                                                    @else
                                                        {{ $donation['description'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($donation['status'] == 'verified')
                                                        <span class="badge bg-success">Terverifikasi</span>
                                                    @elseif($donation['status'] == 'pending')
                                                        <span class="badge bg-warning">Menunggu</span>
                                                    @else
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                                <td>{{ $donation['date']->format('d M Y') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">Belum ada donasi</h6>
                                    <p class="text-muted">Mulai berdonasi sekarang untuk membantu anak-anak panti asuhan</p>
                                    <a href="{{ route('donatur.donation-form') }}" class="btn btn-primary">
                                        <i class="fas fa-plus-circle me-2"></i>Buat Donasi
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-transparent">
                            <h5><i class="fas fa-chart-pie me-2"></i>Statistik Donasi</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6>Total Donasi</h6>
                                <h3 class="fw-bold text-success">Rp 2.5M</h3>
                                <small class="text-muted">Sejak bergabung</small>
                            </div>
                            <div class="mb-4">
                                <h6>Donasi Bulan Ini</h6>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: 65%"></div>
                                </div>
                                <small>Rp 650K dari target Rp 1M</small>
                            </div>
                            <div class="row text-center">
                                <div class="col-4">
                                    <h5 class="fw-bold text-success">12</h5>
                                    <small class="text-muted">Terverifikasi</small>
                                </div>
                                <div class="col-4">
                                    <h5 class="fw-bold text-warning">3</h5>
                                    <small class="text-muted">Menunggu</small>
                                </div>
                                <div class="col-4">
                                    <h5 class="fw-bold text-danger">1</h5>
                                    <small class="text-muted">Ditolak</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Activities -->
    <section class="activities py-5 bg-light">
        <div class="container">
            <h2 class="section-title mb-4"><i class="fas fa-clock me-2"></i>Aktivitas Terbaru</h2>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center p-3 border rounded shadow-sm">
                        <i class="fas fa-check-circle fa-2x text-success me-3"></i>
                        <div>
                            <h6 class="mb-1">Donasi Terverifikasi</h6>
                            <p class="text-muted mb-0">Donasi uang Rp 100.000 telah diverifikasi</p>
                            <small class="text-muted">2 hari yang lalu</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center p-3 border rounded shadow-sm">
                        <i class="fas fa-clock fa-2x text-warning me-3"></i>
                        <div>
                            <h6 class="mb-1">Donasi Menunggu</h6>
                            <p class="text-muted mb-0">Donasi barang buku pelajaran sedang menunggu validasi</p>
                            <small class="text-muted">1 hari yang lalu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection