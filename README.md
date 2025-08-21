# Website Donasi LKSA Yatim Muhammadiyah Karangasem

Website donasi untuk Lembaga Kesejahteraan Sosial Anak (LKSA) Yatim Muhammadiyah Karangasem yang dibangun dengan Laravel dan menggunakan prinsip Clean Code.

## 🚀 Fitur Utama

### 1. Halaman About Us (`/about`)
- **Profil Panti Asuhan**: Sejarah, visi, dan misi LKSA
- **Anak Asuh**: Informasi tentang 129 anak asuh
- **Pimpinan**: Daftar kepemimpinan dari 1994 hingga sekarang
- **Misi dan Kaderisasi**: Program pembinaan dai Muhammadiyah
- **Kontak**: Alamat, telepon, email, dan website
- **Call to Action**: Ajakan untuk berdonasi

### 2. Form Donasi (`/donasi`)
- **Form Input**: Nama, email, WhatsApp, jenis donasi, nominal, catatan
- **Validasi Real-time**: Email, nomor telepon, dan nominal
- **Metode Pembayaran**: QRIS, Bank Mandiri, BCA, BNI, BRI
- **Responsive Design**: Optimal di desktop dan mobile

### 3. Validasi Donasi (`/validasi-donasi`)
- **Form Validasi**: Input data donatur dan upload bukti
- **File Upload**: Drag & drop atau klik untuk upload gambar
- **Validasi File**: Tipe gambar, ukuran maksimal 5MB
- **Status Tracking**: Menunggu, terverifikasi, ditolak

### 4. Laporan Keuangan (`/laporan`)
- **Tabel Donasi**: Daftar lengkap dengan filter bulan/tahun
- **Grafik Visual**: Chart donasi menggunakan Canvas API
- **Download CSV**: Export data untuk analisis
- **Statistik**: Total donasi, rata-rata, pertumbuhan

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 10
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Database**: MySQL (dengan Clean Architecture)
- **Styling**: Custom CSS (tanpa framework)
- **Charts**: Canvas API untuk grafik
- **File Upload**: HTML5 File API

## 📁 Struktur File

```
website-donasi/
├── app/
│   ├── Core/                    # Clean Architecture
│   │   ├── Contracts/          # Interfaces
│   │   ├── Domain/             # Entities
│   │   └── UseCases/           # Business Logic
│   ├── Infrastructure/         # External concerns
│   └── Http/                   # Controllers & Requests
├── resources/views/            # Blade Templates
│   ├── aboutus.blade.php       # About Us page
│   ├── donasipage.blade.php    # Donation form
│   ├── validasipage.blade.php  # Validation page
│   └── laporanpage.blade.php   # Report page
├── public/
│   ├── css/style.css          # Main stylesheet
│   └── js/script.js           # Main JavaScript
└── routes/web.php             # Route definitions
```

## 🎨 Desain & UI/UX

### Color Scheme
- **Primary Blue**: `#0066cc` (Header, buttons, links)
- **Dark Blue**: `#1e3a8a` (Titles, emphasis)
- **Light Blue**: `#3b82f6` (Accents, hover states)
- **Gray Scale**: `#f8f9fa` to `#374151` (Backgrounds, text)
- **Success Green**: `#10b981` (Success states)
- **Error Red**: `#ef4444` (Error states)

### Typography
- **Font Family**: Segoe UI, Tahoma, Geneva, Verdana, sans-serif
- **Heading Sizes**: 1.5rem - 2.5rem
- **Body Text**: 1rem - 1.1rem
- **Small Text**: 0.8rem - 0.9rem

### Responsive Breakpoints
- **Mobile**: < 480px
- **Tablet**: 480px - 768px
- **Desktop**: > 768px

## 🔧 Instalasi & Setup

### Prerequisites
- PHP 8.1+
- Composer
- MySQL 8.0+
- Node.js (untuk asset compilation)

### Installation Steps

1. **Clone Repository**
   ```bash
   git clone [repository-url]
   cd website-donasi
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   ```bash
   # Edit .env file
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=website_donasi
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

6. **Start Development Server**
   ```bash
   php artisan serve
   ```

## 📱 Halaman & Routes

| Route | Method | Description |
|-------|--------|-------------|
| `/` | GET | Homepage |
| `/about` | GET | About Us page |
| `/donasi` | GET | Donation form |
| `/validasi-donasi` | GET | Donation validation |
| `/laporan` | GET | Financial report |
| `/kegiatan` | GET | Activities page |

## 🎯 Fitur JavaScript

### Form Validation
- **Real-time validation** untuk semua input fields
- **Email validation** dengan regex pattern
- **Phone validation** untuk format Indonesia
- **Amount validation** dengan currency formatting
- **File validation** untuk upload bukti donasi

### Interactive Features
- **Drag & Drop** file upload
- **Dynamic table** rendering dengan filter
- **Canvas chart** untuk visualisasi data
- **CSV export** untuk laporan
- **Notification system** untuk user feedback

### Responsive Behavior
- **Mobile-first** approach
- **Touch-friendly** interactions
- **Adaptive layouts** untuk semua screen sizes
- **Performance optimized** untuk mobile devices

## 🎨 CSS Architecture

### Organization
- **Reset & Base**: Global styles dan typography
- **Layout**: Header, footer, containers
- **Components**: Buttons, forms, tables, cards
- **Pages**: Specific styles untuk setiap halaman
- **Utilities**: Helper classes dan animations
- **Responsive**: Media queries dan mobile styles

### Key Features
- **CSS Grid & Flexbox** untuk layouts
- **CSS Custom Properties** untuk theming
- **Smooth animations** dan transitions
- **Accessibility** considerations
- **Cross-browser** compatibility

## 🔒 Security Features

### Form Security
- **CSRF Protection** dengan Laravel
- **Input Sanitization** untuk semua user inputs
- **File Upload Security** dengan validasi tipe dan ukuran
- **XSS Prevention** dengan proper escaping

### Data Protection
- **Secure Headers** dengan Laravel middleware
- **SQL Injection Prevention** dengan Eloquent ORM
- **Session Security** dengan proper configuration

## 📊 Database Schema

### Donations Table
```sql
CREATE TABLE donations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    whatsapp VARCHAR(20) NOT NULL,
    donation_type ENUM('pendidikan', 'kesehatan', 'makanan', 'pakaian', 'infrastruktur', 'lainnya'),
    amount DECIMAL(15,2) NOT NULL,
    notes TEXT,
    payment_method ENUM('qris', 'mandiri', 'bca', 'bni', 'bri'),
    status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    receipt_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## 🚀 Deployment

### Production Setup
1. **Environment Configuration**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com
   ```

2. **Asset Optimization**
   ```bash
   npm run build
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Server Requirements**
   - PHP 8.1+
   - MySQL 8.0+
   - Nginx/Apache
   - SSL Certificate

## 🤝 Contributing

### Development Workflow
1. Fork repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

### Code Standards
- **PHP**: PSR-12 coding standards
- **JavaScript**: ESLint configuration
- **CSS**: BEM methodology
- **Git**: Conventional commits

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Support

Untuk pertanyaan dan dukungan:
- **Email**: LKSAMKarangasem@gmail.com
- **Phone**: (+62)895-500-1223
- **Website**: WWW.LKSAKarangasem.id

---

**Dibuat dengan ❤️ untuk LKSA Yatim Muhammadiyah Karangasem**
