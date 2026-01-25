/**
 * Base47 Theme Customizer Live Preview
 * Real-time preview of customizer changes
 */

(function($) {
    'use strict';

    // Update CSS custom properties for live preview
    function updateCSSProperty(property, value) {
        document.documentElement.style.setProperty(property, value);
    }

    // Logo Width
    wp.customize('base47_logo_width', function(value) {
        value.bind(function(newval) {
            $('.custom-logo').css('width', newval + 'px');
        });
    });

    // Logo Height
    wp.customize('base47_logo_height', function(value) {
        value.bind(function(newval) {
            $('.custom-logo').css('height', newval + 'px');
        });
    });

    // Primary Color
    wp.customize('base47_primary_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--primary-color', newval);
            $('<style id="base47-primary-color">:root { --primary-color: ' + newval + '; }</style>').appendTo('head');
            $('#base47-primary-color').remove();
            $('<style id="base47-primary-color">:root { --primary-color: ' + newval + '; }</style>').appendTo('head');
        });
    });

    // Secondary Color
    wp.customize('base47_secondary_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--secondary-color', newval);
            $('<style id="base47-secondary-color">:root { --secondary-color: ' + newval + '; }</style>').appendTo('head');
            $('#base47-secondary-color').remove();
            $('<style id="base47-secondary-color">:root { --secondary-color: ' + newval + '; }</style>').appendTo('head');
        });
    });

    // Text Color
    wp.customize('base47_text_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--text-color', newval);
            $('body, p').css('color', newval);
        });
    });

    // Link Color
    wp.customize('base47_link_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--link-color', newval);
            $('a').css('color', newval);
        });
    });

    // Button Color
    wp.customize('base47_button_color', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--button-color', newval);
            $('.btn, button, input[type="submit"]').css('background-color', newval);
        });
    });

    // Body Font
    wp.customize('base47_body_font', function(value) {
        value.bind(function(newval) {
            // Load Google Font
            if (newval && newval !== 'inherit') {
                var fontUrl = 'https://fonts.googleapis.com/css2?family=' + newval.replace(' ', '+') + ':wght@300;400;500;600;700&display=swap';
                if (!$('link[href="' + fontUrl + '"]').length) {
                    $('head').append('<link href="' + fontUrl + '" rel="stylesheet">');
                }
                $('body').css('font-family', '"' + newval + '", sans-serif');
            }
        });
    });

    // Heading Font
    wp.customize('base47_heading_font', function(value) {
        value.bind(function(newval) {
            // Load Google Font
            if (newval && newval !== 'inherit') {
                var fontUrl = 'https://fonts.googleapis.com/css2?family=' + newval.replace(' ', '+') + ':wght@300;400;500;600;700&display=swap';
                if (!$('link[href="' + fontUrl + '"]').length) {
                    $('head').append('<link href="' + fontUrl + '" rel="stylesheet">');
                }
                $('h1, h2, h3, h4, h5, h6').css('font-family', '"' + newval + '", sans-serif');
            }
        });
    });

    // Body Font Size
    wp.customize('base47_body_font_size', function(value) {
        value.bind(function(newval) {
            $('body').css('font-size', newval + 'px');
        });
    });

    // Heading Font Size
    wp.customize('base47_heading_font_size', function(value) {
        value.bind(function(newval) {
            $('h1').css('font-size', newval + 'px');
        });
    });

    // Container Width
    wp.customize('base47_container_width', function(value) {
        value.bind(function(newval) {
            updateCSSProperty('--container-width', newval + 'px');
            $('.container, .wp-block').css('max-width', newval + 'px');
        });
    });

    // Header Background Color
    wp.customize('base47_header_bg_color', function(value) {
        value.bind(function(newval) {
            $('header, .site-header').css('background-color', newval);
        });
    });

    // Footer Background Color
    wp.customize('base47_footer_bg_color', function(value) {
        value.bind(function(newval) {
            $('footer, .site-footer').css('background-color', newval);
        });
    });

    // Footer Text Color
    wp.customize('base47_footer_text_color', function(value) {
        value.bind(function(newval) {
            $('footer, .site-footer').css('color', newval);
            $('footer a, .site-footer a').css('color', newval);
        });
    });

    // Header Layout
    wp.customize('base47_header_layout', function(value) {
        value.bind(function(newval) {
            $('body').removeClass('header-layout-1 header-layout-2 header-layout-3 header-layout-4');
            $('body').addClass('header-' + newval);
        });
    });

    // Footer Layout
    wp.customize('base47_footer_layout', function(value) {
        value.bind(function(newval) {
            $('body').removeClass('footer-layout-1 footer-layout-2 footer-layout-3 footer-layout-4');
            $('body').addClass('footer-' + newval);
        });
    });

    // Site Layout
    wp.customize('base47_site_layout', function(value) {
        value.bind(function(newval) {
            $('body').removeClass('site-layout-full-width site-layout-boxed');
            $('body').addClass('site-layout-' + newval);
        });
    });

    // Sidebar Position
    wp.customize('base47_sidebar_position', function(value) {
        value.bind(function(newval) {
            $('body').removeClass('sidebar-none sidebar-left sidebar-right');
            $('body').addClass('sidebar-' + newval);
        });
    });

    // Sticky Header
    wp.customize('base47_sticky_header', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('body').addClass('sticky-header');
                $('header, .site-header').addClass('sticky');
            } else {
                $('body').removeClass('sticky-header');
                $('header, .site-header').removeClass('sticky');
            }
        });
    });

    // Transparent Header
    wp.customize('base47_transparent_header', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('body').addClass('transparent-header');
                $('header, .site-header').addClass('transparent');
            } else {
                $('body').removeClass('transparent-header');
                $('header, .site-header').removeClass('transparent');
            }
        });
    });

    // Blog Layout
    wp.customize('base47_blog_layout', function(value) {
        value.bind(function(newval) {
            $('body').removeClass('blog-layout-list blog-layout-grid blog-layout-masonry');
            $('body').addClass('blog-layout-' + newval);
        });
    });

})(jQuery);