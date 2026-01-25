<?php
/**
 * Base47 Theme Page Builder Compatibility
 * Support for Elementor, Gutenberg, Beaver Builder, etc.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Compatibility
 */
function base47_elementor_support() {
    // Add Elementor theme support
    add_theme_support( 'elementor' );
    
    // Add Elementor Pro features support
    add_theme_support( 'elementor-pro' );
    
    // Set Elementor canvas template
    add_filter( 'elementor/theme/get_location_templates/template_id', function( $template_id ) {
        if ( 'canvas' === $template_id ) {
            return get_template_directory() . '/template-canvas.php';
        }
        return $template_id;
    });
}

// Check if Elementor is active
if ( get_theme_mod( 'base47_elementor_compat', true ) ) {
    add_action( 'after_setup_theme', 'base47_elementor_support' );
}

/**
 * Elementor Canvas Mode Integration
 */
function base47_elementor_canvas_integration() {
    // If Elementor canvas is detected, use our canvas mode
    if ( class_exists( '\Elementor\Plugin' ) ) {
        $elementor = \Elementor\Plugin::$instance;
        
        if ( $elementor->preview->is_preview_mode() ) {
            add_filter( 'body_class', function( $classes ) {
                $classes[] = 'base47-canvas';
                return $classes;
            });
        }
    }
}
add_action( 'wp', 'base47_elementor_canvas_integration' );

/**
 * Gutenberg Block Editor Enhancements
 */
function base47_gutenberg_support() {
    // Add theme support for wide and full alignment
    add_theme_support( 'align-wide' );
    
    // Add theme support for block color palettes
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => __( 'Primary Color', 'base47-theme' ),
            'slug'  => 'primary',
            'color' => get_theme_mod( 'base47_primary_color', '#ff4d00' ),
        ),
        array(
            'name'  => __( 'Secondary Color', 'base47-theme' ),
            'slug'  => 'secondary', 
            'color' => get_theme_mod( 'base47_secondary_color', '#333333' ),
        ),
        array(
            'name'  => __( 'Text Color', 'base47-theme' ),
            'slug'  => 'text',
            'color' => get_theme_mod( 'base47_text_color', '#666666' ),
        ),
    ) );
    
    // Add theme support for custom font sizes
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name' => __( 'Small', 'base47-theme' ),
            'size' => 14,
            'slug' => 'small'
        ),
        array(
            'name' => __( 'Normal', 'base47-theme' ),
            'size' => 16,
            'slug' => 'normal'
        ),
        array(
            'name' => __( 'Large', 'base47-theme' ),
            'size' => 24,
            'slug' => 'large'
        ),
        array(
            'name' => __( 'Extra Large', 'base47-theme' ),
            'size' => 32,
            'slug' => 'extra-large'
        ),
    ) );
    
    // Disable custom colors and font sizes if needed
    add_theme_support( 'disable-custom-colors' );
    add_theme_support( 'disable-custom-font-sizes' );
}

// Check if Gutenberg enhancements are enabled
if ( get_theme_mod( 'base47_gutenberg_enhancements', true ) ) {
    add_action( 'after_setup_theme', 'base47_gutenberg_support' );
}

/**
 * Beaver Builder Compatibility
 */
function base47_beaver_builder_support() {
    // Add Beaver Builder theme support
    add_theme_support( 'fl-builder' );
    
    // Set Beaver Builder canvas template
    add_filter( 'fl_builder_render_css', function( $css, $nodes, $global_settings ) {
        // Add custom CSS for Beaver Builder compatibility
        $css .= '
        .fl-builder-content-editing .entry-content {
            margin: 0 !important;
            padding: 0 !important;
        }
        ';
        return $css;
    }, 10, 3 );
}

// Check if Beaver Builder compatibility is enabled
if ( get_theme_mod( 'base47_beaver_builder_compat', true ) ) {
    add_action( 'after_setup_theme', 'base47_beaver_builder_support' );
}

/**
 * Visual Composer (WPBakery) Compatibility
 */
function base47_visual_composer_support() {
    // Add Visual Composer theme support
    if ( class_exists( 'Vc_Manager' ) ) {
        add_action( 'vc_before_init', function() {
            vc_set_as_theme();
        });
    }
}
add_action( 'after_setup_theme', 'base47_visual_composer_support' );

/**
 * Divi Builder Compatibility
 */
function base47_divi_support() {
    // Add Divi theme support
    if ( class_exists( 'ET_Builder_Plugin' ) ) {
        add_filter( 'body_class', function( $classes ) {
            if ( et_pb_is_pagebuilder_used( get_the_ID() ) ) {
                $classes[] = 'base47-canvas';
            }
            return $classes;
        });
    }
}
add_action( 'wp', 'base47_divi_support' );

/**
 * Oxygen Builder Compatibility
 */
function base47_oxygen_support() {
    // Add Oxygen theme support
    if ( class_exists( 'CT_Component' ) ) {
        add_filter( 'body_class', function( $classes ) {
            if ( get_post_meta( get_the_ID(), 'ct_builder_shortcodes', true ) ) {
                $classes[] = 'base47-canvas';
            }
            return $classes;
        });
    }
}
add_action( 'wp', 'base47_oxygen_support' );

/**
 * Bricks Builder Compatibility
 */
function base47_bricks_support() {
    // Add Bricks theme support
    if ( class_exists( 'Bricks\Database' ) ) {
        add_filter( 'body_class', function( $classes ) {
            if ( \Bricks\Database::get_data( get_the_ID() ) ) {
                $classes[] = 'base47-canvas';
            }
            return $classes;
        });
    }
}
add_action( 'wp', 'base47_bricks_support' );

/**
 * Thrive Architect Compatibility
 */
function base47_thrive_architect_support() {
    // Add Thrive Architect theme support
    if ( class_exists( 'TCB_Post' ) ) {
        add_filter( 'body_class', function( $classes ) {
            if ( TCB_Post::is_landing_page( get_the_ID() ) ) {
                $classes[] = 'base47-canvas';
            }
            return $classes;
        });
    }
}
add_action( 'wp', 'base47_thrive_architect_support' );

/**
 * Page Builder Detection and Canvas Mode Auto-Switch
 */
function base47_auto_canvas_for_page_builders() {
    if ( ! is_singular() ) {
        return;
    }
    
    $post_id = get_the_ID();
    $page_builder_detected = false;
    
    // Check for various page builders
    $page_builders = array(
        'elementor' => function( $post_id ) {
            return get_post_meta( $post_id, '_elementor_edit_mode', true ) === 'builder';
        },
        'beaver_builder' => function( $post_id ) {
            return get_post_meta( $post_id, '_fl_builder_enabled', true );
        },
        'visual_composer' => function( $post_id ) {
            return get_post_meta( $post_id, '_wpb_vc_js_status', true );
        },
        'divi' => function( $post_id ) {
            return function_exists( 'et_pb_is_pagebuilder_used' ) && et_pb_is_pagebuilder_used( $post_id );
        },
        'oxygen' => function( $post_id ) {
            return get_post_meta( $post_id, 'ct_builder_shortcodes', true );
        },
        'bricks' => function( $post_id ) {
            return class_exists( 'Bricks\Database' ) && \Bricks\Database::get_data( $post_id );
        },
    );
    
    foreach ( $page_builders as $builder => $check_function ) {
        if ( $check_function( $post_id ) ) {
            $page_builder_detected = true;
            break;
        }
    }
    
    // Auto-enable canvas mode for page builder pages
    if ( $page_builder_detected && get_theme_mod( 'base47_auto_canvas_for_builders', true ) ) {
        add_filter( 'body_class', function( $classes ) {
            $classes[] = 'base47-canvas';
            return $classes;
        });
    }
}
add_action( 'wp', 'base47_auto_canvas_for_page_builders' );

/**
 * Enqueue page builder compatibility CSS
 */
function base47_page_builder_styles() {
    if ( ! is_admin() ) {
        wp_enqueue_style(
            'base47-page-builders',
            get_template_directory_uri() . '/assets/css/page-builders.css',
            array( 'base47-style' ),
            base47_theme_get_version()
        );
    }
}
add_action( 'wp_enqueue_scripts', 'base47_page_builder_styles' );

/**
 * Add page builder body classes
 */
function base47_page_builder_body_classes( $classes ) {
    if ( ! is_singular() ) {
        return $classes;
    }
    
    $post_id = get_the_ID();
    
    // Add specific page builder classes
    if ( get_post_meta( $post_id, '_elementor_edit_mode', true ) === 'builder' ) {
        $classes[] = 'elementor-page';
    }
    
    if ( get_post_meta( $post_id, '_fl_builder_enabled', true ) ) {
        $classes[] = 'fl-builder-page';
    }
    
    if ( get_post_meta( $post_id, '_wpb_vc_js_status', true ) ) {
        $classes[] = 'vc-page';
    }
    
    if ( function_exists( 'et_pb_is_pagebuilder_used' ) && et_pb_is_pagebuilder_used( $post_id ) ) {
        $classes[] = 'divi-page';
    }
    
    return $classes;
}
add_filter( 'body_class', 'base47_page_builder_body_classes' );