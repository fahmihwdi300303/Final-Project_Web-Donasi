<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/kegiatan', [App\Http\Controllers\KegiatanController::class, 'index']);

// About Us Page
Route::get('/about', function () {
    return view('aboutus');
});

// Donation Routes
Route::get('/donasi', function () {
    return view('donasipage');
});

Route::get('/donasi/uang', function () {
    return view('donasi.form-uang');
});

Route::get('/donasi/validasi-donasi', function () {
    return view('donasi.validasipage');
});

Route::get('/donasi/barang', function () {
    return view('donasi.form-barang');
});

Route::get('/donasi/laporanpage', function () {
    return view('donasi.laporanpage');
});

// Donation Form Page
Route::get('/donasi', function () {
    return view('donasipage');
});

// Donation Validation Page (Admin)


// Financial Report Page
Route::get('/laporan', function () {
    return view('laporanpage');
});

// Auth Pages
Route::view('/login', 'login');
Route::view('/register', 'register');
Route::view('/forgot-password', 'forgot-password');



// Image Management Routes
Route::resource('images', App\Http\Controllers\ImageController::class);


// route login bawaan Laravel
Route::get('Auth', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('Auth', [AuthController::class, 'login']);

// route logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// route khusus admin (pakai middleware)
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
});

// TAMBAHKAN BLOK INI UNTUK MEMPERBAIKI ERROR PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', function() {
        // Untuk sementara, kita tampilkan teks saja.
        // Nanti ini bisa diarahkan ke controller profile yang sesungguhnya.
        return 'Ini adalah halaman profil pengguna.';
    })->name('profile.edit');
});

Route::group(['middleware' => ['role:admin']], function () {
    // Routes that only admins can access
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // =================================================================
    // TAMBAHKAN SEMUA BARIS DI BAWAH INI UNTUK MEMPERBAIKI ERROR
    // =================================================================
    Route::get('/admin/users', function() {
        return 'Halaman Manajemen Pengguna akan dibuat di sini.';
    })->name('admin.users');

    Route::get('/admin/donations', function() {
        return 'Halaman Manajemen Donasi akan dibuat di sini.';
    })->name('admin.donations');

    Route::get('/admin/donation-report', function() {
        return 'Halaman Laporan Donasi akan dibuat di sini.';
    })->name('admin.donation-report');

    Route::get('/admin/financial-report', function() {
        return 'Halaman Laporan Keuangan akan dibuat di sini.';
    })->name('admin.financial-report');
    // =================================================================
});

Route::group(['middleware' => ['role:donatur']], function () {
    // Routes that only donaturs can access
    Route::get('/donatur/dashboard', [DonaturController::class, 'dashboard'])->name('donatur.dashboard');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::view('/donations', 'admin.donations.index');               // /admin/donations
    Route::view('/users',     'admin.users.index');                   // /admin/users
    Route::view('/reports/donation',  'admin.reports.donation');      // /admin/reports/donation
    Route::view('/reports/financial', 'admin.reports.financial');     // /admin/reports/financial
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // CRUD index sudah kamu akses via fallback /admin/donations & /admin/users
    Route::view('/donations/create-money',  'admin.donations.create-money');
    Route::view('/donations/create-goods',  'admin.donations.create-goods');

    // Laporan donasi (admin)
    Route::view('/reports/donation', 'admin.reports.donation');
});
