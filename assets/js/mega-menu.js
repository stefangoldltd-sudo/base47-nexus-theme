/**
 * Nexus Mega Menu JavaScript
 * Handles mega menu interactions, animations, and responsive behavior
 */

(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        NexusMegaMenu.init();
    });

    var NexusMegaMenu = {
        
        settings: {
            animation: 'fade',
            mobileBreakpoint: 768,
            hoverDelay: 150,
            hideDelay: 300
        },

        init: function() {
            // Get settings from localized script
            if (typeof nexusMegaMenu !== 'undefined') {
                this.settings = $.extend(this.settings, nexusMegaMenu);
            }

            this.setupMegaMenus();
            this.handleHoverEvents();
            this.handleClickEvents();
            this.handleKeyboardNavigation();
            this.handleMobileMenu();
            this.handleResize();
        },

        /**
         * Setup Mega Menu Structure
         */
        setupMegaMenus: function() {
            var self = this;
            
            $('.has-mega-menu').each(function() {
                var $menuItem = $(this);
                var $megaMenu = $menuItem.find('.nexus-mega-menu');
                var columns = $menuItem.attr('class').match(/mega-columns-(\d+)/);
                
                if ($megaMenu.length) {
                    // Add animation class
                    $megaMenu.addClass(self.settings.animation);
                    
                    // Set up columns
                    if (columns) {
                        var columnCount = parseInt(columns[1]);
                        self.setupColumns($megaMenu, columnCount);
                    }
                    
                    // Add ARIA attributes
                    $megaMenu.attr({
                        'role': 'menu',
                        'aria-hidden': 'true'
                    });
                    
                    $menuItem.find('> a').attr({
                        'aria-haspopup': 'true',
                        'aria-expanded': 'false'
                    });
                }
            });
        },

        /**
         * Setup Mega Menu Columns
         */
        setupColumns: function($megaMenu, columnCount) {
            var $columns = $megaMenu.find('.mega-menu-column');
            var $container = $megaMenu.find('.mega-menu-columns');
            
            // Set column widths based on count
            var columnWidth = 100 / columnCount;
            $columns.css('flex-basis', columnWidth + '%');
            
            // Add column classes
            $container.addClass('columns-' + columnCount);
        },

        /**
         * Handle Hover Events (Desktop)
         */
        handleHoverEvents: function() {
            var self = this;
            var hoverTimer, hideTimer;

            $('.has-mega-menu').on('mouseenter', function() {
                if ($(window).width() <= self.settings.mobileBreakpoint) {
                    return;
                }

                var $menuItem = $(this);
                var $megaMenu = $menuItem.find('.nexus-mega-menu');
                
                clearTimeout(hideTimer);
                
                hoverTimer = setTimeout(function() {
                    self.showMegaMenu($menuItem, $megaMenu);
                }, self.settings.hoverDelay);
                
            }).on('mouseleave', function() {
                if ($(window).width() <= self.settings.mobileBreakpoint) {
                    return;
                }

                var $menuItem = $(this);
                var $megaMenu = $menuItem.find('.nexus-mega-menu');
                
                clearTimeout(hoverTimer);
                
                hideTimer = setTimeout(function() {
                    self.hideMegaMenu($menuItem, $megaMenu);
                }, self.settings.hideDelay);
            });
        },

        /**
         * Handle Click Events (Mobile)
         */
        handleClickEvents: function() {
            var self = this;

            $('.has-mega-menu > a').on('click', function(e) {
                if ($(window).width() > self.settings.mobileBreakpoint) {
                    return;
                }

                e.preventDefault();
                
                var $link = $(this);
                var $menuItem = $link.parent();
                var $megaMenu = $menuItem.find('.nexus-mega-menu');
                
                if ($megaMenu.hasClass('active')) {
                    self.hideMegaMenu($menuItem, $megaMenu);
                } else {
                    // Hide other open mega menus
                    $('.nexus-mega-menu.active').each(function() {
                        var $otherMenu = $(this);
                        var $otherItem = $otherMenu.closest('.has-mega-menu');
                        self.hideMegaMenu($otherItem, $otherMenu);
                    });
                    
                    self.showMegaMenu($menuItem, $megaMenu);
                }
            });
        },

        /**
         * Show Mega Menu
         */
        showMegaMenu: function($menuItem, $megaMenu) {
            var self = this;
            
            if ($megaMenu.hasClass('active')) {
                return;
            }

            // Position mega menu
            this.positionMegaMenu($megaMenu);
            
            // Show with animation
            $megaMenu.addClass('active');
            $megaMenu.attr('aria-hidden', 'false');
            $menuItem.find('> a').attr('aria-expanded', 'true');
            
            // Apply animation
            switch (this.settings.animation) {
                case 'slide':
                    $megaMenu.addClass('slide-down');
                    break;
                case 'zoom':
                    $megaMenu.addClass('zoom-in');
                    break;
                default:
                    $megaMenu.addClass('fade-in');
            }
            
            // Trigger custom event
            $menuItem.trigger('nexus:megamenu:show');
        },

        /**
         * Hide Mega Menu
         */
        hideMegaMenu: function($menuItem, $megaMenu) {
            if (!$megaMenu.hasClass('active')) {
                return;
            }

            $megaMenu.removeClass('active fade-in slide-down zoom-in');
            $megaMenu.attr('aria-hidden', 'true');
            $menuItem.find('> a').attr('aria-expanded', 'false');
            
            // Trigger custom event
            $menuItem.trigger('nexus:megamenu:hide');
        },

        /**
         * Position Mega Menu
         */
        positionMegaMenu: function($megaMenu) {
            var $window = $(window);
            var windowWidth = $window.width();
            var $menuItem = $megaMenu.closest('.has-mega-menu');
            var menuItemOffset = $menuItem.offset();
            var megaMenuWidth = $megaMenu.outerWidth();
            
            // Reset positioning
            $megaMenu.css({
                'left': '',
                'right': '',
                'transform': ''
            });
            
            // Check if mega menu fits in viewport
            var leftEdge = menuItemOffset.left - (megaMenuWidth / 2) + ($menuItem.outerWidth() / 2);
            var rightEdge = leftEdge + megaMenuWidth;
            
            if (leftEdge < 0) {
                // Align to left edge of viewport
                $megaMenu.css({
                    'left': '20px',
                    'transform': 'none'
                });
            } else if (rightEdge > windowWidth) {
                // Align to right edge of viewport
                $megaMenu.css({
                    'right': '20px',
                    'left': 'auto',
                    'transform': 'none'
                });
            }
        },

        /**
         * Handle Keyboard Navigation
         */
        handleKeyboardNavigation: function() {
            var self = this;

            $('.has-mega-menu > a').on('keydown', function(e) {
                var $link = $(this);
                var $menuItem = $link.parent();
                var $megaMenu = $menuItem.find('.nexus-mega-menu');
                
                switch(e.keyCode) {
                    case 13: // Enter
                    case 32: // Space
                        e.preventDefault();
                        if ($megaMenu.hasClass('active')) {
                            self.hideMegaMenu($menuItem, $megaMenu);
                        } else {
                            self.showMegaMenu($menuItem, $megaMenu);
                            // Focus first link in mega menu
                            setTimeout(function() {
                                $megaMenu.find('a').first().focus();
                            }, 100);
                        }
                        break;
                    case 27: // Escape
                        if ($megaMenu.hasClass('active')) {
                            e.preventDefault();
                            self.hideMegaMenu($menuItem, $megaMenu);
                            $link.focus();
                        }
                        break;
                    case 40: // Down arrow
                        if (!$megaMenu.hasClass('active')) {
                            e.preventDefault();
                            self.showMegaMenu($menuItem, $megaMenu);
                            setTimeout(function() {
                                $megaMenu.find('a').first().focus();
                            }, 100);
                        }
                        break;
                }
            });

            // Navigation within mega menu
            $('.nexus-mega-menu a').on('keydown', function(e) {
                var $link = $(this);
                var $megaMenu = $link.closest('.nexus-mega-menu');
                var $menuItem = $megaMenu.closest('.has-mega-menu');
                var $allLinks = $megaMenu.find('a');
                var currentIndex = $allLinks.index($link);
                
                switch(e.keyCode) {
                    case 27: // Escape
                        e.preventDefault();
                        self.hideMegaMenu($menuItem, $megaMenu);
                        $menuItem.find('> a').focus();
                        break;
                    case 38: // Up arrow
                        e.preventDefault();
                        if (currentIndex > 0) {
                            $allLinks.eq(currentIndex - 1).focus();
                        } else {
                            $menuItem.find('> a').focus();
                        }
                        break;
                    case 40: // Down arrow
                        e.preventDefault();
                        if (currentIndex < $allLinks.length - 1) {
                            $allLinks.eq(currentIndex + 1).focus();
                        }
                        break;
                    case 37: // Left arrow
                    case 39: // Right arrow
                        e.preventDefault();
                        var $currentColumn = $link.closest('.mega-menu-column');
                        var $columns = $megaMenu.find('.mega-menu-column');
                        var columnIndex = $columns.index($currentColumn);
                        var targetColumn = e.keyCode === 37 ? columnIndex - 1 : columnIndex + 1;
                        
                        if (targetColumn >= 0 && targetColumn < $columns.length) {
                            $columns.eq(targetColumn).find('a').first().focus();
                        }
                        break;
                }
            });
        },

        /**
         * Handle Mobile Menu Behavior
         */
        handleMobileMenu: function() {
            var self = this;

            $(window).on('resize', function() {
                if ($(window).width() > self.settings.mobileBreakpoint) {
                    // Desktop: Hide all mega menus
                    $('.nexus-mega-menu.active').each(function() {
                        var $megaMenu = $(this);
                        var $menuItem = $megaMenu.closest('.has-mega-menu');
                        self.hideMegaMenu($menuItem, $megaMenu);
                    });
                }
            });
        },

        /**
         * Handle Window Resize
         */
        handleResize: function() {
            var self = this;
            var resizeTimer;

            $(window).on('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Reposition visible mega menus
                    $('.nexus-mega-menu.active').each(function() {
                        self.positionMegaMenu($(this));
                    });
                }, 250);
            });
        },

        /**
         * Public Methods
         */
        show: function(selector) {
            var $menuItem = $(selector);
            var $megaMenu = $menuItem.find('.nexus-mega-menu');
            this.showMegaMenu($menuItem, $megaMenu);
        },

        hide: function(selector) {
            var $menuItem = $(selector);
            var $megaMenu = $menuItem.find('.nexus-mega-menu');
            this.hideMegaMenu($menuItem, $megaMenu);
        },

        hideAll: function() {
            var self = this;
            $('.nexus-mega-menu.active').each(function() {
                var $megaMenu = $(this);
                var $menuItem = $megaMenu.closest('.has-mega-menu');
                self.hideMegaMenu($menuItem, $megaMenu);
            });
        }
    };

    // Expose to global scope
    window.NexusMegaMenu = NexusMegaMenu;

    // Close mega menus when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.has-mega-menu').length) {
            NexusMegaMenu.hideAll();
        }
    });

    // Close mega menus on escape key
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27) {
            NexusMegaMenu.hideAll();
        }
    });

})(jQuery);

/**
 * Mega Menu Accessibility Enhancements
 */
jQuery(document).ready(function($) {
    
    // Add screen reader text for mega menu indicators
    $('.has-mega-menu > a').each(function() {
        var $link = $(this);
        if (!$link.find('.screen-reader-text').length) {
            $link.append('<span class="screen-reader-text"> (has submenu)</span>');
        }
    });
    
    // Add focus management for better accessibility
    $('.nexus-mega-menu').on('focusin', function() {
        $(this).addClass('focus-within');
    }).on('focusout', function() {
        var $megaMenu = $(this);
        setTimeout(function() {
            if (!$megaMenu.find(':focus').length) {
                $megaMenu.removeClass('focus-within');
            }
        }, 100);
    });
});

/**
 * Mega Menu Performance Optimizations
 */
jQuery(document).ready(function($) {
    
    // Lazy load mega menu images
    $('.mega-menu-image img').each(function() {
        var $img = $(this);
        var src = $img.attr('src');
        
        if (src) {
            $img.attr('data-src', src).removeAttr('src').addClass('lazy-load');
        }
    });
    
    // Load images when mega menu is shown
    $(document).on('nexus:megamenu:show', function(e) {
        var $menuItem = $(e.target);
        $menuItem.find('.lazy-load').each(function() {
            var $img = $(this);
            var src = $img.attr('data-src');
            
            if (src) {
                $img.attr('src', src).removeClass('lazy-load');
            }
        });
    });
    
    // Preload mega menu content on hover (desktop only)
    $('.has-mega-menu').one('mouseenter', function() {
        if ($(window).width() > 768) {
            var $menuItem = $(this);
            $menuItem.find('.lazy-load').each(function() {
                var $img = $(this);
                var src = $img.attr('data-src');
                
                if (src) {
                    var preloadImg = new Image();
                    preloadImg.onload = function() {
                        $img.attr('src', src).removeClass('lazy-load');
                    };
                    preloadImg.src = src;
                }
            });
        }
    });
});

/**
 * Mega Menu Analytics (Optional)
 */
jQuery(document).ready(function($) {
    
    // Track mega menu interactions
    $(document).on('nexus:megamenu:show', function(e) {
        var $menuItem = $(e.target);
        var menuTitle = $menuItem.find('> a').text().trim();
        
        // Google Analytics 4
        if (typeof gtag !== 'undefined') {
            gtag('event', 'mega_menu_open', {
                'menu_title': menuTitle,
                'event_category': 'navigation'
            });
        }
        
        // Custom analytics
        if (typeof nexusAnalytics !== 'undefined' && nexusAnalytics.trackMegaMenu) {
            nexusAnalytics.track('mega_menu_open', {
                menu: menuTitle
            });
        }
    });
    
    // Track mega menu link clicks
    $('.nexus-mega-menu a').on('click', function() {
        var $link = $(this);
        var linkText = $link.text().trim();
        var $menuItem = $link.closest('.has-mega-menu');
        var menuTitle = $menuItem.find('> a').text().trim();
        
        // Google Analytics 4
        if (typeof gtag !== 'undefined') {
            gtag('event', 'mega_menu_click', {
                'link_text': linkText,
                'menu_title': menuTitle,
                'event_category': 'navigation'
            });
        }
    });
});