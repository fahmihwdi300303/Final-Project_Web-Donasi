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
Route::post('Auth', [AuthControllerr::class, 'login']);

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
