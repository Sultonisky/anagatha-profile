/**
 * Navbar JavaScript
 * Handles mobile menu toggle and active link detection
 */

(function() {
    'use strict';

    function initNavbar() {
        const navToggle = document.querySelector('[data-nav-toggle]');
        const navLinks = document.querySelector('[data-nav-links]');
        const languageSwitcher = document.querySelector('[data-language-switcher]');

        const initLanguageSwitcher = () => {
            if (!languageSwitcher) {
                return;
            }

            const buttons = languageSwitcher.querySelectorAll('.language-switcher__btn[data-language]');
            if (!buttons.length) {
                return;
            }

            const availableLanguages = Array.from(buttons).map((button) => button.dataset.language);
            const defaultLanguage = languageSwitcher.dataset.defaultLanguage || availableLanguages[0];

            const setActiveLanguage = (language) => {
                buttons.forEach((button) => {
                    const isActive = button.dataset.language === language;
                    button.classList.toggle('is-active', isActive);
                    button.setAttribute('aria-pressed', String(isActive));
                });
                languageSwitcher.dataset.selectedLanguage = language;
            };

            setActiveLanguage(defaultLanguage);

            buttons.forEach((button) => {
                button.addEventListener('click', () => {
                    const selectedLanguage = button.dataset.language;
                    const targetUrl = button.dataset.languageUrl;

                    if (!selectedLanguage || selectedLanguage === languageSwitcher.dataset.selectedLanguage) {
                        return;
                    }

                    setActiveLanguage(selectedLanguage);

                    if (targetUrl) {
                        window.location.href = targetUrl;
                        return;
                    }

                    languageSwitcher.dispatchEvent(new CustomEvent('languagechange', {
                        detail: { language: selectedLanguage },
                        bubbles: true
                    }));
                });
            });
        };

        initLanguageSwitcher();

        if (!navToggle || !navLinks) {
            return;
        }

        const closeMenu = () => {
            if (!navLinks.classList.contains('is-open')) {
                return;
            }
            navLinks.classList.remove('is-open');
            navToggle.setAttribute('aria-expanded', 'false');
            navToggle.classList.remove('is-active');
            document.body.classList.remove('nav-open');
        };

        const closeOnLinkClick = (event) => {
            if (event.target.matches('a')) {
                closeMenu();
            }
        };

        navToggle.addEventListener('click', () => {
            const isOpen = navLinks.classList.toggle('is-open');
            navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            navToggle.classList.toggle('is-active', isOpen);
            document.body.classList.toggle('nav-open', isOpen);
            if (isOpen) {
                navLinks.querySelector('a')?.focus();
            } else {
                navToggle.focus();
            }
        });

        document.addEventListener('click', (event) => {
            if (!navLinks.contains(event.target) && !navToggle.contains(event.target)) {
                closeMenu();
            }
        });

        document.addEventListener('keyup', (event) => {
            if (event.key === 'Escape') {
                closeMenu();
                navToggle.focus();
            }
        });

        navLinks.addEventListener('click', closeOnLinkClick);

        // Active link detection for desktop only (width > 768px)
        const updateActiveLink = () => {
            // Only run on desktop
            if (window.innerWidth <= 768) {
                // Remove all active states on mobile/tablet
                navLinks.querySelectorAll('a.is-active').forEach(link => {
                    link.classList.remove('is-active');
                });
                return;
            }

            const sections = document.querySelectorAll('section[id]');
            const navLinksList = navLinks.querySelectorAll('a[data-nav-link]');
            
            if (sections.length === 0 || navLinksList.length === 0) {
                return;
            }

            let currentSection = '';
            const scrollPosition = window.scrollY + 150; // Offset for better UX

            sections.forEach((section) => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                const sectionId = section.getAttribute('id');

                if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                    currentSection = sectionId;
                }
            });

            // If at the top, make hero/home active
            if (window.scrollY < 100) {
                currentSection = 'hero';
            }

            // Update active state
            navLinksList.forEach((link) => {
                const linkSection = link.getAttribute('data-nav-link');
                if (linkSection === currentSection) {
                    link.classList.add('is-active');
                } else {
                    link.classList.remove('is-active');
                }
            });
        };

        // Update on scroll (throttled for performance)
        let scrollTimeout;
        window.addEventListener('scroll', () => {
            if (scrollTimeout) {
                window.cancelAnimationFrame(scrollTimeout);
            }
            scrollTimeout = window.requestAnimationFrame(updateActiveLink);
        });

        // Update on resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            if (resizeTimeout) {
                clearTimeout(resizeTimeout);
            }
            resizeTimeout = setTimeout(updateActiveLink, 150);
        });

        // Initial update
        updateActiveLink();
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNavbar);
    } else {
        // DOM is already ready
        initNavbar();
    }
})();

