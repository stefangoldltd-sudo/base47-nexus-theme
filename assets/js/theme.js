/**
 * Base47 Theme JavaScript
 * Enhanced theme functionality and interactions
 */

(function($) {
    'use strict';

    // Theme object
    var Base47Theme = {
        
        init: function() {
            this.setupStickyHeader();
            this.setupMobileMenu();
            this.setupScrollToTop();
            this.setupLazyLoading();
            this.setupSmoothScrolling();
            this.setupAccessibility();
            this.setupPerformanceOptimizations();
        },
        
        // Sticky Header
        setupStickyHeader: function() {
            if (!$('body').hasClass('sticky-header')) return;
            
            var $header = $('header, .site-header');
            var headerHeight = $header.outerHeight();
            var scrollThreshold = headerHeight;
            
            $(window).on('scroll', function() {
                var scrollTop = $(window).scrollTop();
                
                if (scrollTop > scrollThreshold) {
                    $header.addClass('is-sticky');
                    $('body').css('padding-top', headerHeight + 'px');
                } else {
                    $header.removeClass('is-sticky');
                    $('body').css('padding-top', '0');
                }
            });
        },
        
        // Mobile Menu
        setupMobileMenu: function() {
            var $menuToggle = $('.menu-toggle, .mobile-menu-toggle');
            var $mobileMenu = $('.mobile-menu, .primary-navigation');
            
            $menuToggle.on('click', function(e) {
                e.preventDefault();
                
                $(this).toggleClass('active');
                $mobileMenu.toggleClass('active');
                $('body').toggleClass('mobile-menu-open');
                
                // Accessibility
                var expanded = $(this).attr('aria-expanded') === 'true';
                $(this).attr('aria-expanded', !expanded);
            });
            
            // Close menu when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.mobile-menu, .menu-toggle').length) {
                    $menuToggle.removeClass('active');
                    $mobileMenu.removeClass('active');
                    $('body').removeClass('mobile-menu-open');
                    $menuToggle.attr('aria-expanded', 'false');
                }
            });
            
            // Close menu on escape key
            $(document).on('keydown', function(e) {
                if (e.keyCode === 27 && $('body').hasClass('mobile-menu-open')) {
                    $menuToggle.removeClass('active');
                    $mobileMenu.removeClass('active');
                    $('body').removeClass('mobile-menu-open');
                    $menuToggle.attr('aria-expanded', 'false');
                }
            });
        },
        
        // Scroll to Top
        setupScrollToTop: function() {
            var $scrollToTop = $('<button class="scroll-to-top" aria-label="Scroll to top"><i class="fas fa-chevron-up"></i></button>');
            $('body').append($scrollToTop);
            
            $(window).on('scroll', function() {
                if ($(window).scrollTop() > 300) {
                    $scrollToTop.addClass('visible');
                } else {
                    $scrollToTop.removeClass('visible');
                }
            });
            
            $scrollToTop.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 600);
            });
        },
        
        // Lazy Loading
        setupLazyLoading: function() {
            if (!window.IntersectionObserver) return;
            
            var lazyImages = document.querySelectorAll('img[data-src]');
            
            var imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            lazyImages.forEach(function(img) {
                imageObserver.observe(img);
            });
        },
        
        // Smooth Scrolling
        setupSmoothScrolling: function() {
            $('a[href*="#"]:not([href="#"])').on('click', function(e) {
                var target = $(this.hash);
                
                if (target.length) {
                    e.preventDefault();
                    
                    var offset = $('header').outerHeight() || 0;
                    var scrollTop = target.offset().top - offset;
                    
                    $('html, body').animate({
                        scrollTop: scrollTop
                    }, 600);
                }
            });
        },
        
        // Accessibility Enhancements
        setupAccessibility: function() {
            // Skip link functionality
            $('.skip-link').on('click', function(e) {
                var target = $($(this).attr('href'));
                if (target.length) {
                    target.focus();
                }
            });
            
            // Focus management for dropdowns
            $('.menu-item-has-children > a').on('focus', function() {
                $(this).parent().addClass('focus');
            }).on('blur', function() {
                $(this).parent().removeClass('focus');
            });
            
            // Keyboard navigation for menus
            $('.menu a').on('keydown', function(e) {
                var $this = $(this);
                var $parent = $this.parent();
                var $menu = $this.closest('.menu');
                
                switch(e.which) {
                    case 37: // Left arrow
                        e.preventDefault();
                        $parent.prev().find('a').first().focus();
                        break;
                    case 39: // Right arrow
                        e.preventDefault();
                        $parent.next().find('a').first().focus();
                        break;
                    case 40: // Down arrow
                        e.preventDefault();
                        if ($parent.hasClass('menu-item-has-children')) {
                            $parent.find('.sub-menu a').first().focus();
                        }
                        break;
                    case 38: // Up arrow
                        e.preventDefault();
                        if ($this.closest('.sub-menu').length) {
                            $this.closest('.menu-item-has-children').find('> a').focus();
                        }
                        break;
                }
            });
        },
        
        // Performance Optimizations
        setupPerformanceOptimizations: function() {
            // Debounce scroll events
            var scrollTimer;
            $(window).on('scroll', function() {
                clearTimeout(scrollTimer);
                scrollTimer = setTimeout(function() {
                    $(window).trigger('scroll.debounced');
                }, 10);
            });
            
            // Preload critical resources
            this.preloadCriticalResources();
            
            // Optimize images
            this.optimizeImages();
        },
        
        // Preload Critical Resources
        preloadCriticalResources: function() {
            // Preload Google Fonts
            var bodyFont = getComputedStyle(document.body).fontFamily;
            var headingFont = getComputedStyle(document.querySelector('h1, h2, h3, h4, h5, h6')).fontFamily;
            
            if (bodyFont && bodyFont.indexOf('Google') !== -1) {
                this.preloadGoogleFont(bodyFont);
            }
            
            if (headingFont && headingFont.indexOf('Google') !== -1) {
                this.preloadGoogleFont(headingFont);
            }
        },
        
        // Preload Google Font
        preloadGoogleFont: function(fontFamily) {
            var fontName = fontFamily.replace(/['"]/g, '').split(',')[0];
            var link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'style';
            link.href = 'https://fonts.googleapis.com/css2?family=' + fontName.replace(' ', '+') + ':wght@300;400;500;600;700&display=swap';
            document.head.appendChild(link);
        },
        
        // Optimize Images
        optimizeImages: function() {
            // Add loading="lazy" to images below the fold
            var images = document.querySelectorAll('img:not([loading])');
            var viewportHeight = window.innerHeight;
            
            images.forEach(function(img) {
                var rect = img.getBoundingClientRect();
                if (rect.top > viewportHeight) {
                    img.setAttribute('loading', 'lazy');
                }
            });
        },
        
        // Utility Functions
        debounce: function(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        },
        
        throttle: function(func, limit) {
            var inThrottle;
            return function() {
                var args = arguments;
                var context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(function() { inThrottle = false; }, limit);
                }
            };
        }
    };
    
    // Initialize theme when document is ready
    $(document).ready(function() {
        Base47Theme.init();
    });
    
    // Handle window resize
    $(window).on('resize', Base47Theme.debounce(function() {
        // Recalculate sticky header
        if ($('body').hasClass('sticky-header')) {
            var $header = $('header, .site-header');
            var headerHeight = $header.outerHeight();
            
            if ($header.hasClass('is-sticky')) {
                $('body').css('padding-top', headerHeight + 'px');
            }
        }
    }, 250));
    
    // Export for global access
    window.Base47Theme = Base47Theme;

})(jQuery);

// CSS for scroll to top button and other JS-dependent styles
document.addEventListener('DOMContentLoaded', function() {
    var style = document.createElement('style');
    style.textContent = `
        .scroll-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: var(--primary-color, #ff4d00);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .scroll-to-top.visible {
            opacity: 1;
            visibility: visible;
        }
        
        .scroll-to-top:hover {
            background: var(--secondary-color, #333333);
            transform: translateY(-2px);
        }
        
        .mobile-menu-open {
            overflow: hidden;
        }
        
        .is-sticky {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .lazy {
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .lazy.loaded {
            opacity: 1;
        }
        
        /* Focus styles for accessibility */
        .skip-link:focus {
            position: absolute;
            left: 6px;
            top: 7px;
            z-index: 999999;
            padding: 8px 16px;
            background: var(--primary-color, #ff4d00);
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }
        
        .menu a:focus {
            outline: 2px solid var(--primary-color, #ff4d00);
            outline-offset: 2px;
        }
    `;
    document.head.appendChild(style);
});