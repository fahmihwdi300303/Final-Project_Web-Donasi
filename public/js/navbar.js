/**
 * Navbar JavaScript Module
 * Handles dropdown functionality and mobile menu interactions
 */
class NavbarManager {
    constructor() {
        this.dropdowns = document.querySelectorAll('.nav-dropdown');
        this.mobileToggle = document.querySelector('.mobile-menu-toggle');
        this.nav = document.querySelector('.nav');
        this.isMobileMenuOpen = false;
        
        this.init();
    }
    
    init() {
        this.setupDropdowns();
        this.setupMobileMenu();
        this.setupClickOutside();
        this.setupKeyboardNavigation();
    }
    
    /**
     * Setup dropdown functionality
     */
    setupDropdowns() {
        this.dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.dropdown-toggle');
            
            // Desktop click handler
            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleDropdown(dropdown);
            });
            
            // Mobile touch handler
            toggle.addEventListener('touchstart', (e) => {
                e.preventDefault();
                this.toggleDropdown(dropdown);
            });
        });
    }
    
    /**
     * Toggle dropdown visibility
     */
    toggleDropdown(targetDropdown) {
        // Close other dropdowns
        this.dropdowns.forEach(dropdown => {
            if (dropdown !== targetDropdown) {
                dropdown.classList.remove('active');
            }
        });
        
        // Toggle target dropdown
        targetDropdown.classList.toggle('active');
    }
    
    /**
     * Setup mobile menu functionality
     */
    setupMobileMenu() {
        if (!this.mobileToggle) return;
        
        this.mobileToggle.addEventListener('click', () => {
            this.toggleMobileMenu();
        });
        
        // Close mobile menu when clicking on nav links
        const navLinks = this.nav.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (this.isMobileMenuOpen) {
                    this.closeMobileMenu();
                }
            });
        });
    }
    
    /**
     * Toggle mobile menu
     */
    toggleMobileMenu() {
        this.isMobileMenuOpen = !this.isMobileMenuOpen;
        
        if (this.isMobileMenuOpen) {
            this.openMobileMenu();
        } else {
            this.closeMobileMenu();
        }
    }
    
    /**
     * Open mobile menu
     */
    openMobileMenu() {
        this.nav.classList.add('active');
        this.mobileToggle.innerHTML = '<i class="fas fa-times"></i>';
        document.body.style.overflow = 'hidden';
    }
    
    /**
     * Close mobile menu
     */
    closeMobileMenu() {
        this.nav.classList.remove('active');
        this.mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
        document.body.style.overflow = '';
        this.isMobileMenuOpen = false;
        
        // Close all dropdowns
        this.dropdowns.forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    }
    
    /**
     * Setup click outside to close dropdowns
     */
    setupClickOutside() {
        document.addEventListener('click', (e) => {
            const isDropdownClick = e.target.closest('.nav-dropdown');
            const isMobileToggleClick = e.target.closest('.mobile-menu-toggle');
            
            if (!isDropdownClick && !isMobileToggleClick) {
                this.dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }
        });
    }
    
    /**
     * Setup keyboard navigation
     */
    setupKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            // Close dropdowns on Escape key
            if (e.key === 'Escape') {
                this.dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
                
                if (this.isMobileMenuOpen) {
                    this.closeMobileMenu();
                }
            }
        });
    }
    
    /**
     * Handle window resize
     */
    handleResize() {
        if (window.innerWidth > 768 && this.isMobileMenuOpen) {
            this.closeMobileMenu();
        }
    }
}

/**
 * Initialize navbar when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', () => {
    const navbar = new NavbarManager();
    
    // Handle window resize
    window.addEventListener('resize', () => {
        navbar.handleResize();
    });
});

/**
 * Export for module usage (if needed)
 */
if (typeof module !== 'undefined' && module.exports) {
    module.exports = NavbarManager;
}
