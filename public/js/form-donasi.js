/**
 * Form Donasi JavaScript Module
 * Handles form validation and submission
 */
class DonasiFormManager {
    constructor() {
        this.form = document.getElementById('donasiForm');
        this.submitBtn = document.getElementById('submitBtn');
        this.isSubmitting = false;
        
        this.validationRules = {
            nama_depan: {
                required: true,
                minLength: 2,
                maxLength: 50,
                pattern: /^[a-zA-Z\s]+$/
            },
            nama_belakang: {
                required: true,
                minLength: 2,
                maxLength: 50,
                pattern: /^[a-zA-Z\s]+$/
            },
            email: {
                required: true,
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
            },
            whatsapp: {
                required: true,
                pattern: /^(\+62|62|0)8[1-9][0-9]{6,9}$/
            },
            jenis_donasi: {
                required: true
            },
            jumlah: {
                required: true,
                min: 1000,
                max: 1000000000
            },
            jumlah_barang: {
                required: true,
                min: 1,
                max: 1000
            },
            jenis_barang: {
                required: true
            },
            kondisi_barang: {
                required: true
            },
            metode_pembayaran: {
                required: true
            },
            metode_pengiriman: {
                required: true
            },
            catatan: {
                maxLength: 500
            }
        };
        
        this.errorMessages = {
            nama_depan: {
                required: 'Nama depan wajib diisi',
                minLength: 'Nama depan minimal 2 karakter',
                maxLength: 'Nama depan maksimal 50 karakter',
                pattern: 'Nama depan hanya boleh berisi huruf'
            },
            nama_belakang: {
                required: 'Nama belakang wajib diisi',
                minLength: 'Nama belakang minimal 2 karakter',
                maxLength: 'Nama belakang maksimal 50 karakter',
                pattern: 'Nama belakang hanya boleh berisi huruf'
            },
            email: {
                required: 'Email wajib diisi',
                pattern: 'Format email tidak valid'
            },
            whatsapp: {
                required: 'Nomor WhatsApp wajib diisi',
                pattern: 'Format nomor WhatsApp tidak valid'
            },
            jenis_donasi: {
                required: 'Jenis donasi wajib dipilih'
            },
            jumlah: {
                required: 'Jumlah donasi wajib diisi',
                min: 'Jumlah donasi minimal Rp 1.000',
                max: 'Jumlah donasi maksimal Rp 1.000.000.000'
            },
            jumlah_barang: {
                required: 'Jumlah barang wajib diisi',
                min: 'Jumlah barang minimal 1',
                max: 'Jumlah barang maksimal 1000'
            },
            jenis_barang: {
                required: 'Jenis barang wajib dipilih'
            },
            kondisi_barang: {
                required: 'Kondisi barang wajib dipilih'
            },
            metode_pembayaran: {
                required: 'Metode pembayaran wajib dipilih'
            },
            metode_pengiriman: {
                required: 'Metode pengiriman wajib dipilih'
            },
            catatan: {
                maxLength: 'Catatan maksimal 500 karakter'
            }
        };
        
        this.init();
    }
    
    init() {
        this.setupFormValidation();
        this.setupRealTimeValidation();
        this.setupFormSubmission();
        this.setupInputFormatting();
    }
    
    /**
     * Setup form validation
     */
    setupFormValidation() {
        // Add event listeners for form submission
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleFormSubmission();
        });
        
        // Add event listeners for input changes
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                this.validateField(input);
            });
            
            input.addEventListener('input', () => {
                this.clearFieldError(input);
            });
        });
    }
    
    /**
     * Setup real-time validation
     */
    setupRealTimeValidation() {
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                if (input.value.trim() !== '') {
                    this.validateField(input);
                }
            });
        });
    }
    
    /**
     * Setup form submission
     */
    setupFormSubmission() {
        this.submitBtn.addEventListener('click', (e) => {
            e.preventDefault();
            this.handleFormSubmission();
        });
    }
    
    /**
     * Setup input formatting
     */
    setupInputFormatting() {
        // Format currency input
        const jumlahInput = document.getElementById('jumlah');
        if (jumlahInput) {
            jumlahInput.addEventListener('input', (e) => {
                this.formatCurrencyInput(e.target);
            });
        }
        
        // Format WhatsApp input
        const whatsappInput = document.getElementById('whatsapp');
        if (whatsappInput) {
            whatsappInput.addEventListener('input', (e) => {
                this.formatWhatsAppInput(e.target);
            });
        }
    }
    
    /**
     * Format currency input
     */
    formatCurrencyInput(input) {
        let value = input.value.replace(/\D/g, '');
        if (value === '') return;
        
        // Remove leading zeros
        value = value.replace(/^0+/, '');
        if (value === '') value = '0';
        
        input.value = value;
    }
    
    /**
     * Format WhatsApp input
     */
    formatWhatsAppInput(input) {
        let value = input.value.replace(/\D/g, '');
        
        // Format as Indonesian phone number
        if (value.startsWith('62')) {
            value = value.substring(2);
        } else if (value.startsWith('0')) {
            value = value.substring(1);
        }
        
        if (value.length > 0 && !value.startsWith('8')) {
            value = '8' + value;
        }
        
        input.value = value;
    }
    
    /**
     * Validate a single field
     */
    validateField(field) {
        const fieldName = field.name;
        const value = field.value.trim();
        const rules = this.validationRules[fieldName];
        
        if (!rules) return true;
        
        // Check required
        if (rules.required && !value) {
            this.showFieldError(field, this.errorMessages[fieldName].required);
            return false;
        }
        
        // Check min length
        if (rules.minLength && value.length < rules.minLength) {
            this.showFieldError(field, this.errorMessages[fieldName].minLength);
            return false;
        }
        
        // Check max length
        if (rules.maxLength && value.length > rules.maxLength) {
            this.showFieldError(field, this.errorMessages[fieldName].maxLength);
            return false;
        }
        
        // Check pattern
        if (rules.pattern && !rules.pattern.test(value)) {
            this.showFieldError(field, this.errorMessages[fieldName].pattern);
            return false;
        }
        
        // Check min value (for numbers)
        if (rules.min && parseFloat(value) < rules.min) {
            this.showFieldError(field, this.errorMessages[fieldName].min);
            return false;
        }
        
        // Check max value (for numbers)
        if (rules.max && parseFloat(value) > rules.max) {
            this.showFieldError(field, this.errorMessages[fieldName].max);
            return false;
        }
        
        // Clear error if validation passes
        this.clearFieldError(field);
        return true;
    }
    
    /**
     * Show field error
     */
    showFieldError(field, message) {
        field.classList.add('error');
        const errorElement = document.getElementById(field.name + 'Error');
        if (errorElement) {
            errorElement.textContent = message;
        }
    }
    
    /**
     * Clear field error
     */
    clearFieldError(field) {
        field.classList.remove('error');
        const errorElement = document.getElementById(field.name + 'Error');
        if (errorElement) {
            errorElement.textContent = '';
        }
    }
    
    /**
     * Validate entire form
     */
    validateForm() {
        const inputs = this.form.querySelectorAll('input, select, textarea');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    /**
     * Handle form submission
     */
    async handleFormSubmission() {
        if (this.isSubmitting) return;
        
        // Validate form
        if (!this.validateForm()) {
            this.showNotification('Mohon perbaiki kesalahan pada form', 'error');
            return;
        }
        
        // Show loading state
        this.setLoadingState(true);
        
        try {
            // Collect form data
            const formData = new FormData(this.form);
            const data = Object.fromEntries(formData.entries());
            
            // Simulate API call (replace with actual endpoint)
            await this.submitFormData(data);
            
            // Show success message
            this.showNotification('Formulir donasi berhasil dikirim!', 'success');
            this.form.reset();
            
        } catch (error) {
            console.error('Form submission error:', error);
            this.showNotification('Terjadi kesalahan saat mengirim formulir', 'error');
        } finally {
            this.setLoadingState(false);
        }
    }
    
    /**
     * Submit form data to server
     */
    async submitFormData(data) {
        // Simulate API call delay
        await new Promise(resolve => setTimeout(resolve, 2000));
        
        // Here you would typically make an actual API call
        // Example:
        // const response = await fetch('/api/donasi', {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json',
        //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //     },
        //     body: JSON.stringify(data)
        // });
        // 
        // if (!response.ok) {
        //     throw new Error('Network response was not ok');
        // }
        // 
        // return response.json();
        
        console.log('Form data submitted:', data);
        return { success: true };
    }
    
    /**
     * Set loading state
     */
    setLoadingState(loading) {
        this.isSubmitting = loading;
        const btnText = this.submitBtn.querySelector('.btn-text');
        const btnLoading = this.submitBtn.querySelector('.btn-loading');
        
        if (loading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'flex';
            this.submitBtn.disabled = true;
        } else {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            this.submitBtn.disabled = false;
        }
    }
    
    /**
     * Show notification
     */
    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Remove notification after 5 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 5000);
    }
}

/**
 * Initialize form when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', () => {
    const donasiForm = new DonasiFormManager();
    
    // Add notification styles
    const style = document.createElement('style');
    style.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 400px;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification-success {
            border-left: 4px solid #10b981;
        }
        
        .notification-error {
            border-left: 4px solid #ef4444;
        }
        
        .notification-info {
            border-left: 4px solid #3b82f6;
        }
        
        .notification i {
            font-size: 1.25rem;
        }
        
        .notification-success i {
            color: #10b981;
        }
        
        .notification-error i {
            color: #ef4444;
        }
        
        .notification-info i {
            color: #3b82f6;
        }
    `;
    document.head.appendChild(style);
});

/**
 * Export for module usage (if needed)
 */
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DonasiFormManager;
}
