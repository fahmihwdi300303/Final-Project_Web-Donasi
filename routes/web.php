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


// ====== Public ======
Route::view('/', 'homepage');
Route::view('/dashboard', 'dashboard');
Route::get('/kegiatan', [App\Http\Controllers\KegiatanController::class, 'index']);
Route::view('/about', 'aboutus');

Route::view('/donasi', 'donasipage');
Route::view('/donasi/uang', 'donasi.form-uang');
Route::view('/donasi/barang', 'donasi.form-barang');
Route::view('/donasi/validasi-donasi', 'donasi.validasipage');
Route::view('/donasi/laporanpage', 'donasi.laporanpage');

Route::view('/login', 'login');
Route::view('/register', 'register');
Route::view('/forgot-password', 'forgot-password');

Route::resource('images', App\Http\Controllers\ImageController::class)->only(['index','store','destroy']);

Route::get('Auth', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('Auth', [AuthController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->get('/profile', fn() => 'Ini adalah halaman profil pengguna.')->name('profile.edit');


Route::middleware(['auth','role:admin'])
    ->prefix('admin')->as('admin.')
    ->group(function () {
        // Dashboard (pakai controller – lihat Langkah 2 di bawah)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::view('/users',        'admin.users.index')->name('users.index');
        Route::view('/users/create', 'admin.users.create')->name('users.create');
        // (nanti kalau siap backend penuh, ganti jadi Route::resource('users', ...))

        // Donations
        Route::view('/donations',              'admin.donations.index')->name('donations.index');
        Route::view('/donations/create',       'admin.donations.create')->name('donations.create');
        Route::view('/donations/create-money', 'admin.donations.create-money')->name('donations.create-money');
        Route::view('/donations/create-goods', 'admin.donations.create-goods')->name('donations.create-goods');
        // (nanti bisa diganti ke Route::resource('donations', ...))

        // Reports
        Route::view('/reports/donation',  'admin.reports.donation')->name('reports.donation');
        Route::view('/reports/financial', 'admin.reports.financial')->name('reports.financial');

        // === USERS: store ===
Route::post('/users', function(\Illuminate\Http\Request $r) {
    $r->validate([
        'name'     => 'required|string|max:190',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role'     => 'required|in:admin,donatur',
    ]);

    $user = \App\Models\User::create([
        'name'     => $r->name,
        'email'    => $r->email,
        'password' => bcrypt($r->password),
    ]);

    // kalau pakai spatie/permission
    if (method_exists($user, 'assignRole')) {
        $user->assignRole($r->role);
    }

    return redirect()->route('admin.users.index')->with('success','Pengguna dibuat.');
})->name('users.store');


// === DONATIONS: store ===
// (dipakai oleh form create-money & create-goods yang action-nya route('admin.donations.store'))
Route::post('/donations', function(\Illuminate\Http\Request $r) {
    $r->validate([
        'metode_pembayaran' => 'required|string',               // qris/transfer/cash/barang
        'status'            => 'nullable|in:pending,verified,rejected',
        'jumlah'            => 'nullable|numeric|min:0',
        'email'             => 'nullable|email',
    ]);

    // opsional: auto-buat donatur jika email diisi
    $userId = null;
    if ($r->filled('email')) {
        $u = \App\Models\User::firstOrCreate(
            ['email' => $r->email],
            ['name' => trim(($r->first_name.' '.$r->last_name) ?: $r->email),
             'password' => bcrypt(\Illuminate\Support\Str::random(12))]
        );
        if (method_exists($u,'assignRole')) { $u->assignRole('donatur'); }
        $userId = $u->id;
    }

    \App\Models\Donation::create([
        'user_id'           => $userId,
        'jumlah'            => $r->input('jumlah', 0),
        'metode_pembayaran' => $r->metode_pembayaran,           // qris/transfer/cash/barang
        'status'            => $r->input('status','pending'),
        'catatan'           => $r->input('catatan'),
    ]);

            return redirect()->route('admin.donations.index')->with('success','Donasi disimpan.');
        })->name('donations.store');
    });
