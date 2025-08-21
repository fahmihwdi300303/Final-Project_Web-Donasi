# Fitur Upload dan Menampilkan Gambar - Website Donasi

## Overview

Fitur ini menerapkan **Clean Architecture** dan **prinsip SOLID** untuk mengelola upload dan menampilkan gambar pada website donasi. Kode dipisahkan sesuai layer dan menerapkan dependency injection untuk maintainability yang tinggi.

## Struktur Clean Architecture

### 1. Entity Layer
- **`app/Models/Image.php`** - Model entitas gambar dengan relasi dan accessor

### 2. Use Case Layer  
- **`app/Services/ImageService.php`** - Business logic untuk upload dan pengelolaan gambar

### 3. Interface Adapter Layer
- **`app/Http/Controllers/ImageController.php`** - Controller untuk handle request/response
- **`app/Http/Requests/StoreImageRequest.php`** - Validasi input upload gambar
- **`app/Repositories/ImageRepositoryInterface.php`** - Interface repository
- **`app/Repositories/EloquentImageRepository.php`** - Implementasi repository dengan Eloquent

### 4. Framework Layer
- **`routes/web.php`** - Route untuk image management
- **`resources/views/image/`** - View templates (upload, show, index)
- **`database/migrations/`** - Migration untuk tabel images
- **`app/Providers/ImageServiceProvider.php`** - Service provider untuk DI

## Penerapan Prinsip SOLID

### 1. Single Responsibility Principle (SRP)
- **Controller**: Hanya mengatur request/response
- **Service**: Hanya business logic gambar
- **Repository**: Hanya operasi database
- **Model**: Hanya representasi data

### 2. Open/Closed Principle (OCP)
- Bisa tambah tipe gambar baru tanpa ubah kode utama
- Bisa extend service dengan fitur baru
- Bisa tambah validasi rule baru

### 3. Liskov Substitution Principle (LSP)
- Semua implementasi repository interchangeable
- Bisa ganti implementasi tanpa mengubah kode lain

### 4. Interface Segregation Principle (ISP)
- Interface repository terpisah untuk operasi berbeda
- Request validation terpisah untuk upload

### 5. Dependency Inversion Principle (DIP)
- Controller bergantung pada service interface
- Service bergantung pada repository interface
- Tidak ada dependency pada implementasi konkret

## Setup dan Instalasi

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Buat Storage Link
```bash
php artisan storage:link
```

### 3. Pastikan Folder Storage Ada
```bash
mkdir -p storage/app/public/images
```

### 4. Set Permission (Linux/Mac)
```bash
chmod -R 775 storage
chmod -R 775 public/storage
```

## Penggunaan

### 1. Upload Gambar
- Akses: `GET /images/create`
- Upload file dengan form HTML
- Drag & drop support
- Preview gambar sebelum upload
- Validasi file type dan size

### 2. Lihat Daftar Gambar
- Akses: `GET /images`
- Tampilan gallery dengan hover effects
- Quick actions (view, download, delete)
- Responsive design

### 3. Lihat Detail Gambar
- Akses: `GET /images/{id}`
- Tampilan full image dengan metadata
- Informasi lengkap file
- Action buttons

### 4. Hapus Gambar
- Akses: `DELETE /images/{id}`
- Konfirmasi sebelum hapus
- Hapus file dari storage dan database

## Routes yang Tersedia

```php
// Resource routes untuk image management
Route::resource('images', ImageController::class);

// Routes yang dihasilkan:
// GET    /images              - index (daftar gambar)
// GET    /images/create       - create (form upload)
// POST   /images              - store (simpan upload)
// GET    /images/{id}         - show (detail gambar)
// DELETE /images/{id}         - destroy (hapus gambar)
```

## Konfigurasi

### 1. File Types yang Diizinkan
```php
// Di ImageService.php
protected $allowedMimeTypes = [
    'image/jpeg',
    'image/jpg', 
    'image/png',
    'image/gif',
    'image/webp'
];
```

### 2. Max File Size
```php
// Di ImageService.php
protected $maxFileSize = 5242880; // 5MB
```

### 3. Storage Path
```php
// Di ImageService.php
protected $storagePath = 'images';
```

## Fitur Keamanan

### 1. Validasi File
- Mime type validation
- File size validation
- File integrity check

### 2. Secure File Naming
- Unique filename dengan timestamp
- Random string untuk prevent collision
- Original name disimpan terpisah

### 3. Storage Security
- File disimpan di public storage
- Path tidak predictable
- Access control via web server

## Error Handling

### 1. Upload Errors
- File type not allowed
- File size too large
- Upload failed
- Storage error

### 2. Database Errors
- Connection failed
- Constraint violation
- Transaction rollback

### 3. File System Errors
- Disk full
- Permission denied
- File not found

## Testing

### 1. Unit Tests
```bash
# Test service layer
php artisan test --filter=ImageServiceTest

# Test repository layer  
php artisan test --filter=ImageRepositoryTest
```

### 2. Feature Tests
```bash
# Test upload functionality
php artisan test --filter=ImageUploadTest

# Test display functionality
php artisan test --filter=ImageDisplayTest
```

## Performance Optimization

### 1. Image Optimization
- Lazy loading pada gallery
- Responsive images
- Proper alt tags

### 2. Database Optimization
- Index pada kolom yang sering query
- Eager loading untuk relasi
- Pagination untuk large datasets

### 3. Storage Optimization
- File compression
- CDN integration (optional)
- Cache headers

## Troubleshooting

### 1. Upload Gagal
- Cek permission folder storage
- Cek disk space
- Cek file size limit di PHP config

### 2. Gambar Tidak Muncul
- Cek storage link sudah dibuat
- Cek file path di database
- Cek web server configuration

### 3. Permission Error
- Set proper permission pada storage folder
- Cek web server user permissions
- Restart web server jika perlu

## Extensibility

### 1. Tambah Image Processor
```php
// Buat interface baru
interface ImageProcessorInterface {
    public function resize($image, $width, $height);
    public function compress($image, $quality);
}

// Implement di service
class ImageService {
    public function __construct(
        ImageRepositoryInterface $repository,
        ImageProcessorInterface $processor
    ) {
        // ...
    }
}
```

### 2. Tambah Cloud Storage
```php
// Buat repository baru
class CloudImageRepository implements ImageRepositoryInterface {
    // Implement cloud storage logic
}

// Bind di service provider
$this->app->bind(ImageRepositoryInterface::class, CloudImageRepository::class);
```

### 3. Tambah Image Categories
```php
// Extend model
class Image extends Model {
    protected $fillable = [
        // ... existing fields
        'category',
        'tags'
    ];
}
```

## Best Practices

### 1. Code Organization
- Gunakan namespace yang konsisten
- Pisahkan concern sesuai layer
- Gunakan dependency injection

### 2. Error Handling
- Log semua error
- User-friendly error messages
- Graceful degradation

### 3. Security
- Validate semua input
- Sanitize file names
- Use CSRF protection

### 4. Performance
- Optimize database queries
- Use caching where appropriate
- Compress images

## Dependencies

- Laravel 10.x
- PHP 8.1+
- MySQL/PostgreSQL
- Web server (Apache/Nginx)

## License

MIT License - feel free to use and modify as needed.




