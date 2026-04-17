/**
 * SMARTNET CTF DASHBOARD — JavaScript
 * Color Theme: Red Gradient (#E63946 - #C1121F)
 */

(function() {
    'use strict';

    // =============================================
    // MOBILE SIDEBAR TOGGLE
    // =============================================

    function initMobileMenu() {
        const menuToggle = document.getElementById('smartnet-menu-toggle');
        const sidebar = document.querySelector('.smartnet-sidebar');
        const overlay = document.getElementById('smartnet-sidebar-overlay');

        if (!menuToggle || !sidebar) {
            return;
        }

        // Toggle menu
        menuToggle.addEventListener('click', function() {
            const isOpen = sidebar.classList.toggle('is-open');
            menuToggle.classList.toggle('is-open', isOpen);
            if (overlay) {
                overlay.classList.toggle('is-open', isOpen);
            }
            menuToggle.setAttribute('aria-expanded', isOpen);
        });

        // Close on overlay click
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('is-open');
                menuToggle.classList.remove('is-open');
                overlay.classList.remove('is-open');
                menuToggle.setAttribute('aria-expanded', false);
            });
        }

        // Close on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('is-open')) {
                sidebar.classList.remove('is-open');
                menuToggle.classList.remove('is-open');
                if (overlay) {
                    overlay.classList.remove('is-open');
                }
                menuToggle.setAttribute('aria-expanded', false);
            }
        });

        // Close on link click
        const navLinks = sidebar.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                sidebar.classList.remove('is-open');
                menuToggle.classList.remove('is-open');
                if (overlay) {
                    overlay.classList.remove('is-open');
                }
                menuToggle.setAttribute('aria-expanded', false);
            });
        });
    }

    // =============================================
    // ACTIVE NAV LINK DETECTION
    // =============================================

    function setActiveNavLink() {
        const currentUrl = window.location.href;
        const navLinks = document.querySelectorAll('.smartnet-sidebar a, .woocommerce-MyAccount-navigation a');

        navLinks.forEach(link => {
            link.classList.remove('is-active');
            if (link.href === currentUrl) {
                link.classList.add('is-active');
            }
        });
    }

    // =============================================
    // SMOOTH SCROLL
    // =============================================

    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    // =============================================
    // ANIMATE ON SCROLL
    // =============================================

    function initScrollAnimation() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.smartnet-stat-card, .woocommerce-table').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(10px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });
    }

    // =============================================
    // FORM VALIDATION
    // =============================================

    function initFormValidation() {
        const forms = document.querySelectorAll('.smartnet-auth-form, .woocommerce-form');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.style.borderColor = '#E63946';
                        input.style.boxShadow = '0 0 0 3px rgba(230, 57, 70, 0.1)';
                    } else {
                        input.style.borderColor = '';
                        input.style.boxShadow = '';
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    console.log('Form validation failed');
                }
            });

            // Clear error on input
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.style.borderColor = '';
                    this.style.boxShadow = '';
                });
            });
        });
    }

    // =============================================
    // TOAST NOTIFICATIONS
    // =============================================

    window.smartnetToast = function(message, type = 'info', duration = 3000) {
        const container = document.getElementById('smartnet-toast-container');
        if (!container) {
            const newContainer = document.createElement('div');
            newContainer.id = 'smartnet-toast-container';
            newContainer.style.cssText = `
                position: fixed;
                bottom: 24px;
                right: 24px;
                z-index: 9999;
                display: flex;
                flex-direction: column;
                gap: 12px;
            `;
            document.body.appendChild(newContainer);
        }

        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'rgba(0, 217, 255, 0.15)' : 
                       type === 'error' ? 'rgba(230, 57, 70, 0.15)' : 
                       'rgba(204, 255, 0, 0.15)';
        const borderColor = type === 'success' ? '#00D9FF' : 
                          type === 'error' ? '#E63946' : 
                          '#CCFF00';
        const textColor = type === 'success' ? '#00D9FF' : 
                        type === 'error' ? '#E63946' : 
                        '#CCFF00';

        toast.style.cssText = `
            padding: 14px 18px;
            border-radius: 10px;
            border-left: 4px solid ${borderColor};
            background: ${bgColor};
            color: ${textColor};
            font-size: 14px;
            font-weight: 600;
            animation: slideIn 0.3s ease;
        `;
        toast.textContent = message;

        const container = document.getElementById('smartnet-toast-container');
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    };

    // =============================================
    // AJAX REGISTRATION HANDLER
    // =============================================

    function initAjaxRegistration() {
        const form = document.querySelector('.smartnet-auth-form form[method="post"]');
        if (!form || !window.smartnetAccount) {
            return;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const email = form.querySelector('input[name="email"]')?.value;
            const username = form.querySelector('input[name="username"]')?.value;
            const password = form.querySelector('input[name="password"]')?.value;

            if (!email || !password) {
                window.smartnetToast('Please fill in all required fields', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'smartnet_ajax_register');
            formData.append('email', email);
            formData.append('username', username || email);
            formData.append('password', password);
            formData.append('security', window.smartnetAccount.registerNonce);

            fetch(window.smartnetAccount.ajaxUrl, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.smartnetToast('✓ Registration successful! Redirecting...', 'success');
                        setTimeout(() => {
                            window.location.href = data.data.redirect || '/my-account/';
                        }, 1500);
                    } else {
                        window.smartnetToast('✗ ' + (data.data?.message || 'Registration failed'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Registration error:', error);
                    window.smartnetToast('✗ An error occurred', 'error');
                });
        });
    }

    // =============================================
    // COPY TO CLIPBOARD
    // =============================================

    window.smartnetCopyToClipboard = function(text, element) {
        navigator.clipboard.writeText(text).then(() => {
            const originalText = element.textContent;
            element.textContent = '✓ Copied!';
            setTimeout(() => {
                element.textContent = originalText;
            }, 2000);
            window.smartnetToast('Copied to clipboard', 'success', 2000);
        }).catch(err => {
            console.error('Copy failed:', err);
            window.smartnetToast('Failed to copy', 'error');
        });
    };

    // =============================================
    // THEME COLOR DETECTION
    // =============================================

    function detectColorScheme() {
        const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.body.classList.toggle('theme-dark', isDark);
    }

    // =============================================
    // INITIALIZE ALL
    // =============================================

    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenu();
        setActiveNavLink();
        initSmoothScroll();
        initScrollAnimation();
        initFormValidation();
        initAjaxRegistration();
        detectColorScheme();
    });

    // Re-init on Ajax/dynamic content load
    document.addEventListener('updated_checkout', function() {
        initFormValidation();
    });

    // Listen for color scheme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', detectColorScheme);

})();
