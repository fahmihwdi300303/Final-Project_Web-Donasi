/**
 * Donasi Page JavaScript
 * Handles campaign search, interactions, and modal functionality
 */

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
    
    // Read more button
    initReadMoreButton();
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
    
    // Add to page
    document.body.appendChild(modal);
    
    // Animate in
    setTimeout(() => {
        const content = modal.querySelector('.modal-content');
        content.style.transform = 'scale(1)';
        content.style.opacity = '1';
    }, 100);
    
    // Close functionality
    const closeModal = () => {
        const content = modal.querySelector('.modal-content');
        content.style.transform = 'scale(0.8)';
        content.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(modal);
        }, 300);
    };
    
    const closeBtn = modal.querySelector('.modal-close');
    const overlay = modal.querySelector('.modal-overlay');
    
    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeModal();
    });
    
    // Donate button functionality
    const donateBtn = modal.querySelector('.btn-donate');
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

// Notification function
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

// Header scroll effect
function initHeaderScrollEffect() {
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
}

// ===== PAGE INITIALIZATION =====

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize donasi page functionality
    initDonasiPage();
    
    // Initialize header scroll effect
    initHeaderScrollEffect();
    
    // Mobile menu toggle (if needed)
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const nav = document.querySelector('.nav');
    
    if (mobileMenuBtn && nav) {
        mobileMenuBtn.addEventListener('click', () => {
            nav.classList.toggle('nav-open');
        });
    }
});
