@extends('layouts.app')

@section('title', 'Dashboard Admin - LKSA Yatim Muhammadiyah Karangasem')

{{-- Menambahkan CSS kustom untuk halaman ini --}}
@push('styles')
<style>
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .stat-icon {
        font-size: 2rem;
        opacity: 0.8;
    }
    .stat-content h3 {
        font-size: 2.25rem;
        font-weight: 700;
    }
    .stat-content p {
        font-size: 1rem;
        opacity: 0.9;
    }
    .action-card {
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
    }
    .action-card .card-body {
        font-size: 1.5rem;
    }
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        color: #667eea;
    }
    .table-responsive {
        margin-top: 1rem;
    }
    .theme-blue .nav-link.active{
    color: var(--bs-primary)!important;
    border-bottom: 2px solid var(--bs-primary);
    font-weight: 600;
    }
</style>

@endpush

@section('content')
<div class="container py-4">
    {{-- Header Selamat Datang --}}
    <div class="py-12 text-center">
        <h1 class="display-4 font-weight-bold text-gray-800">Selamat Datang, {{ auth()->user()->name }}!</h1>
        <p class="lead text-muted">Anda login sebagai Administrator.</p>
    </div>

    {{-- Kartu Statistik --}}
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card text-center">
                <div class="stat-icon mb-2"><i class="fas fa-users"></i></div>
                <div class="stat-content">
                    <h3>{{ $totalUsers ?? '0' }}</h3>
                    <p>Total Pengguna</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card text-center">
                <div class="stat-icon mb-2"><i class="fas fa-hand-holding-heart"></i></div>
                <div class="stat-content">
                    <h3>{{ $totalDonatur ?? '0' }}</h3>
                    <p>Total Donatur</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card text-center">
                <div class="stat-icon mb-2"><i class="fas fa-user-shield"></i></div>
                <div class="stat-content">
                    <h3>{{ $totalAdmin ?? '0' }}</h3>
                    <p>Total Admin</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card text-center">
                <div class="stat-icon mb-2"><i class="fas fa-chart-line"></i></div>
                <div class="stat-content">
                    <h3>Rp 5.2M</h3>
                    <p>Donasi Bulan Ini</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Aksi Cepat --}}
    <div class="mb-5">
        <h2 class="text-center font-weight-bold mb-4">Aksi Cepat</h2>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.users') }}" class="action-card card text-center">
                    <div class="card-body">
                        <i class="fas fa-users mb-2"></i>
                        <h5 class="card-title">Manajemen User</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.donations') }}" class="action-card card text-center">
                    <div class="card-body">
                        <i class="fas fa-hand-holding-heart mb-2"></i>
                        <h5 class="card-title">Manajemen Donasi</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.donation-report') }}" class="action-card card text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-bar mb-2"></i>
                        <h5 class="card-title">Laporan Donasi</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.financial-report') }}" class="action-card card text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-line mb-2"></i>
                        <h5 class="card-title">Laporan Keuangan</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div>
        <h2 class="text-center font-weight-bold mb-4">Aktivitas Terbaru</h2>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
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
                                <td>John Doe</td>
                                <td>Submit Donasi</td>
                                <td>2 menit lalu</td>
                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                            </tr>
                            <tr>
                                <td>Jane Smith</td>
                                <td>Login</td>
                                <td>5 menit lalu</td>
                                <td><span class="badge bg-success">Success</span></td>
                            </tr>
                            <tr>
                                <td>Bob Johnson</td>
                                <td>Update Profile</td>
                                <td>10 menit lalu</td>
                                <td><span class="badge bg-info text-dark">Updated</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
