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
use App\Http\Controllers\Admin\DonationController;   // daftar donasi admin
use App\Http\Controllers\Admin\ReportController;     // laporan donasi
use App\Http\Controllers\Admin\UserController;       // list pengguna

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua route aplikasi.
*/

/* =========================
|  AUTH (Guest only)
========================= */
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login'])->name('login.perform');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->name('register.perform');

    Route::get('/forgot-password',        [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password',       [PasswordResetLinkController::class, 'store'])->name('password.email');
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

/* Halaman donasi versi publik (tanpa login) */
Route::view('/donasi', 'donasipage')->name('donasi.index');

/* Jika guest akses URL lama fitur donasi → paksa login */
Route::get('/donasi/{path}', function () {
    return redirect()->route('login')->with('warning','Silakan login untuk mengakses fitur donasi.');
})->where('path','uang|barang|validasi-donasi|laporanpage');

/* Contoh resource */
Route::resource('images', App\Http\Controllers\ImageController::class)
    ->only(['index','store','destroy'])
    ->names(['index'=>'images.index','store'=>'images.store','destroy'=>'images.destroy']);

/* Profil sederhana (opsional) */
Route::middleware('auth')->get('/profile', fn() => 'Ini adalah halaman profil pengguna.')->name('profile.edit');


/* =========================
|  DONOR (Auth only)
========================= */
Route::middleware(['auth'])
    ->prefix('member/donasi')->as('donor.')
    ->group(function () {

        // UI pakai view yang sudah ada
        Route::view('/uang',     'donasi.form-uang')->name('money.create');
        Route::view('/barang',   'donasi.form-barang')->name('goods.create');
        Route::view('/validasi', 'donasi.validasipage')->name('proof.create');
        Route::view('/riwayat',  'donasi.laporanpage')->name('history');

        // Store Donasi Uang
        Route::post('/uang', function (Request $r) {
            $raw = preg_replace('/[^\d]/', '', (string) $r->input('jumlah','0'));
            $jumlah = $raw === '' ? 0 : (int) $raw;

            $r->validate([
                'metode_pembayaran' => 'required|string', // transfer/qris/cash/ewallet
                'jumlah'            => 'required',
                'catatan'           => 'nullable|string',
            ]);

            DB::table('donations')->insert([
                'user_id'           => auth()->id(),
                'jumlah'            => $jumlah,
                'metode_pembayaran' => $r->metode_pembayaran,
                'status'            => 'pending',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            return redirect()->route('donor.history')->with('success','Donasi uang terkirim. Menunggu verifikasi.');
        })->name('money.store');

        // Store Donasi Barang
        Route::post('/barang', function (Request $r) {
            $r->validate([
                'jenis_barang'  => 'required|string',
                'jumlah_barang' => 'required|numeric|min:1',
                'keterangan'    => 'nullable|string',
            ]);

            $donationId = DB::table('donations')->insertGetId([
                'user_id'           => auth()->id(),
                'jumlah'            => 0,
                'metode_pembayaran' => 'barang',
                'status'            => 'pending',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            if (Schema::hasTable('donation_goods')) {
                DB::table('donation_goods')->insert([
                    'donation_id' => $donationId,
                    'jenis'       => $r->jenis_barang,
                    'jumlah'      => (int) $r->jumlah_barang,
                    'keterangan'  => $r->input('keterangan'),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            return redirect()->route('donor.history')->with('success','Donasi barang terkirim. Menunggu verifikasi.');
        })->name('goods.store');

        // Store Validasi (upload bukti)
        Route::post('/validasi', function (Request $r) {
            $r->validate([
                'bukti'        => 'required|image|max:4096',
                'nominal'      => 'nullable',
                'jenis_donasi' => 'nullable|string',
            ]);

            $path = $r->file('bukti')->store('bukti-transfer','public');

            $raw = preg_replace('/[^\d]/', '', (string) $r->input('nominal','0'));
            $jumlah = $raw === '' ? 0 : (int) $raw;

            DB::table('donations')->insert([
                'user_id'           => auth()->id(),
                'jumlah'            => $jumlah,
                'metode_pembayaran' => $r->input('jenis_donasi','transfer'),
                'bukti_transfer'    => $path,
                'status'            => 'pending',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            return redirect()->route('donor.history')->with('success','Bukti donasi terkirim. Menunggu verifikasi.');
        })->name('proof.store');
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
        Route::get('/users',         [UserController::class, 'index'])->name('users.index');
        Route::view('/users/create', 'admin.users.create')->name('users.create');

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
            } elseif (Schema::hasColumn('users','role')) {
                $user->role = $r->role;
                $user->save();
            }

            return redirect()->route('admin.users.index')->with('success','Pengguna dibuat.');
        })->name('users.store');

        /* ===== Donations (pantau) ===== */
        Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');

        // (opsional) halaman create manual untuk admin
        Route::view('/donations/create',       'admin.donations.create')->name('donations.create');
        Route::view('/donations/create-money', 'admin.donations.create-money')->name('donations.create-money');
        Route::view('/donations/create-goods', 'admin.donations.create-goods')->name('donations.create-goods');

        // Simpan donasi oleh admin (langsung verified)
        Route::post('/donations', function (Request $r) {
            $rawJumlah = preg_replace('/[^\d]/', '', (string) $r->input('jumlah', '0'));
            $jumlah = $rawJumlah === '' ? 0 : (int) $rawJumlah;

            $r->validate([
                'metode_pembayaran' => 'required|string',
                'email'             => 'nullable|email',
                'catatan'           => 'nullable|string',
            ]);

            return DB::transaction(function () use ($r, $jumlah) {
                $userId = null;
                if ($r->filled('email')) {
                    $user = \App\Models\User::firstOrCreate(
                        ['email' => $r->email],
                        ['name' => trim(($r->first_name.' '.$r->last_name) ?: $r->email),
                         'password' => bcrypt(Str::random(12))]
                    );
                    if (method_exists($user, 'assignRole')) { $user->assignRole('donatur'); }
                    elseif (Schema::hasColumn('users','role') && !$user->role) { $user->role = 'donatur'; $user->save(); }
                    $userId = $user->id;
                }

                $donationId = DB::table('donations')->insertGetId([
                    'user_id'           => $userId,
                    'jumlah'            => $jumlah,
                    'metode_pembayaran' => $r->metode_pembayaran,
                    'bukti_transfer'    => null,
                    'status'            => 'verified',
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);

                if ($r->filled('catatan') && Schema::hasTable('donation_verifications')) {
                    DB::table('donation_verifications')->insert([
                        // ganti 'donasi_id' -> 'donation_id' jika itu kolom FK di DB Anda
                        'donasi_id'   => $donationId,
                        'admin_id'    => auth()->id(),
                        'status'      => 'verified',
                        'catatan'     => $r->catatan,
                        'verified_at' => now(),
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);
                }

                return redirect()->route('admin.donations.index')->with('success','Donasi disimpan dan diverifikasi.');
            });
        })->name('donations.store');

        // Detail / verifikasi cepat / hapus
        Route::get('/donations/{donation}',          [DonationController::class, 'show'])->name('donations.show');
        Route::patch('/donations/{donation}/verify', [DonationController::class, 'verify'])->name('donations.verify');
        Route::delete('/donations/{donation}',       [DonationController::class, 'destroy'])->name('donations.destroy');

        // === Ubah status cepat (pending/verified/rejected)
        Route::patch('/donations/{donation}/status', [DonationController::class, 'setStatus'])->name('donations.status');

        /* ===== Reports ===== */
        Route::get('/reports/donation',  [ReportController::class, 'donation'])->name('reports.donation');
        Route::view('/reports/financial','admin.reports.financial')->name('reports.financial');

        Route::patch('/donations/{donation}/status', [DonationController::class, 'setStatus'])
    ->name('donations.status');

    });
