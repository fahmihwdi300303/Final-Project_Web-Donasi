# Sistem Multi Level User Authentication - Panti Asuhan Kasih

## Deskripsi
Sistem Multi Level User Authentication di Laravel dengan 3 role: Admin, Donatur, dan Pengguna Umum (Guest). Sistem ini dirancang untuk mengelola donasi panti asuhan dengan akses yang berbeda untuk setiap role.

## Fitur Utama

### 1. Multi-Level Authentication
- **Admin**: Akses penuh ke semua fitur
- **Donatur**: Login untuk donasi dan melihat laporan
- **Guest/User**: Hanya melihat informasi umum tanpa login

### 2. Role-Based Access Control
- Middleware `CheckRole` untuk membatasi akses
- Redirect otomatis berdasarkan role setelah login
- Navbar yang dinamis sesuai role user

### 3. Dashboard Berbeda untuk Setiap Role
- **Admin Dashboard**: Statistik, manajemen user, laporan
- **Donatur Dashboard**: Form donasi, validasi, laporan pribadi
- **Guest**: Informasi umum panti asuhan

## Struktur Database

### Tabel Users
```sql
- id (Primary Key)
- name (VARCHAR)
- email (VARCHAR, UNIQUE)
- password (VARCHAR)
- role (ENUM: 'admin', 'donatur', 'user')
- email_verified_at (TIMESTAMP)
- remember_token (VARCHAR)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

## Instalasi dan Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd website-donasi
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=website_donasi
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migration dan Seeding
```bash
php artisan migrate:fresh --seed
```

## User Default

Setelah menjalankan seeder, tersedia user default:

### Admin
- Email: `admin@pantikasih.org`
- Password: `admin123`
- Role: `admin`

### Donatur
- Email: `john@example.com`
- Password: `donatur123`
- Role: `donatur`

- Email: `jane@example.com`
- Password: `donatur123`
- Role: `donatur`

### User Regular
- Email: `bob@example.com`
- Password: `user123`
- Role: `user`

## Struktur File

### Controllers
```
app/Http/Controllers/
├── AuthController.php          # Login, Register, Logout
├── AdminController.php         # Dashboard dan fitur admin
├── DonaturController.php       # Dashboard dan fitur donatur
└── GuestController.php         # Halaman untuk guest
```

### Middleware
```
app/Http/Middleware/
└── CheckRole.php              # Middleware untuk role-based access
```

### Models
```
app/Models/
└── User.php                   # Model User dengan role methods
```

### Views
```
resources/views/
├── layouts/
│   └── app.blade.php          # Layout utama dengan navbar dinamis
├── auth/
│   ├── login.blade.php        # Halaman login
│   └── register.blade.php     # Halaman register
├── admin/
│   └── dashboard.blade.php    # Dashboard admin
├── donatur/
│   ├── dashboard.blade.php    # Dashboard donatur
│   └── donation-form.blade.php # Form donasi
└── guest/
    └── homepage.blade.php     # Halaman beranda
```

## Routes

### Guest Routes (Public)
```php
Route::get('/', [GuestController::class, 'homepage']);
Route::get('/profile', [GuestController::class, 'profile']);
Route::get('/activities', [GuestController::class, 'activities']);
Route::get('/about', [GuestController::class, 'aboutUs']);
Route::get('/contact', [GuestController::class, 'contact']);
```

### Authentication Routes
```php
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
```

### Admin Routes
```php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/users', [AdminController::class, 'userManagement']);
    Route::get('/activity', [AdminController::class, 'activity']);
    Route::get('/donations', [AdminController::class, 'donationManagement']);
    Route::get('/donation-report', [AdminController::class, 'donationReport']);
    Route::get('/financial-report', [AdminController::class, 'financialReport']);
});
```

### Donatur Routes
```php
Route::middleware(['auth', 'role:donatur'])->prefix('donatur')->name('donatur.')->group(function () {
    Route::get('/dashboard', [DonaturController::class, 'dashboard']);
    Route::get('/donation-form', [DonaturController::class, 'donationForm']);
    Route::post('/donation-form', [DonaturController::class, 'submitDonation']);
    Route::get('/donation-validation', [DonaturController::class, 'donationValidation']);
    Route::get('/donation-report', [DonaturController::class, 'donationReport']);
    Route::get('/my-donations', [DonaturController::class, 'myDonations']);
});
```

## Fitur Per Role

### Admin
- **Dashboard**: Statistik user, donatur, admin
- **User Management**: Kelola user, ubah role, hapus user
- **Activity Log**: Monitor aktivitas user
- **Donation Management**: Kelola donasi masuk
- **Donation Report**: Laporan donasi per periode
- **Financial Report**: Laporan keuangan lengkap
- **About Us Management**: Kelola informasi panti

### Donatur
- **Dashboard**: Statistik donasi pribadi
- **Form Donasi**: Submit donasi uang atau barang
- **Validasi Donasi**: Validasi donasi dari donatur lain
- **Laporan Donasi**: Lihat laporan donasi terverifikasi
- **My Donations**: Riwayat donasi pribadi

### Guest/User
- **Homepage**: Informasi umum panti asuhan
- **Profile**: Profil panti asuhan
- **Activities**: Kegiatan panti asuhan
- **About Us**: Tentang panti asuhan
- **Contact**: Informasi kontak

## Middleware Role

### CheckRole Middleware
```php
public function handle(Request $request, Closure $next, string $role): Response
{
    if (!auth()->check()) {
        return redirect('/login');
    }

    if (!auth()->user()->hasRole($role)) {
        abort(403, 'Unauthorized access.');
    }

    return $next($request);
}
```

### Penggunaan
```php
Route::middleware('role:admin')->group(function () {
    // Routes untuk admin
});
```

## Model User Methods

### Role Checking Methods
```php
public function isAdmin(): bool
public function isDonatur(): bool
public function isUser(): bool
public function hasRole(string $role): bool
```

## Frontend Features

### Responsive Design
- Bootstrap 5.3.0
- Font Awesome 6.0.0
- Mobile-first approach

### JavaScript Features
- Form validation
- Dynamic field toggling
- Auto-hide alerts
- Password confirmation validation

### UI/UX Features
- Gradient backgrounds
- Card-based layouts
- Role badges
- Interactive navigation
- Success/error notifications

## Keamanan

### Authentication
- Laravel built-in authentication
- Password hashing
- CSRF protection
- Session management

### Authorization
- Role-based access control
- Middleware protection
- Route-level security

### Validation
- Server-side validation
- Client-side validation
- Input sanitization

## Testing

### Manual Testing
1. Login sebagai admin: `admin@pantikasih.org` / `admin123`
2. Login sebagai donatur: `john@example.com` / `donatur123`
3. Test akses halaman sesuai role
4. Test form donasi
5. Test validasi donasi

### Automated Testing
```bash
php artisan test
```

## Deployment

### Production Setup
1. Set `APP_ENV=production` di `.env`
2. Set `APP_DEBUG=false` di `.env`
3. Generate application key
4. Configure database
5. Run migrations
6. Set proper file permissions

### Server Requirements
- PHP >= 8.1
- MySQL >= 5.7
- Composer
- Node.js (untuk asset compilation)

## Troubleshooting

### Common Issues
1. **Migration Error**: Pastikan database sudah dibuat
2. **Permission Error**: Set proper file permissions
3. **Route Not Found**: Clear route cache dengan `php artisan route:clear`
4. **View Not Found**: Clear view cache dengan `php artisan view:clear`

### Cache Clearing
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## License

This project is licensed under the MIT License.

## Support

Untuk dukungan teknis, silakan hubungi:
- Email: support@pantikasih.org
- Website: www.pantikasih.org
