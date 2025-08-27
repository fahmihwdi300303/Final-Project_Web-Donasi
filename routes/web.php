<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua route aplikasi Anda.
*/

/* =========================
|  AUTH (Guest only)
========================= */
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login'])->name('login.perform');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->name('register.perform');

    Route::get('/forgot-password',      [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password',     [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password',        [NewPasswordController::class, 'store'])->name('password.update');
});

/* Logout (Auth only) */
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');


/* =========================
|  PUBLIC (Landing)
========================= */
Route::view('/',          'homepage')->name('home');
Route::view('/dashboard', 'dashboard')->name('dashboard');

Route::get('/kegiatan', [App\Http\Controllers\KegiatanController::class, 'index'])->name('kegiatan.index');
Route::view('/about',   'aboutus')->name('about');

Route::view('/donasi',                   'donasipage')->name('donasi.index');
Route::view('/donasi/uang',             'donasi.form-uang')->name('donasi.uang');
Route::view('/donasi/barang',           'donasi.form-barang')->name('donasi.barang');
Route::view('/donasi/validasi-donasi',  'donasi.validasipage')->name('donasi.validasi');
Route::view('/donasi/laporanpage',      'donasi.laporanpage')->name('donasi.laporan');

/* Resource contoh */
Route::resource('images', App\Http\Controllers\ImageController::class)->only(['index','store','destroy'])->names([
    'index'   => 'images.index',
    'store'   => 'images.store',
    'destroy' => 'images.destroy',
]);

/* (Opsional) Profil sederhana - butuh auth */
Route::middleware('auth')->get('/profile', fn() => 'Ini adalah halaman profil pengguna.')->name('profile.edit');


/* =========================
|  DONATUR (Auth + role:donatur)
========================= */
Route::middleware(['auth','role:donatur'])
    ->prefix('donatur')->as('donatur.')
    ->group(function () {
        // Sediakan dashboard donatur supaya redirect tidak 404
        Route::view('/dashboard', 'donatur.dashboard')->name('dashboard');
        // Tambahkan route lain khusus donatur di sini jika perlu
    });


/* =========================
|  ADMIN (Auth + role:admin)
========================= */
Route::middleware(['auth','role:admin'])
    ->prefix('admin')->as('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /* ===== Users ===== */
        Route::view('/users',        'admin.users.index')->name('users.index');
        Route::view('/users/create', 'admin.users.create')->name('users.create');

        // Store User
        Route::post('/users', function (Request $r) {
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

            if (method_exists($user, 'assignRole')) {
                $user->assignRole($r->role);
            }

            return redirect()->route('admin.users.index')->with('success','Pengguna dibuat.');
        })->name('users.store');

        /* ===== Donations ===== */
        Route::view('/donations',              'admin.donations.index')->name('donations.index');
        Route::view('/donations/create',       'admin.donations.create')->name('donations.create');
        Route::view('/donations/create-money', 'admin.donations.create-money')->name('donations.create-money');
        Route::view('/donations/create-goods', 'admin.donations.create-goods')->name('donations.create-goods');

        // Store Donation — Admin = otomatis VERIFIED
        Route::post('/donations', function (Request $r) {
            // Normalisasi angka (menerima 3.000.000 / 3,000,000 / 3000000)
            $rawJumlah = preg_replace('/[^\d]/', '', (string) $r->input('jumlah', '0'));
            $jumlah = $rawJumlah === '' ? 0 : (int) $rawJumlah;

            $r->validate([
                'metode_pembayaran' => 'required|string',  // qris/transfer/cash/barang
                'email'             => 'nullable|email',
                'catatan'           => 'nullable|string',
            ]);

            return DB::transaction(function () use ($r, $jumlah) {

                // (opsional) buat/temukan donatur bila email diisi (tanpa limit; boleh atas nama)
                $userId = null;
                if ($r->filled('email')) {
                    $user = \App\Models\User::firstOrCreate(
                        ['email' => $r->email],
                        [
                            'name'     => trim(($r->first_name.' '.$r->last_name) ?: $r->email),
                            'password' => bcrypt(Str::random(12)),
                        ]
                    );
                    if (method_exists($user, 'assignRole')) {
                        $user->assignRole('donatur');
                    }
                    $userId = $user->id;
                }

                // Karena route ini di group role:admin, paksa status 'verified'
                $donation = \App\Models\Donation::create([
                    'user_id'           => $userId,
                    'jumlah'            => $jumlah,
                    'metode_pembayaran' => $r->metode_pembayaran,
                    'bukti_transfer'    => null,
                    'status'            => 'verified',
                ]);

                // Simpan catatan verifikasi (kalau ada tabelnya & catatan diisi)
                if ($r->filled('catatan') && Schema::hasTable('donation_verifications')) {
                    DB::table('donation_verifications')->insert([
                        // NOTE: sesuaikan kolom FK sesuai skema Anda.
                        // Jika kolomnya 'donation_id' di DB, ganti baris di bawah menjadi 'donation_id' => $donation->id,
                        'donasi_id'   => $donation->id,
                        'admin_id'    => auth()->id(),
                        'status'      => 'verified',
                        'catatan'     => $r->catatan,
                        'verified_at' => now(),
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }

                return redirect()->route('admin.donations.index')
                                 ->with('success','Donasi disimpan dan diverifikasi.');
            });
        })->name('donations.store');

        /* ===== Reports ===== */
        Route::view('/reports/donation',  'admin.reports.donation')->name('reports.donation');
        Route::view('/reports/financial', 'admin.reports.financial')->name('reports.financial');
    });
