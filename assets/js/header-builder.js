/**
 * Nexus Header Builder JavaScript
 * Handles sticky header, mobile menu, and interactive elements
 */

(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        NexusHeader.init();
    });

    var NexusHeader = {
        
        init: function() {
            this.stickyHeader();
            this.mobileMenu();
            this.searchToggle();
            this.smoothScroll();
            this.headerResize();
        },

        /**
         * Sticky Header Functionality
         */
        stickyHeader: function() {
            var $header = $('.nexus-header');
            var $window = $(window);
            var headerHeight = $header.outerHeight();
            var scrollThreshold = headerHeight;

            if (!$header.hasClass('sticky-enabled')) {
                return;
            }

            $window.on('scroll', function() {
                var scrollTop = $window.scrollTop();
                
                if (scrollTop > scrollThreshold) {
                    if (!$header.hasClass('sticky')) {
                        $header.addClass('sticky');
                        $('body').css('padding-top', headerHeight + 'px');
                    }
                } else {
                    if ($header.hasClass('sticky')) {
                        $header.removeClass('sticky');
                        $('body').css('padding-top', '0');
                    }
                }
            });

            // Trigger scroll event on load
            $window.trigger('scroll');
        },

        /**
         * Mobile Menu Toggle
         */
        mobileMenu: function() {
            var $toggle = $('.mobile-menu-toggle');
            var $body = $('body');
            var $nav = $('.primary-navigation');

            $toggle.on('click', function(e) {
                e.preventDefault();
                
                $body.toggleClass('mobile-menu-active');
                
                // Update aria attributes for accessibility
                var isExpanded = $body.hasClass('mobile-menu-active');
                $toggle.attr('aria-expanded', isExpanded);
                
                // Prevent body scroll when menu is open
                if (isExpanded) {
                    $body.addClass('menu-open');
                } else {
                    $body.removeClass('menu-open');
                }
            });

            // Close menu when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.nexus-header').length && $body.hasClass('mobile-menu-active')) {
                    $body.removeClass('mobile-menu-active menu-open');
                    $toggle.attr('aria-expanded', 'false');
                }
            });

            // Close menu on escape key
            $(document).on('keydown', function(e) {
                if (e.keyCode === 27 && $body.hasClass('mobile-menu-active')) {
                    $body.removeClass('mobile-menu-active menu-open');
                    $toggle.attr('aria-expanded', 'false');
                    $toggle.focus();
                }
            });

            // Handle submenu toggles on mobile
            $('.nexus-nav .menu-item-has-children > a').on('click', function(e) {
                if ($(window).width() <= 768) {
                    e.preventDefault();
                    $(this).next('.sub-menu').slideToggle(300);
                    $(this).parent().toggleClass('submenu-open');
                }
            });
        },

        /**
         * Search Toggle Functionality
         */
        searchToggle: function() {
            var $searchToggle = $('.search-toggle');
            var $searchForm = $('.header-search-form');
            var $searchInput = $searchForm.find('input[type="search"]');

            // Create search form if it doesn't exist
            if ($searchToggle.length && !$searchForm.length) {
                var searchFormHTML = '<div class="header-search-form">' +
                    '<form role="search" method="get" action="' + nexusHeader.homeUrl + '">' +
                    '<input type="search" placeholder="' + nexusHeader.searchPlaceholder + '" name="s" />' +
                    '<button type="submit"><i class="fas fa-search"></i></button>' +
                    '</form>' +
                    '</div>';
                
                $searchToggle.closest('.header-search').append(searchFormHTML);
                $searchForm = $('.header-search-form');
                $searchInput = $searchForm.find('input[type="search"]');
            }

            $searchToggle.on('click', function(e) {
                e.preventDefault();
                
                $searchForm.toggleClass('active');
                
                if ($searchForm.hasClass('active')) {
                    $searchInput.focus();
                }
            });

            // Close search on escape or outside click
            $(document).on('keydown click', function(e) {
                if (e.keyCode === 27 || !$(e.target).closest('.header-search').length) {
                    $searchForm.removeClass('active');
                }
            });
        },

        /**
         * Smooth Scroll for Anchor Links
         */
        smoothScroll: function() {
            $('a[href*="#"]:not([href="#"])').on('click', function(e) {
                var target = $(this.hash);
                
                if (target.length) {
                    e.preventDefault();
                    
                    var headerHeight = $('.nexus-header.sticky').outerHeight() || 0;
                    var scrollTop = target.offset().top - headerHeight - 20;
                    
                    $('html, body').animate({
                        scrollTop: scrollTop
                    }, 800, 'easeInOutQuart');
                }
            });
        },

        /**
         * Header Resize Handler
         */
        headerResize: function() {
            var $window = $(window);
            var $header = $('.nexus-header');
            
            $window.on('resize', function() {
                // Close mobile menu on resize to desktop
                if ($window.width() > 768) {
                    $('body').removeClass('mobile-menu-active menu-open');
                    $('.mobile-menu-toggle').attr('aria-expanded', 'false');
                }
                
                // Recalculate sticky header
                if ($header.hasClass('sticky-enabled')) {
                    var headerHeight = $header.outerHeight();
                    if ($header.hasClass('sticky')) {
                        $('body').css('padding-top', headerHeight + 'px');
                    }
                }
            });
        }
    };

    // Expose to global scope
    window.NexusHeader = NexusHeader;

})(jQuery);

/**
 * Header Search Form Styles (Injected via JS)
 */
jQuery(document).ready(function($) {
    
    // Add search form styles
    var searchStyles = `
        <style id="nexus-header-search-styles">
        .header-search-form {
            position: absolute;
            top: 100%;
            right: 0;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 20px;
            min-width: 300px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .header-search-form.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .header-search-form form {
            display: flex;
            gap: 10px;
        }
        
        .header-search-form input[type="search"] {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        
        .header-search-form input[type="search"]:focus {
            border-color: var(--primary-color, #ff4d00);
        }
        
        .header-search-form button {
            padding: 12px 16px;
            background-color: var(--primary-color, #ff4d00);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .header-search-form button:hover {
            background-color: #e63900;
        }
        
        @media (max-width: 768px) {
            .header-search-form {
                position: fixed;
                top: 60px;
                left: 20px;
                right: 20px;
                min-width: auto;
            }
        }
        </style>
    `;
    
    if (!$('#nexus-header-search-styles').length) {
        $('head').append(searchStyles);
    }
});

/**
 * Easing function for smooth scroll
 */
jQuery.easing.easeInOutQuart = function (x, t, b, c, d) {
    if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
    return -c/2 * ((t-=2)*t*t*t - 2) + b;
};

/**
 * Accessibility Enhancements
 */
jQuery(document).ready(function($) {
    
    // Add ARIA labels and roles
    $('.nexus-nav').attr('role', 'navigation');
    $('.mobile-menu-toggle').attr('aria-label', 'Toggle navigation menu');
    $('.search-toggle').attr('aria-label', 'Toggle search form');
    
    // Keyboard navigation for dropdowns
    $('.nexus-nav a').on('keydown', function(e) {
        var $this = $(this);
        var $parent = $this.parent();
        var $submenu = $parent.find('.sub-menu');
        
        switch(e.keyCode) {
            case 13: // Enter
            case 32: // Space
                if ($submenu.length) {
                    e.preventDefault();
                    $submenu.toggle();
                    $submenu.find('a').first().focus();
                }
                break;
            case 27: // Escape
                if ($submenu.length && $submenu.is(':visible')) {
                    e.preventDefault();
                    $submenu.hide();
                    $this.focus();
                }
                break;
            case 38: // Up arrow
                e.preventDefault();
                $parent.prev().find('a').focus();
                break;
            case 40: // Down arrow
                e.preventDefault();
                if ($submenu.length && !$submenu.is(':visible')) {
                    $submenu.show();
                    $submenu.find('a').first().focus();
                } else {
                    $parent.next().find('a').focus();
                }
                break;
        }
    });
    
    // Focus management for mobile menu
    $('.mobile-menu-toggle').on('keydown', function(e) {
        if (e.keyCode === 13 || e.keyCode === 32) {
            e.preventDefault();
            $(this).click();
            
            if ($('body').hasClass('mobile-menu-active')) {
                $('.nexus-nav a').first().focus();
            }
        }
    });
});

/**
 * Performance Optimizations
 */
jQuery(document).ready(function($) {
    
    // Throttle scroll events
    var throttle = function(func, limit) {
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
    };
    
    // Apply throttling to scroll events
    $(window).off('scroll.nexusHeader').on('scroll.nexusHeader', throttle(function() {
        // Sticky header logic is already handled in NexusHeader.stickyHeader()
    }, 16)); // ~60fps
    
    // Debounce resize events
    var debounce = function(func, wait) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    };
    
    $(window).off('resize.nexusHeader').on('resize.nexusHeader', debounce(function() {
        // Resize logic is already handled in NexusHeader.headerResize()
    }, 250));
});