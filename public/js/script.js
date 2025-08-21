/**
 * Main JavaScript file for LKSA Yatim Muhammadiyah Karangasem Website
 * Handles form validation, table filtering, and chart rendering
 */

// ===== GLOBAL VARIABLES =====
let currentDonations = [];
let donationChart = null;

// ===== UTILITY FUNCTIONS =====
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Style the notification
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 2rem;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        ${type === 'success' ? 'background: #10b981;' : 'background: #ef4444;'}
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// ===== FORM VALIDATION =====
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function validatePhone(phone) {
    const phoneRegex = /^(\+62|62|0)8[1-9][0-9]{6,9}$/;
    return phoneRegex.test(phone);
}

function validateAmount(amount) {
    return amount > 0 && !isNaN(amount);
}

function showFieldError(field, message) {
    const errorElement = field.parentNode.querySelector('.field-error') || 
                        document.createElement('div');
    errorElement.className = 'field-error';
    errorElement.textContent = message;
    errorElement.style.cssText = `
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    `;
    
    if (!field.parentNode.querySelector('.field-error')) {
        field.parentNode.appendChild(errorElement);
    }
    
    field.style.borderColor = '#ef4444';
}

function clearFieldError(field) {
    const errorElement = field.parentNode.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
    field.style.borderColor = '#e5e7eb';
}

// ===== DONATION FORM HANDLING =====
function initializeDonationForm() {
    const form = document.getElementById('donationForm');
    if (!form) return;
    
    // Real-time validation
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', () => validateField(input));
        input.addEventListener('input', () => clearFieldError(input));
    });
    
    // Form submission
    form.addEventListener('submit', handleDonationSubmit);
    
    // Amount formatting
    const amountInput = document.getElementById('amount');
    if (amountInput) {
        amountInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/[^\d]/g, '');
            if (value) {
                e.target.value = parseInt(value).toLocaleString('id-ID');
            }
        });
    }
}

function validateField(field) {
    const value = field.value.trim();
    
    switch (field.name) {
        case 'firstName':
        case 'lastName':
            if (value.length < 2) {
                showFieldError(field, 'Nama harus minimal 2 karakter');
                return false;
            }
            break;
            
        case 'email':
            if (!validateEmail(value)) {
                showFieldError(field, 'Format email tidak valid');
                return false;
            }
            break;
            
        case 'whatsapp':
            if (!validatePhone(value)) {
                showFieldError(field, 'Format nomor WhatsApp tidak valid');
                return false;
            }
            break;
            
        case 'donationType':
            if (!value) {
                showFieldError(field, 'Pilih jenis donasi');
                return false;
            }
            break;
            
        case 'amount':
            const amount = parseInt(value.replace(/[^\d]/g, ''));
            if (!validateAmount(amount)) {
                showFieldError(field, 'Nominal harus lebih dari 0');
                return false;
            }
            break;
            
        case 'paymentMethod':
            if (!value) {
                showFieldError(field, 'Pilih metode pembayaran');
                return false;
            }
            break;
    }
    
    clearFieldError(field);
    return true;
}

function handleDonationSubmit(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    // Validate all fields
    let isValid = true;
    const fields = form.querySelectorAll('input, select, textarea');
    
    fields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    if (!isValid) {
        showNotification('Mohon perbaiki kesalahan pada form', 'error');
        return;
    }
    
    // Format amount
    data.amount = parseInt(data.amount.replace(/[^\d]/g, ''));
    
    // Simulate form submission
    const submitBtn = form.querySelector('.btn-submit');
    const originalText = submitBtn.textContent;
    
    submitBtn.textContent = 'Mengirim...';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        // Store donation data (in real app, this would be sent to server)
        const donation = {
            id: Date.now(),
            ...data,
            timestamp: new Date().toISOString(),
            status: 'pending'
        };
        
        // Save to localStorage for demo
        const donations = JSON.parse(localStorage.getItem('donations') || '[]');
        donations.push(donation);
        localStorage.setItem('donations', donations);
        
        showNotification('Formulir donasi berhasil dikirim!');
        form.reset();
        
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }, 2000);
}

// ===== VALIDATION PAGE HANDLING =====
function initializeValidationPage() {
    const form = document.getElementById('validationForm');
    if (!form) return;
    
    // File upload handling
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('donationReceipt');
    
    if (uploadArea && fileInput) {
        uploadArea.addEventListener('click', () => fileInput.click());
        uploadArea.addEventListener('dragover', handleDragOver);
        uploadArea.addEventListener('drop', handleFileDrop);
        fileInput.addEventListener('change', handleFileSelect);
    }
    
    // Form submission
    form.addEventListener('submit', handleValidationSubmit);
}

function handleDragOver(e) {
    e.preventDefault();
    e.currentTarget.style.borderColor = '#3b82f6';
    e.currentTarget.style.background = '#f0f9ff';
}

function handleFileDrop(e) {
    e.preventDefault();
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        handleFile(files[0]);
    }
    e.currentTarget.style.borderColor = '#d1d5db';
    e.currentTarget.style.background = '#f9fafb';
}

function handleFileSelect(e) {
    const file = e.target.files[0];
    if (file) {
        handleFile(file);
    }
}

function handleFile(file) {
    // Validate file type
    if (!file.type.startsWith('image/')) {
        showNotification('Hanya file gambar yang diperbolehkan', 'error');
        return;
    }
    
    // Validate file size (5MB)
    if (file.size > 5 * 1024 * 1024) {
        showNotification('Ukuran file maksimal 5MB', 'error');
        return;
    }
    
    // Update upload area
    const uploadArea = document.getElementById('uploadArea');
    const uploadGambar = uploadArea.querySelector('.upload-Gambar');
    const uploadText = uploadArea.querySelector('.upload-text');
    
    uploadGambar.innerHTML = `<img src="${URL.createObjectURL(file)}" alt="Preview" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">`;
    uploadText.textContent = file.name;
    
    showNotification('File berhasil diupload');
}

function handleValidationSubmit(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData);
    
    // Validate required fields
    if (!data.donorName || !data.donorWhatsapp || !data.donorEmail || !data.donationType || !data.donationAmount) {
        showNotification('Mohon lengkapi semua field yang diperlukan', 'error');
        return;
    }
    
    const submitBtn = form.querySelector('.btn-submit');
    const originalText = submitBtn.textContent;
    
    submitBtn.textContent = 'Mengirim...';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        showNotification('Validasi donasi berhasil dikirim!');
        form.reset();
        
        // Reset upload area
        const uploadArea = document.getElementById('uploadArea');
        const uploadIcon = uploadArea.querySelector('.upload-icon');
        const uploadText = uploadArea.querySelector('.upload-text');
        
        uploadIcon.innerHTML = `<img src="https://via.placeholder.com/50x50/cccccc/666666?text=📷" alt="Upload Icon">`;
        uploadText.textContent = 'drop atau klik disini';
        
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }, 2000);
}

// ===== REPORT PAGE HANDLING =====
function initializeReportPage() {
    // Load sample data
    loadSampleData();
    
    // Initialize filter
    const filterSelect = document.getElementById('reportFilter');
    if (filterSelect) {
        filterSelect.addEventListener('change', handleFilterChange);
    }
    
    // Initialize download button
    const downloadBtn = document.getElementById('downloadBtn');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', handleDownload);
    }
    
    // Initialize chart
    initializeChart();
    
    // Render initial data
    renderReportTable();
    updateChart();
}

function loadSampleData() {
    // Sample donation data
    const sampleData = [
        {
            id: 1,
            name: 'Fadillah',
            date: '2025-01-15',
            amount: 500000,
            description: 'Donasi untuk pendidikan'
        },
        {
            id: 2,
            name: 'Siti ',
            date: '2025-01-20',
            amount: 750000,
            description: 'Donasi untuk kesehatan'
        },
        {
            id: 3,
            name: 'Budi',
            date: '2025-01-25',
            amount: 1000000,
            description: 'Donasi umum'
        },
        {
            id: 4,
            name: 'Dewi',
            date: '2025-02-01',
            amount: 300000,
            description: 'Donasi untuk makanan'
        },
        {
            id: 5,
            name: 'Hartono',
            date: '2025-02-05',
            amount: 1200000,
            description: 'Donasi untuk infrastruktur'
        }
    ];
    
    currentDonations = sampleData;
}

function handleFilterChange(e) {
    const filter = e.target.value;
    renderReportTable(filter);
    updateChart(filter);
}

function renderReportTable(filter = 'monthly') {
    const tableBody = document.getElementById('reportTableBody');
    if (!tableBody) return;
    
    let filteredData = [...currentDonations];
    
    // Apply filter
    if (filter === 'monthly') {
        const currentMonth = new Date().getMonth();
        const currentYear = new Date().getFullYear();
        filteredData = filteredData.filter(donation => {
            const date = new Date(donation.date);
            return date.getMonth() === currentMonth && date.getFullYear() === currentYear;
        });
    }
    
    // Clear table
    tableBody.innerHTML = '';
    
    // Add rows
    filteredData.forEach((donation, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${donation.name}</td>
            <td>${formatDate(donation.date)}</td>
            <td>${formatCurrency(donation.amount)}</td>
            <td>${donation.description}</td>
        `;
        tableBody.appendChild(row);
    });
    
    // Add total row
    const total = filteredData.reduce((sum, donation) => sum + donation.amount, 0);
    const totalRow = document.createElement('tr');
    totalRow.style.fontWeight = 'bold';
    totalRow.style.backgroundColor = '#f8f9fa';
    totalRow.innerHTML = `
        <td colspan="3">Total</td>
        <td>${formatCurrency(total)}</td>
        <td></td>
    `;
    tableBody.appendChild(totalRow);
}

function initializeChart() {
    const canvas = document.getElementById('donationChart');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    // Create simple bar chart using canvas
    donationChart = {
        canvas: canvas,
        ctx: ctx,
        data: [],
        render: function() {
            const { ctx, canvas, data } = this;
            const width = canvas.width;
            const height = canvas.height;
            const padding = 40;
            const chartWidth = width - 2 * padding;
            const chartHeight = height - 2 * padding;
            
            // Clear canvas
            ctx.clearRect(0, 0, width, height);
            
            if (data.length === 0) return;
            
            // Find max value
            const maxValue = Math.max(...data.map(d => d.amount));
            
            // Draw bars
            const barWidth = chartWidth / data.length;
            data.forEach((item, index) => {
                const barHeight = (item.amount / maxValue) * chartHeight;
                const x = padding + index * barWidth + barWidth * 0.1;
                const y = height - padding - barHeight;
                
                // Draw bar
                ctx.fillStyle = '#0066cc';
                ctx.fillRect(x, y, barWidth * 0.8, barHeight);
                
                // Draw label
                ctx.fillStyle = '#374151';
                ctx.font = '12px Arial';
                ctx.textAlign = 'center';
                ctx.fillText(item.name, x + barWidth * 0.4, height - padding + 20);
            
                // Draw value
                ctx.fillText(formatCurrency(item.amount), x + barWidth * 0.4, y - 10);
            });
            
            // Draw axes
            ctx.strokeStyle = '#e5e7eb';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(padding, padding);
            ctx.lineTo(padding, height - padding);
            ctx.lineTo(width - padding, height - padding);
            ctx.stroke();
        }
    };
}

function updateChart(filter = 'monthly') {
    if (!donationChart) return;
    
    let filteredData = [...currentDonations];
    
    // Apply filter
    if (filter === 'monthly') {
        const currentMonth = new Date().getMonth();
        const currentYear = new Date().getFullYear();
        filteredData = filteredData.filter(donation => {
            const date = new Date(donation.date);
            return date.getMonth() === currentMonth && date.getFullYear() === currentYear;
        });
    }
    
    donationChart.data = filteredData;
    donationChart.render();
}

function handleDownload() {
    const filter = document.getElementById('reportFilter')?.value || 'monthly';
    let filteredData = [...currentDonations];
    
    // Apply filter
    if (filter === 'monthly') {
        const currentMonth = new Date().getMonth();
        const currentYear = new Date().getFullYear();
        filteredData = filteredData.filter(donation => {
            const date = new Date(donation.date);
            return date.getMonth() === currentMonth && date.getFullYear() === currentYear;
        });
    }
    
    // Create CSV content
    const headers = ['No', 'Nama', 'Tanggal', 'Total Uang', 'Keterangan'];
    const csvContent = [
        headers.join(','),
        ...filteredData.map((donation, index) => [
            index + 1,
            donation.name,
            formatDate(donation.date),
            donation.amount,
            donation.description
        ].join(','))
    ].join('\n');
    
    // Create and download file
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', `laporan_donasi_${filter}_${new Date().toISOString().split('T')[0]}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showNotification('Laporan berhasil diunduh');
}

// ===== DONASI PAGE FUNCTIONALITY =====

// Initialize donasi page functionality
function initDonasiPage() {
    // Search functionality
    initSearchFunctionality();
    
    // Campaign interactions
    initCampaignInteractions();
    
    // Smooth scrolling for navigation
    initSmoothScrolling();
    
    // Add loading animations
    initLoadingAnimations();
}

// Search functionality for campaign search
function initSearchFunctionality() {
    const searchInput = document.querySelector('.search-input');
    const searchBtn = document.querySelector('.search-btn');
    
    if (searchInput && searchBtn) {
        // Search on button click
        searchBtn.addEventListener('click', () => {
            performSearch(searchInput.value);
        });
        
        // Search on Enter key
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                performSearch(searchInput.value);
            }
        });
        
        // Real-time search with debounce
        let searchTimeout;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(e.target.value);
            }, 300);
        });
    }
}

// Perform search functionality
function performSearch(query) {
    const campaignItems = document.querySelectorAll('.campaign-item');
    
    if (!query.trim()) {
        // Show all items if search is empty
        campaignItems.forEach(item => {
            item.style.display = 'block';
            item.style.opacity = '1';
        });
        return;
    }
    
    const searchTerm = query.toLowerCase();
    
    campaignItems.forEach(item => {
        const title = item.querySelector('h3')?.textContent.toLowerCase() || '';
        const description = item.querySelector('p')?.textContent.toLowerCase() || '';
        
        if (title.includes(searchTerm) || description.includes(searchTerm)) {
            item.style.display = 'block';
            item.style.opacity = '1';
        } else {
            item.style.display = 'none';
            item.style.opacity = '0';
        }
    });
    
    // Show notification if no results
    const visibleItems = document.querySelectorAll('.campaign-item[style*="display: block"]');
    if (visibleItems.length === 0) {
        showNotification('Tidak ada campaign yang ditemukan', 'error');
    }
}

// Campaign item interactions
function initCampaignInteractions() {
    const campaignItems = document.querySelectorAll('.campaign-item');
    
    campaignItems.forEach(item => {
        // Click to view details
        item.addEventListener('click', () => {
            const title = item.querySelector('h3')?.textContent || 'Campaign';
            showCampaignDetails(title, item);
        });
        
        // Add hover effects
        item.addEventListener('mouseenter', () => {
            item.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', () => {
            item.style.transform = 'translateY(0) scale(1)';
        });
    });
}

// Show campaign details modal
function showCampaignDetails(title, item) {
    // Create modal
    const modal = document.createElement('div');
    modal.className = 'campaign-modal';
    modal.innerHTML = `
        <div class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>${title}</h3>
                    <button class="modal-close">&times;</button>
                </div>
                <div class="modal-body">
                    <img src="${item.querySelector('img').src}" alt="${title}">
                    <p>${item.querySelector('p').textContent}</p>
                    <div class="campaign-stats">
                        <div class="stat">
                            <span class="stat-label">Target</span>
                            <span class="stat-value">Rp 50.000.000</span>
                        </div>
                        <div class="stat">
                            <span class="stat-label">Terkumpul</span>
                            <span class="stat-value">Rp 35.000.000</span>
                        </div>
                        <div class="stat">
                            <span class="stat-label">Progress</span>
                            <span class="stat-value">70%</span>
                        </div>
                    </div>
                    <button class="btn-donate">Donasi Sekarang</button>
                </div>
            </div>
        </div>
    `;
    
    // Add modal styles
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
    `;
    
    const overlay = modal.querySelector('.modal-overlay');
    overlay.style.cssText = `
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    `;
    
    const content = modal.querySelector('.modal-content');
    content.style.cssText = `
        background: white;
        border-radius: 12px;
        max-width: 500px;
        width: 100%;
        max-height: 80vh;
        overflow-y: auto;
        position: relative;
        transform: scale(0.8);
        opacity: 0;
        transition: all 0.3s ease;
    `;
    
    const header = modal.querySelector('.modal-header');
    header.style.cssText = `
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    `;
    
    const closeBtn = modal.querySelector('.modal-close');
    closeBtn.style.cssText = `
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
        padding: 0.5rem;
    `;
    
    const body = modal.querySelector('.modal-body');
    body.style.cssText = `
        padding: 1.5rem;
    `;
    
    const bodyImg = modal.querySelector('.modal-body img');
    bodyImg.style.cssText = `
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 1rem;
    `;
    
    const stats = modal.querySelector('.campaign-stats');
    stats.style.cssText = `
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin: 1.5rem 0;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 8px;
    `;
    
    const statElements = modal.querySelectorAll('.stat');
    statElements.forEach(stat => {
        stat.style.cssText = `
            text-align: center;
        `;
    });
    
    const statLabels = modal.querySelectorAll('.stat-label');
    statLabels.forEach(label => {
        label.style.cssText = `
            display: block;
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        `;
    });
    
    const statValues = modal.querySelectorAll('.stat-value');
    statValues.forEach(value => {
        value.style.cssText = `
            display: block;
            font-weight: 600;
            color: #1e3a8a;
        `;
    });
    
    const donateBtn = modal.querySelector('.btn-donate');
    donateBtn.style.cssText = `
        width: 100%;
        background: #1e3a8a;
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    `;
    
    // Add to page
    document.body.appendChild(modal);
    
    // Animate in
    setTimeout(() => {
        content.style.transform = 'scale(1)';
        content.style.opacity = '1';
    }, 100);
    
    // Close functionality
    const closeModal = () => {
        content.style.transform = 'scale(0.8)';
        content.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(modal);
        }, 300);
    };
    
    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeModal();
    });
    
    // Donate button functionality
    donateBtn.addEventListener('click', () => {
        closeModal();
        showNotification('Redirecting to donation form...', 'success');
        // Here you can redirect to the actual donation form
        setTimeout(() => {
            window.location.href = '/donasi-form';
        }, 1000);
    });
}

// Smooth scrolling for navigation
function initSmoothScrolling() {
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            
            // Only handle internal links
            if (href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

// Loading animations
function initLoadingAnimations() {
    // Animate campaign items on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    const campaignItems = document.querySelectorAll('.campaign-item');
    campaignItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(30px)';
        item.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(item);
    });
}

// Read more button functionality
function initReadMoreButton() {
    const readMoreBtn = document.querySelector('.read-more-btn');
    
    if (readMoreBtn) {
        readMoreBtn.addEventListener('click', () => {
            showNotification('Loading more campaigns...', 'success');
            // Here you can implement pagination or load more campaigns
            setTimeout(() => {
                showNotification('More campaigns loaded!', 'success');
            }, 1500);
        });
    }
}

// ===== PAGE INITIALIZATION =====

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check current page and initialize appropriate functionality
    const currentPath = window.location.pathname;
    
    if (currentPath === '/donasi') {
        initDonasiPage();
        initReadMoreButton();
    } else if (currentPath === '/donasi') {
        initializeDonationForm();
    } else if (currentPath === '/validasi-donasi') {
        initializeValidationPage();
    } else if (currentPath === '/laporan') {
        initializeReportPage();
    }
    
    // Initialize navigation
    initializeNavigation();
});

// Common functionality for all pages
function initCommonFunctionality() {
    // Header scroll effect
    const header = document.querySelector('.header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                header.style.background = 'rgba(30, 58, 138, 0.95)';
                header.style.backdropFilter = 'blur(10px)';
            } else {
                header.style.background = '#1e3a8a';
                header.style.backdropFilter = 'none';
            }
        });
    }
    
    // Mobile menu toggle (if needed)
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const nav = document.querySelector('.nav');
    
    if (mobileMenuBtn && nav) {
        mobileMenuBtn.addEventListener('click', () => {
            nav.classList.toggle('nav-open');
        });
    }
}

// ===== EVENT LISTENERS =====
document.addEventListener('DOMContentLoaded', initializePage);

// Handle window resize for chart
window.addEventListener('resize', () => {
    if (donationChart) {
        donationChart.render();
    }
});

// ===== EXPORT FUNCTIONS FOR GLOBAL USE =====
window.showNotification = showNotification;
window.formatCurrency = formatCurrency;
window.formatDate = formatDate;
