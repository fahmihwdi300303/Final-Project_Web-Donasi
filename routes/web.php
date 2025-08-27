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

/* Halaman donasi versi publik (tanpa login) */
Route::view('/donasi',                  'donasipage')->name('donasi.index');
// Route::view('/donasi/uang',            'donasi.form-uang')->name('donasi.uang');
// Route::view('/donasi/barang',          'donasi.form-barang')->name('donasi.barang');
// Route::view('/donasi/validasi-donasi', 'donasi.validasipage')->name('donasi.validasi');
// Route::view('/donasi/laporanpage',     'donasi.laporanpage')->name('donasi.laporan');

// Jika guest mencoba akses URL lama /donasi/uang|barang|validasi-donasi|laporanpage → arahkan ke login
Route::get('/donasi/{path}', function () {
    return redirect()->route('login')->with('warning','Silakan login untuk mengakses fitur donasi.');
})->where('path','uang|barang|validasi-donasi|laporanpage');

/* Contoh resource */
Route::resource('images', App\Http\Controllers\ImageController::class)
    ->only(['index','store','destroy'])
    ->names(['index'=>'images.index','store'=>'images.store','destroy'=>'images.destroy']);

/* Profil sederhana */
Route::middleware('auth')->get('/profile', fn() => 'Ini adalah halaman profil pengguna.')->name('profile.edit');


/* =========================
|  DONOR (Auth only)
|  Semua user yang login otomatis dianggap "donatur".
|  Gunakan prefix berbeda agar tidak bentrok dengan halaman publik.
========================= */
Route::middleware(['auth'])
    ->prefix('member/donasi')->as('donor.')
    ->group(function () {
        // Tampilkan UI yang sama, tapi berada di area member
        Route::view('/uang',   'donasi.form-uang')->name('money.create');
        Route::view('/barang', 'donasi.form-barang')->name('goods.create');
        Route::view('/validasi','donasi.validasipage')->name('proof.create');
        Route::view('/riwayat','donasi.laporanpage')->name('history');

        // (opsional) endpoint penyimpanan; sementara disiapkan minimal
        Route::post('/uang', function (Request $r) {
            $raw = preg_replace('/[^\d]/', '', (string) $r->input('jumlah','0'));
            $jumlah = $raw === '' ? 0 : (int) $raw;

            $r->validate([
                'metode_pembayaran' => 'required|string',
                'jumlah'            => 'nullable',
            ]);

            DB::table('donations')->insert([
                'user_id'           => auth()->id(),
                'jumlah'            => $jumlah,
                'metode_pembayaran' => $r->metode_pembayaran,
                'status'            => 'pending',      // admin yang verifikasi
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            return back()->with('success','Donasi uang terkirim. Menunggu verifikasi.');
        })->name('money.store');

        Route::post('/barang', function (Request $r) {
            // Simpan sebagai donasi barang (sesuaikan kolom sesuai skema tabelmu)
            DB::table('donations')->insert([
                'user_id'           => auth()->id(),
                'jumlah'            => 0,
                'metode_pembayaran' => 'barang',
                'status'            => 'pending',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
            return back()->with('success','Donasi barang terkirim. Menunggu verifikasi.');
        })->name('goods.store');

        Route::post('/validasi', function (Request $r) {
            // Tempat upload bukti; sesuaikan storage & tabel bila sudah ada
            return back()->with('success','Bukti donasi terkirim.');
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
            } elseif (Schema::hasColumn('users','role')) {
                $user->role = $r->role;
                $user->save();
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
            $rawJumlah = preg_replace('/[^\d]/', '', (string) $r->input('jumlah', '0'));
            $jumlah = $rawJumlah === '' ? 0 : (int) $rawJumlah;

            $r->validate([
                'metode_pembayaran' => 'required|string',  // qris/transfer/cash/barang
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

                $donation = \App\Models\Donation::create([
                    'user_id'           => $userId,
                    'jumlah'            => $jumlah,
                    'metode_pembayaran' => $r->metode_pembayaran,
                    'bukti_transfer'    => null,
                    'status'            => 'verified',
                ]);

                if ($r->filled('catatan') && Schema::hasTable('donation_verifications')) {
                    DB::table('donation_verifications')->insert([
                        // ganti 'donasi_id' menjadi 'donation_id' jika itu nama kolom FK di tabelmu
                        'donasi_id'   => $donation->id,
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

        /* ===== Reports ===== */
        Route::view('/reports/donation',  'admin.reports.donation')->name('reports.donation');
        Route::view('/reports/financial', 'admin.reports.financial')->name('reports.financial');
    });
