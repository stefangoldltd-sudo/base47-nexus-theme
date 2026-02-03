<?php
/**
 * Nexus Theme Functions
 * WordPress.org compliant theme functions
 * 
 * @package Nexus
 * @since 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Helper: get current theme version for cache-busting.
 */
function nexus_theme_get_version() {
    $theme = wp_get_theme();
    // If this is a child theme, get parent version
    if ( $theme->parent() ) {
        $theme = $theme->parent();
    }
    $version = $theme->get( 'Version' );
    return $version ? $version : '4.0.0';
}

/**
 * Theme setup
 */
function nexus_theme_setup() {

    // Load theme textdomain for translations
    load_theme_textdomain( 'nexus-theme', get_template_directory() . '/languages' );

    // Let WordPress handle <title> tag
    add_theme_support( 'title-tag' );

    // Thumbnails support
    add_theme_support( 'post-thumbnails' );

    // HTML5 markup support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Custom logo support
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Custom header support
    add_theme_support( 'custom-header', array(
        'default-image'      => '',
        'width'              => 1200,
        'height'             => 300,
        'flex-height'        => true,
        'flex-width'         => true,
        'uploads'            => true,
        'header-text'        => true,
        'default-text-color' => '000000',
    ) );

    // Custom background support
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );

    // Primary navigation
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'nexus-theme' ),
        'footer'  => __( 'Footer Menu', 'nexus-theme' ),
    ) );

    // WooCommerce support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );

    // Responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Block editor wide alignment
    add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'nexus_theme_setup' );

/**
 * Enqueue theme styles and scripts
 */
function nexus_theme_scripts() {
    $ver = nexus_theme_get_version();
    $dir = get_template_directory_uri();

    // Main theme stylesheet
    wp_enqueue_style(
        'nexus-style',
        get_stylesheet_uri(),
        array(),
        $ver
    );

    // Check if current page uses Canvas Mode template
    $is_canvas = false;
    if ( is_singular() ) {
        $template = get_page_template_slug();
        if ( $template === 'template-canvas.php' || $template === 'template-canvas-app.php' ) {
            $is_canvas = true;
        }
        
        // Check meta box setting
        $canvas_meta = get_post_meta( get_the_ID(), '_nexus_canvas_mode', true );
        $app_canvas_meta = get_post_meta( get_the_ID(), '_nexus_canvas_app_mode', true );
        if ( $canvas_meta === '1' || $app_canvas_meta === '1' ) {
            $is_canvas = true;
        }
    }

    // Load additional CSS only for non-canvas pages
    if ( ! $is_canvas ) {
        // Theme CSS
        $theme_css_path = get_template_directory() . '/assets/css/theme.css';
        if ( file_exists( $theme_css_path ) ) {
            wp_enqueue_style(
                'nexus-theme-css',
                $dir . '/assets/css/theme.css',
                array( 'nexus-style' ),
                $ver
            );
        }

        // WooCommerce CSS
        if ( class_exists( 'WooCommerce' ) ) {
            $woocommerce_path = get_template_directory() . '/assets/css/woocommerce.css';
            if ( file_exists( $woocommerce_path ) ) {
                wp_enqueue_style(
                    'nexus-woocommerce',
                    $dir . '/assets/css/woocommerce.css',
                    array( 'nexus-style' ),
                    $ver
                );
            }
        }
    }

    // Theme JavaScript
    $js_path = get_template_directory() . '/assets/js/theme.js';
    if ( file_exists( $js_path ) ) {
        wp_enqueue_script(
            'nexus-theme',
            $dir . '/assets/js/theme.js',
            array( 'jquery' ),
            $ver,
            true
        );

        // Localize script
        wp_localize_script( 'nexus-theme', 'nexusTheme', array(
            'homeUrl' => home_url( '/' ),
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        ) );
    }

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'nexus_theme_scripts' );

/**
 * Register widget areas
 */
function nexus_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'nexus-theme' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'nexus-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 1', 'nexus-theme' ),
        'id'            => 'footer-1',
        'description'   => __( 'Add widgets here to appear in your footer.', 'nexus-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 2', 'nexus-theme' ),
        'id'            => 'footer-2',
        'description'   => __( 'Add widgets here to appear in your footer.', 'nexus-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 3', 'nexus-theme' ),
        'id'            => 'footer-3',
        'description'   => __( 'Add widgets here to appear in your footer.', 'nexus-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'nexus_widgets_init' );

/**
 * Canvas Mode meta box for manual template selection
 * Note: Actual rendering is handled by Base47 HTML Editor plugin when active
 */
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'nexus_canvas_mode',
        __( 'Canvas Mode', 'nexus-theme' ),
        'nexus_canvas_mode_callback',
        'page',
        'side',
        'high'
    );
} );

function nexus_canvas_mode_callback( $post ) {
    wp_nonce_field( 'nexus_canvas_mode_nonce', 'nexus_canvas_mode_nonce' );
    $canvas_value = get_post_meta( $post->ID, '_nexus_canvas_mode', true );
    $app_value = get_post_meta( $post->ID, '_nexus_canvas_app_mode', true );
    
    // Check if Base47 HTML Editor plugin is active
    $plugin_active = is_plugin_active( 'base47-html-editor/base47-html-editor.php' );
    ?>
    <div style="margin-bottom: 15px;">
        <label>
            <input type="radio" name="nexus_canvas_mode_type" value="" <?php checked( empty($canvas_value) && empty($app_value) ); ?>>
            <?php esc_html_e( 'Normal WordPress Mode', 'nexus-theme' ); ?>
        </label>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label>
            <input type="radio" name="nexus_canvas_mode_type" value="canvas" <?php checked( $canvas_value, '1' ); ?>>
            <?php esc_html_e( 'Canvas Mode', 'nexus-theme' ); ?>
        </label>
        <p style="font-size: 11px; color: #666; margin: 5px 0 0 20px;">
            <?php esc_html_e( 'Full-width page template for custom HTML layouts.', 'nexus-theme' ); ?>
        </p>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label>
            <input type="radio" name="nexus_canvas_mode_type" value="app" <?php checked( $app_value, '1' ); ?>>
            <?php esc_html_e( 'App Canvas Mode', 'nexus-theme' ); ?>
        </label>
        <p style="font-size: 11px; color: #666; margin: 5px 0 0 20px;">
            <?php esc_html_e( 'Specialized canvas mode for app-like layouts.', 'nexus-theme' ); ?>
        </p>
    </div>
    
    <?php if ( $plugin_active ) : ?>
        <div style="background: #d4edda; padding: 10px; border-radius: 4px; margin-top: 10px; border-left: 4px solid #28a745;">
            <strong style="color: #155724;">✅ Base47 HTML Editor Active</strong><br>
            <small style="color: #155724;">
                Canvas Mode rendering will be handled by the plugin for perfect HTML template display across all themes.
            </small>
        </div>
    <?php else : ?>
        <div style="background: #fff3cd; padding: 10px; border-radius: 4px; margin-top: 10px; border-left: 4px solid #ffc107;">
            <strong style="color: #856404;">⚠️ Plugin Recommended</strong><br>
            <small style="color: #856404;">
                For best Canvas Mode experience, install the Base47 HTML Editor plugin.
            </small>
        </div>
    <?php endif; ?>
    <?php
}

add_action( 'save_post', function( $post_id ) {
    if ( ! isset( $_POST['nexus_canvas_mode_nonce'] ) ||
         ! wp_verify_nonce( wp_unslash( $_POST['nexus_canvas_mode_nonce'] ), 'nexus_canvas_mode_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Clear both meta values first
    delete_post_meta( $post_id, '_nexus_canvas_mode' );
    delete_post_meta( $post_id, '_nexus_canvas_app_mode' );

    // Set the appropriate meta based on selection
    if ( isset( $_POST['nexus_canvas_mode_type'] ) ) {
        $mode_type = sanitize_text_field( $_POST['nexus_canvas_mode_type'] );
        
        if ( $mode_type === 'canvas' ) {
            update_post_meta( $post_id, '_nexus_canvas_mode', '1' );
        } elseif ( $mode_type === 'app' ) {
            update_post_meta( $post_id, '_nexus_canvas_app_mode', '1' );
        }
    }
} );

/**
 * Load theme enhancement files (WordPress.org compliant only)
 */

// Load customizer
$customizer_file = get_template_directory() . '/inc/customizer.php';
if ( file_exists( $customizer_file ) ) {
    require_once $customizer_file;
}

// Load WooCommerce integration
$woocommerce_file = get_template_directory() . '/inc/woocommerce.php';
if ( file_exists( $woocommerce_file ) ) {
    require_once $woocommerce_file;
}

/**
 * Sanitization functions for customizer
 */
function nexus_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function nexus_sanitize_select( $input, $setting ) {
    $input = sanitize_key( $input );
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}