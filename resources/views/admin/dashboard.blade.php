@extends('layouts.app')

@section('title', 'Dashboard Admin - LKSA Yatim Muhammadiyah Karangasem')

@section('content')
<div class="admin-dashboard">

    <!-- Hero Welcome -->
    <section class="hero hero-dashboard">
        <div class="hero-overlay">
            <div class="hero-text text-center">
                <h1 class="hero-title">Selamat Datang, {{ auth()->user()->name }}!</h1>
                <p class="hero-subtitle">Administrator - LKSA Yatim Muhammadiyah Karangasem</p>
                <span class="badge badge-admin">Administrator</span>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="statistics py-5">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-content">
                        <h3>{{ $totalUsers }}</h3>
                        <p>Total Users</p>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <div class="stat-content">
                        <h3>{{ $totalDonatur }}</h3>
                        <p>Total Donatur</p>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-user-shield"></i></div>
                    <div class="stat-content">
                        <h3>{{ $totalAdmin }}</h3>
                        <p>Total Admin</p>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                    <div class="stat-content">
                        <h3>Rp 5.2M</h3>
                        <p>Donasi Bulan Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center mb-4">Aksi Cepat</h2>
            <div class="programs-grid">
                <a href="{{ route('admin.users') }}" class="program-card text-center">
                    <div class="program-image">
                        <i class="fas fa-users fa-3x text-primary"></i>
                    </div>
                    <div class="program-content">
                        <h3>Manajemen User</h3>
                    </div>
                </a>
                <a href="{{ route('admin.donations') }}" class="program-card text-center">
                    <div class="program-image">
                        <i class="fas fa-hand-holding-heart fa-3x text-success"></i>
                    </div>
                    <div class="program-content">
                        <h3>Manajemen Donasi</h3>
                    </div>
                </a>
                <a href="{{ route('admin.donation-report') }}" class="program-card text-center">
                    <div class="program-image">
                        <i class="fas fa-chart-bar fa-3x text-info"></i>
                    </div>
                    <div class="program-content">
                        <h3>Laporan Donasi</h3>
                    </div>
                </a>
                <a href="{{ route('admin.financial-report') }}" class="program-card text-center">
                    <div class="program-image">
                        <i class="fas fa-chart-line fa-3x text-warning"></i>
                    </div>
                    <div class="program-content">
                        <h3>Laporan Keuangan</h3>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Recent Activities & Quick Stats -->
    <section class="activities py-5">
        <div class="container">
            <div class="row">
                <!-- Recent Activities -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-transparent">
                            <h5><i class="fas fa-clock me-2"></i>Aktivitas Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Aktivitas</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><i class="fas fa-user-circle text-primary me-2"></i> John Doe</td>
                                            <td>Submit Donasi</td>
                                            <td>2 menit lalu</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-user-circle text-success me-2"></i> Jane Smith</td>
                                            <td>Login</td>
                                            <td>5 menit lalu</td>
                                            <td><span class="badge bg-success">Success</span></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-user-circle text-info me-2"></i> Bob Johnson</td>
                                            <td>Update Profile</td>
                                            <td>10 menit lalu</td>
                                            <td><span class="badge bg-info">Updated</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-transparent">
                            <h5><i class="fas fa-chart-pie me-2"></i>Statistik Cepat</h5>
                        </div>
                        <div class="card-body">
                            <div class="stat-bar mb-3">
                                <h6>Donasi Hari Ini</h6>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: 75%"></div>
                                </div>
                                <small>Rp 3.9M dari target Rp 5.2M</small>
                            </div>
                            <div class="stat-bar mb-3">
                                <h6>User Aktif</h6>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" style="width: 60%"></div>
                                </div>
                                <small>45 dari 75 user aktif</small>
                            </div>
                            <div class="stat-bar">
                                <h6>Donasi Terverifikasi</h6>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" style="width: 85%"></div>
                                </div>
                                <small>17 dari 20 donasi terverifikasi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection