<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua route aplikasi Anda.
*/

Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login'])->name('login.perform');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->name('register.perform');
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password',[PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password',        [NewPasswordController::class, 'store'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

/* =========================
|  PUBLIC (Landing)
========================= */
Route::view('/', 'homepage');
Route::view('/dashboard', 'dashboard');

Route::get('/kegiatan', [App\Http\Controllers\KegiatanController::class, 'index']);
Route::view('/about', 'aboutus');

Route::view('/donasi',              'donasipage');
Route::view('/donasi/uang',         'donasi.form-uang');
Route::view('/donasi/barang',       'donasi.form-barang');
Route::view('/donasi/validasi-donasi', 'donasi.validasipage');
Route::view('/donasi/laporanpage',  'donasi.laporanpage');

/* Resource contoh (biarkan sesuai kebutuhan Anda) */
Route::resource('images', App\Http\Controllers\ImageController::class)->only(['index','store','destroy']);

/* Auth (view sederhana) */
Route::view('/login', 'login');
Route::view('/register', 'register');
Route::view('/forgot-password', 'forgot-password');


/* Login/Logout bawaan Anda */
Route::get('Auth',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('Auth', [AuthController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

/* Hotfix profile */
Route::middleware('auth')->get('/profile', fn() => 'Ini adalah halaman profil pengguna.')->name('profile.edit');


/* =========================
|  ADMIN (Auth + role:admin)
========================= */
Route::middleware(['auth','role:admin.'])
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
                        'donasi_id'   => $donation->donation_id,
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


