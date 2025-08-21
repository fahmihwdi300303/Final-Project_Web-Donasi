# Halaman Donasi - LKSA Yatim Muhammadiyah Karangasem

## Overview
Implementasi halaman donasi yang menampilkan campaign donasi dengan desain responsif dan interaktif berdasarkan deskripsi desain Figma.

## Struktur File

### HTML/Blade Template
- `resources/views/donasipage.blade.php` - Template utama halaman donasi

### CSS
- `public/css/style.css` - CSS global (sudah ada)
- `public/css/donasi.css` - CSS khusus halaman donasi

### JavaScript
- `public/js/script.js` - JavaScript global (sudah ada)
- `public/js/donasi.js` - JavaScript khusus halaman donasi

## Fitur Implementasi

### 1. Header Section
**Komponen:**
- Logo LKSA Yatim dengan placeholder image
- Navigation menu dengan 4 link: Beranda, Kegiatan, About, Donasi
- Active state untuk link Donasi
- Responsive design

**Styling:**
- Background: Dark blue (#1e3a8a)
- Logo: Circular dengan background blue
- Navigation: White text dengan hover effects
- Sticky positioning

### 2. Hero Banner Section
**Komponen:**
- Background gradient dengan overlay
- Judul utama: "Donasikan Segera Rezekimu Ke LKSA Yatim Muhammadiyah Karangasem"
- Search input dengan button
- Responsive design

**Styling:**
- Background: Linear gradient (pink to brown to cream)
- Overlay: Semi-transparent black
- Text: White dengan text shadow
- Search: White background dengan rounded corners

### 3. Campaign Section
**Komponen:**
- Section header: "Campaign Donasi" dan "Kegiatan Panti Asuhan"
- Grid 6 campaign items (2x3 layout)
- Hover effects dengan overlay
- Read more button

**Campaign Items:**
1. Kegiatan Seni & Kreativitas
2. Program Peternakan
3. Pendidikan Agama
4. Pembangunan Masjid
5. Pendidikan Formal
6. Kegiatan Bersama

**Styling:**
- Grid layout dengan auto-fit
- Card design dengan shadow
- Hover animations
- Image overlay dengan gradient

### 4. Footer Section
**Komponen:**
- Logo FH dengan icon
- Social media icons (Facebook, Instagram, YouTube, WhatsApp)
- Copyright text

**Styling:**
- Dark blue background
- Centered layout
- Social icons dengan hover effects

## JavaScript Functionality

### 1. Search Functionality
```javascript
// Real-time search dengan debounce
initSearchFunctionality()
performSearch(query)
```

**Fitur:**
- Search berdasarkan judul dan deskripsi campaign
- Real-time filtering dengan debounce 300ms
- Keyboard support (Enter key)
- Notification jika tidak ada hasil

### 2. Campaign Interactions
```javascript
// Click handler dan hover effects
initCampaignInteractions()
showCampaignDetails(title, item)
```

**Fitur:**
- Click untuk membuka modal detail
- Hover effects dengan transform
- Modal dengan statistik campaign
- Donate button dengan redirect

### 3. Loading Animations
```javascript
// Intersection Observer untuk animasi scroll
initLoadingAnimations()
```

**Fitur:**
- Fade-in animation saat scroll
- Staggered animation untuk campaign items
- Smooth transitions

### 4. Header Scroll Effect
```javascript
// Background blur effect saat scroll
initHeaderScrollEffect()
```

**Fitur:**
- Background transparency saat scroll
- Backdrop blur effect
- Smooth transitions

## Responsive Design

### Breakpoints
- **Desktop**: `> 768px`
- **Tablet**: `768px - 480px`
- **Mobile**: `< 480px`

### Mobile Adaptations
- Hero title: Reduced font size
- Search: Stacked layout
- Campaign grid: Single column
- Modal: Full screen with adjusted padding
- Campaign overlay: Always visible

## Color Scheme

### Primary Colors
- **Dark Blue**: `#1e3a8a` (Header, buttons, text)
- **Light Blue**: `#3b82f6` (Hover states)
- **White**: `#ffffff` (Background, text)

### Gradient Colors
- **Hero Background**: `linear-gradient(135deg, #ff6b9d 0%, #c44569 50%, #f7f1e3 100%)`
- **Campaign Overlay**: `linear-gradient(transparent, rgba(0, 0, 0, 0.8))`

### Accent Colors
- **Success**: `#10b981` (Notifications)
- **Error**: `#ef4444` (Error notifications)
- **Gray**: `#6b7280` (Subtitle text)

## Typography

### Font Family
- **Primary**: Inter (Google Fonts)
- **Fallback**: Segoe UI, Tahoma, Geneva, Verdana, sans-serif

### Font Weights
- **Light**: 300
- **Regular**: 400
- **Medium**: 500
- **Semi-bold**: 600
- **Bold**: 700

### Font Sizes
- **Hero Title**: 2.5rem (Desktop), 2rem (Tablet), 1.5rem (Mobile)
- **Section Title**: 2.5rem (Desktop), 2rem (Tablet), 1.8rem (Mobile)
- **Campaign Title**: 1.2rem
- **Body Text**: 1rem

## Animation & Transitions

### Hover Effects
- Campaign items: `translateY(-5px)` dengan shadow
- Images: `scale(1.05)`
- Overlay: `translateY(0)` dari `translateY(100%)`
- Buttons: Background color change

### Loading Animations
- Campaign items: Fade-in dengan stagger
- Modal: Scale dan opacity transition
- Notifications: Slide-in dari kanan

### Transitions
- All interactive elements: `0.3s ease`
- Loading animations: `0.6s ease`
- Modal animations: `0.3s ease`

## Accessibility Features

### WCAG 2.1 Compliance
- Semantic HTML structure
- Proper heading hierarchy
- Alt text untuk semua images
- Keyboard navigation support
- Focus indicators

### Screen Reader Support
- Proper ARIA labels
- Descriptive alt text
- Logical tab order
- Announcement untuk dynamic content

## Performance Optimization

### CSS Optimization
- Efficient selectors
- Hardware-accelerated animations
- Minimal repaints
- Optimized media queries

### JavaScript Optimization
- Event delegation
- Debounced search
- Intersection Observer untuk lazy loading
- Efficient DOM manipulation

### Asset Optimization
- Placeholder images dengan optimal size
- CDN untuk external libraries
- Minimal HTTP requests

## Browser Support

### Supported Browsers
- **Chrome**: 90+
- **Firefox**: 88+
- **Safari**: 14+
- **Edge**: 90+

### Features Used
- CSS Grid
- Flexbox
- Intersection Observer API
- ES6+ JavaScript
- CSS Custom Properties

## Integration dengan Laravel

### Blade Template Features
- Asset helper: `{{ asset('css/donasi.css') }}`
- CSRF protection ready
- Route naming support
- Conditional rendering

### Asset Loading
```html
<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/donasi.css') }}">

<!-- JavaScript -->
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/donasi.js') }}"></script>
```

## Customization Guide

### Mengubah Warna
1. Edit CSS variables di `public/css/donasi.css`
2. Update gradient colors di `.hero-banner`
3. Modify button colors di `.search-btn` dan `.read-more-btn`

### Menambah Campaign
1. Duplicate `.campaign-item` di HTML
2. Update image src dan alt text
3. Modify title dan description
4. Update JavaScript jika perlu custom behavior

### Mengubah Layout
1. Modify grid columns di `.campaign-grid`
2. Adjust breakpoints di media queries
3. Update container max-width jika perlu

## Testing Checklist

### Functionality Testing
- [ ] Search functionality works
- [ ] Campaign modal opens correctly
- [ ] Hover effects trigger properly
- [ ] Responsive design works on all devices
- [ ] Loading animations play smoothly

### Accessibility Testing
- [ ] Keyboard navigation works
- [ ] Screen reader compatibility
- [ ] Color contrast meets WCAG standards
- [ ] Focus indicators are visible

### Performance Testing
- [ ] Page loads under 3 seconds
- [ ] Smooth animations (60fps)
- [ ] No layout shifts
- [ ] Efficient memory usage

## Deployment Notes

### Pre-deployment Checklist
- [ ] Replace placeholder images dengan real images
- [ ] Update campaign data dengan real content
- [ ] Test semua functionality
- [ ] Optimize images untuk web
- [ ] Minify CSS dan JavaScript

### Production Considerations
- [ ] Enable asset caching
- [ ] Set up CDN untuk images
- [ ] Configure error handling
- [ ] Monitor performance metrics
- [ ] Set up analytics tracking

## Future Enhancements

### Planned Features
- **Pagination**: Load more campaigns
- **Filtering**: Filter by category
- **Sorting**: Sort by date, amount, etc.
- **Real-time updates**: Live campaign progress
- **Social sharing**: Share campaigns

### Technical Improvements
- **Lazy loading**: Images load on scroll
- **Service Worker**: Offline support
- **PWA features**: Installable app
- **Advanced animations**: GSAP integration
- **State management**: Vue.js atau React integration

---

**Note**: Implementasi ini menggunakan placeholder URLs untuk gambar. Ganti dengan URL gambar yang sebenarnya sebelum deployment ke production.
