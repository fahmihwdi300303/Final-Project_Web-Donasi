// Kegiatan Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile Menu Toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const navButtons = document.querySelector('.nav-buttons');
    
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            // Toggle mobile menu
            navMenu.classList.toggle('active');
            navButtons.classList.toggle('active');
            mobileMenuToggle.classList.toggle('active');
            
            // Animate hamburger to X
            const spans = mobileMenuToggle.querySelectorAll('span');
            spans.forEach((span, index) => {
                if (mobileMenuToggle.classList.contains('active')) {
                    if (index === 0) span.style.transform = 'rotate(45deg) translate(5px, 5px)';
                    if (index === 1) span.style.opacity = '0';
                    if (index === 2) span.style.transform = 'rotate(-45deg) translate(7px, -6px)';
                } else {
                    span.style.transform = 'none';
                    span.style.opacity = '1';
                }
            });
        });
    }
    
    // Hero Button Click Handler
    const heroButton = document.querySelector('.btn-hero');
    if (heroButton) {
        heroButton.addEventListener('click', function() {
            // Smooth scroll to activities section
            const activitiesSection = document.querySelector('.activities-grid');
            if (activitiesSection) {
                activitiesSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }
    
    // Activity Card Click Handlers
    const activityCards = document.querySelectorAll('.activity-card');
    const modal = document.getElementById('activityModal');
    const modalClose = document.querySelector('.modal-close');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    const modalDate = document.getElementById('modalDate');
    const modalDescription = document.getElementById('modalDescription');
    
    activityCards.forEach((card, index) => {
        card.addEventListener('click', function() {
            // Add click animation
            card.style.transform = 'scale(0.98)';
            setTimeout(() => {
                card.style.transform = '';
            }, 150);
            
            // Get activity data
            const activityId = this.getAttribute('data-activity-id');
            const image = this.querySelector('.activity-image img').src;
            const title = this.querySelector('h3').textContent;
            const date = this.querySelector('.activity-date').textContent;
            const description = this.querySelector('.activity-description').textContent;
            
            // Populate modal
            modalImage.src = image;
            modalImage.alt = title;
            modalTitle.textContent = title;
            modalDate.textContent = date;
            modalDescription.textContent = description;
            
            // Show modal
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            
            console.log(`Activity ${activityId} clicked`);
        });
        
        // Add hover effect
        card.addEventListener('mouseenter', function() {
            card.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            card.style.transform = '';
        });
    });
    
    // Modal close functionality
    if (modalClose) {
        modalClose.addEventListener('click', function() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    }
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
    
    // Footer Indicators Click Handler
    const indicators = document.querySelectorAll('.indicator');
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function() {
            // Remove active class from all indicators
            indicators.forEach(ind => ind.classList.remove('active'));
            // Add active class to clicked indicator
            this.classList.add('active');
            
            // You can add carousel functionality here
            console.log(`Indicator ${index + 1} clicked`);
        });
    });
    
    // Smooth Scrolling for Navigation Links
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
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
    
    // Intersection Observer for Animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);
    
    // Observe activity cards for animation
    activityCards.forEach(card => {
        observer.observe(card);
    });
    
    // Observe quote section
    const quoteSection = document.querySelector('.quote-section');
    if (quoteSection) {
        observer.observe(quoteSection);
    }
    
    // Parallax Effect for Hero Section
    const heroBackground = document.querySelector('.hero-background');
    if (heroBackground) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            heroBackground.style.transform = `translateY(${rate}px)`;
        });
    }
    
    // Lazy Loading for Images
    const images = document.querySelectorAll('.activity-image img');
    const imageObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src || img.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => {
        if (img.dataset.src) {
            imageObserver.observe(img);
        }
    });
    
    // Keyboard Navigation
    document.addEventListener('keydown', function(e) {
        // ESC key to close mobile menu or modal
        if (e.key === 'Escape') {
            if (modal && modal.style.display === 'block') {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            } else if (navMenu && navMenu.classList.contains('active')) {
                mobileMenuToggle.click();
            }
        }
        
        // Arrow keys for indicators
        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            const activeIndicator = document.querySelector('.indicator.active');
            if (activeIndicator) {
                const currentIndex = Array.from(indicators).indexOf(activeIndicator);
                let newIndex;
                
                if (e.key === 'ArrowLeft') {
                    newIndex = currentIndex > 0 ? currentIndex - 1 : indicators.length - 1;
                } else {
                    newIndex = currentIndex < indicators.length - 1 ? currentIndex + 1 : 0;
                }
                
                indicators[newIndex].click();
            }
        }
    });
    
    // Add loading animation
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
    });
    
    // Add CSS for mobile menu
    const style = document.createElement('style');
    style.textContent = `
        @media (max-width: 768px) {
            .nav-menu.active {
                display: flex !important;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #1e3a8a;
                padding: 1rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
            
            .nav-buttons.active {
                display: flex !important;
                flex-direction: column;
                gap: 0.5rem;
                margin-top: 1rem;
            }
            
            .mobile-menu-toggle.active span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }
            
            .mobile-menu-toggle.active span:nth-child(2) {
                opacity: 0;
            }
            
            .mobile-menu-toggle.active span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -6px);
            }
        }
        
        .loaded .hero-content {
            animation: fadeInUp 1s ease forwards;
        }
    `;
    document.head.appendChild(style);
    
    // Add error handling for images
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.src = 'https://via.placeholder.com/600x400/1e3a8a/FFFFFF?text=Image+Not+Found';
            this.alt = 'Image not available';
        });
    });
    
    console.log('Kegiatan page JavaScript loaded successfully!');
});
