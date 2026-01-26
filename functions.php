<?php
/**
 * Nexus Theme – Dual Mode (Canvas + Classic)
 * The perfect nexus between HTML templates and WordPress
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Load debug tool (optional)
$debug_file = get_template_directory() . '/debug-canvas.php';
if ( file_exists( $debug_file ) ) {
    require_once $debug_file;
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
    return $version ? $version : '3.2.3';
}

/* ---------------------------------------------
 * Theme setup
 * ------------------------------------------ */

function nexus_theme_setup() {

    // Let WordPress handle <title> tag
    add_theme_support( 'title-tag' );

    // Thumbnails if needed
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

    // Primary navigation (for classic mode header)
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'nexus-theme' ),
    ) );
}
add_action( 'after_setup_theme', 'nexus_theme_setup' );

/* ---------------------------------------------
 * Disable Gutenberg (Block Editor)
 * We keep your original behavior: disable for everything.
 * If you ever want it ONLY for pages, you can change the condition.
 * ------------------------------------------ */

function nexus_disable_block_editor_for_all( $use_block_editor, $post_type ) {
    // Return false for all post types (pages, posts, custom)
    return false;
}
add_filter( 'use_block_editor_for_post_type', 'nexus_disable_block_editor_for_all', 10, 2 );

/* ---------------------------------------------
 * Disable WP block/global styles that break designs
 * (keeps your original behavior)
 * ------------------------------------------ */

function nexus_theme_dequeue_wp_styles() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'global-styles' );
    // FIX: Remove classic-theme-styles that breaks mobile layout
    wp_dequeue_style( 'classic-theme-styles' );
    wp_deregister_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'nexus_theme_dequeue_wp_styles', 100 );

/* ---------------------------------------------
 * Enqueue our CSS + JS
 * - style.css (shell)
 * - optional normalize.css
 * - Soft-UI CSS for classic pages
 * - theme.js
 * ------------------------------------------ */

function nexus_theme_scripts() {
    $ver = nexus_theme_get_version();
    $dir = get_template_directory_uri();

    // Optional normalize/reset if you add it later
    $normalize_path = get_template_directory() . '/assets/css/normalize.css';
    if ( file_exists( $normalize_path ) ) {
        wp_enqueue_style(
            'nexus-normalize',
            $dir . '/assets/css/normalize.css',
            array(),
            $ver
        );
        $deps = array( 'nexus-normalize' );
    } else {
        $deps = array();
    }

    // MAIN THEME STYLESHEET
    wp_enqueue_style(
        'nexus-style',
        get_stylesheet_uri(),
        $deps,
        $ver
    );

    // Detect if current page is Canvas Mode
    $is_canvas = false;

    if ( is_singular() ) {
        $post_id = get_the_ID();

        // Meta box flag
        $meta_canvas = get_post_meta( $post_id, '_nexus_canvas_mode', true );

        // Detect template AFTER WP resolves hierarchy
        $template = get_page_template_slug( $post_id );

        if ( $meta_canvas === '1' || $template === 'template-canvas.php' ) {
            $is_canvas = true;
        }
    }

    // Load Soft-UI ONLY if NOT Canvas Mode
    $softui_path = get_template_directory() . '/assets/css/nexus-softui.css';
    if ( ! $is_canvas && file_exists( $softui_path ) ) {
        wp_enqueue_style(
            'nexus-softui',
            $dir . '/assets/css/nexus-softui.css',
            array( 'nexus-style' ),
            $ver
        );
    }

    // Header Builder CSS
    $header_builder_path = get_template_directory() . '/assets/css/header-builder.css';
    if ( file_exists( $header_builder_path ) ) {
        wp_enqueue_style(
            'nexus-header-builder',
            $dir . '/assets/css/header-builder.css',
            array( 'nexus-style' ),
            $ver
        );
    }

    // Mega Menu CSS
    if ( get_theme_mod( 'nexus_mega_menu_enabled', true ) ) {
        $mega_menu_path = get_template_directory() . '/assets/css/mega-menu.css';
        if ( file_exists( $mega_menu_path ) ) {
            wp_enqueue_style(
                'nexus-mega-menu',
                $dir . '/assets/css/mega-menu.css',
                array( 'nexus-style' ),
                $ver
            );
        }
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

    // Optional theme JS – safe even if file is empty
    $js_path = get_template_directory() . '/assets/js/theme.js';
    if ( file_exists( $js_path ) ) {
        wp_enqueue_script(
            'nexus-theme',
            $dir . '/assets/js/theme.js',
            array( 'jquery' ),
            $ver,
            true
        );
    }

    // Header Builder JS
    $header_js_path = get_template_directory() . '/assets/js/header-builder.js';
    if ( file_exists( $header_js_path ) ) {
        wp_enqueue_script(
            'nexus-header-builder',
            $dir . '/assets/js/header-builder.js',
            array( 'jquery' ),
            $ver,
            true
        );

        // Localize header script
        wp_localize_script( 'nexus-header-builder', 'nexusHeader', array(
            'homeUrl' => home_url( '/' ),
            'searchPlaceholder' => __( 'Search...', 'nexus-theme' ),
        ) );
    }

    // Mega Menu JS
    if ( get_theme_mod( 'nexus_mega_menu_enabled', true ) ) {
        $mega_menu_js_path = get_template_directory() . '/assets/js/mega-menu.js';
        if ( file_exists( $mega_menu_js_path ) ) {
            wp_enqueue_script(
                'nexus-mega-menu',
                $dir . '/assets/js/mega-menu.js',
                array( 'jquery' ),
                $ver,
                true
            );

            // Localize mega menu script
            wp_localize_script( 'nexus-mega-menu', 'nexusMegaMenu', array(
                'animation' => get_theme_mod( 'nexus_mega_menu_animation', 'fade' ),
                'mobileBreakpoint' => get_theme_mod( 'nexus_mega_menu_mobile_breakpoint', 768 ),
            ) );
        }
    }

    // Generate dynamic CSS
    $dynamic_css = nexus_generate_dynamic_css();
    if ( $dynamic_css ) {
        wp_add_inline_style( 'nexus-style', $dynamic_css );
    }
}
add_action( 'wp_enqueue_scripts', 'nexus_theme_scripts' );

/* ---------------------------------------------
 * Generate Dynamic CSS from Customizer Settings
 * ------------------------------------------ */

function nexus_generate_dynamic_css() {
    $css = '';
    
    // Header Builder CSS
    if ( function_exists( 'nexus_header_builder_css' ) ) {
        $css .= nexus_header_builder_css();
    }
    
    // Mega Menu CSS
    if ( function_exists( 'nexus_mega_menu_css' ) ) {
        $css .= nexus_mega_menu_css();
    }
    
    // WooCommerce CSS
    if ( function_exists( 'nexus_woocommerce_css' ) ) {
        $css .= nexus_woocommerce_css();
    }
    
    return $css;
}

/* ---------------------------------------------
 * RAW HTML: Remove automatic <p> / <br> wrappers
 * (your original behavior – very important for Mivon/HTML editor)
 * ------------------------------------------ */

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

/* ---------------------------------------------
 * Disable srcset to avoid layout break (your original)
 * ------------------------------------------ */

add_filter( 'wp_calculate_image_srcset', '__return_false' );

/* ---------------------------------------------
 * FIX: Remove specific body classes that can trigger unwanted CSS
 * (keeps your original behavior)
 * ------------------------------------------ */

add_filter( 'body_class', function( $classes ) {
    $remove_classes = array(
        'wp-embed-responsive',
        'wp-custom-logo',
        'wp-block-theme',
    );

    return array_diff( $classes, $remove_classes );
} );

/* ---------------------------------------------
 * Canvas Mode meta box (your original feature)
 * Lets you enable Canvas Mode on a per-page basis.
 * ------------------------------------------ */

add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'nexus_canvas_mode',
        'Nexus Canvas Mode',
        'nexus_canvas_mode_callback',
        'page',
        'side',
        'high'
    );
} );

function nexus_canvas_mode_callback( $post ) {
    wp_nonce_field( 'nexus_canvas_mode_nonce', 'nexus_canvas_mode_nonce' );
    $value = get_post_meta( $post->ID, '_nexus_canvas_mode', true );
    $app_value = get_post_meta( $post->ID, '_nexus_canvas_app_mode', true );
    ?>
    <div style="margin-bottom: 15px;">
        <label>
            <input type="radio" name="nexus_canvas_mode_type" value="" <?php checked( empty($value) && empty($app_value) ); ?>>
            <?php esc_html_e( 'Normal WordPress Mode', 'nexus-theme' ); ?>
        </label>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label>
            <input type="radio" name="nexus_canvas_mode_type" value="canvas" <?php checked( $value, '1' ); ?>>
            <?php esc_html_e( 'Canvas Mode (Pure HTML)', 'nexus-theme' ); ?>
        </label>
        <p style="font-size: 11px; color: #666; margin: 5px 0 0 20px;">
            <?php esc_html_e( 'Like Elementor Canvas – outputs pure HTML without WordPress header/footer. Perfect for HTML templates.', 'nexus-theme' ); ?>
        </p>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label>
            <input type="radio" name="nexus_canvas_mode_type" value="app" <?php checked( $app_value, '1' ); ?>>
            <?php esc_html_e( 'App Canvas Mode', 'nexus-theme' ); ?>
        </label>
        <p style="font-size: 11px; color: #666; margin: 5px 0 0 20px;">
            <?php esc_html_e( 'Specialized for Base47 templates. Handles WordPress login state properly.', 'nexus-theme' ); ?>
        </p>
    </div>
    
    <div style="background: #f0f8ff; padding: 10px; border-radius: 4px; margin-top: 10px;">
        <strong style="color: #0073aa;">Auto-Detection:</strong><br>
        <small style="color: #666;">
            • Canvas Mode: Auto-detected for HTML templates<br>
            • App Canvas: Auto-detected for Base47 content<br>
            • Manual selection overrides auto-detection
        </small>
    </div>
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

/* ---------------------------------------------
 * CANVAS MODE: Auto-detect Mivon/Base47 pages and use canvas template
 * Enhanced with App Canvas Mode for dashboard/account pages
 * ------------------------------------------ */

add_filter( 'template_include', function( $template ) {

    // If a page is explicitly set to "Nexus Canvas" template, respect that.
    if ( is_page_template( 'template-canvas.php' ) ) {
        return $template;
    }
    
    // If a page is explicitly set to "Base47 Canvas App" template, respect that.
    if ( is_page_template( 'template-canvas-app.php' ) ) {
        return $template;
    }

    if ( is_page() || is_singular() ) {
        global $post;

        if ( ! $post ) {
            return $template;
        }

        // Manual Canvas Mode via meta box
        $canvas_enabled = get_post_meta( $post->ID, '_nexus_canvas_mode', true );
        $app_canvas_enabled = get_post_meta( $post->ID, '_nexus_canvas_app_mode', true );

        // Auto-detect HTML templates in content (general detection)
        $content = $post->post_content;
        $has_html_template = (
            // Base47/Mivon specific
            strpos( $content, '[mivon-' ) !== false ||
            strpos( $content, '[base47-' ) !== false ||
            // Common HTML template patterns
            strpos( $content, 'class="header' ) !== false ||
            strpos( $content, 'data-scroll-container' ) !== false ||
            strpos( $content, '<section class=' ) !== false ||
            strpos( $content, 'data-aos=' ) !== false ||
            strpos( $content, 'class="hero' ) !== false ||
            strpos( $content, 'class="banner' ) !== false ||
            strpos( $content, 'class="landing' ) !== false ||
            // Bootstrap/Framework patterns
            strpos( $content, 'class="container-fluid' ) !== false ||
            strpos( $content, 'class="row"' ) !== false ||
            strpos( $content, 'data-bs-' ) !== false ||
            // Animation libraries
            strpos( $content, 'data-wow-' ) !== false ||
            strpos( $content, 'animate__' ) !== false ||
            // Full HTML document patterns
            strpos( $content, '<!DOCTYPE html>' ) !== false ||
            strpos( $content, '<html lang=' ) !== false
        );
        
        // Auto-detect Base47 App templates (dashboard, account, etc.)
        $has_app_content = (
            // Base47 shortcodes (processed before HTML detection)
            strpos( $content, '[base47_dashboard]' ) !== false ||
            strpos( $content, '[base47_account]' ) !== false ||
            strpos( $content, '[base47_portal' ) !== false ||
            // HTML content patterns (after shortcode processing)
            strpos( $content, 'dashboard-section' ) !== false ||
            strpos( $content, 'account-section' ) !== false ||
            strpos( $content, 'app-section' ) !== false ||
            strpos( $content, 'My Licenses' ) !== false ||
            strpos( $content, 'license-card' ) !== false ||
            strpos( $content, 'user-avatar' ) !== false
        );

        // Debug logging (remove after testing)
        if ( defined('WP_DEBUG') && WP_DEBUG ) {
            error_log('Nexus Canvas Detection - Post ID: ' . $post->ID);
            error_log('Canvas Enabled (meta): ' . ($canvas_enabled ? 'YES' : 'NO'));
            error_log('Has HTML Template: ' . ($has_html_template ? 'YES' : 'NO'));
            error_log('Has App Content: ' . ($has_app_content ? 'YES' : 'NO'));
            error_log('Content preview: ' . substr($content, 0, 200));
        }

        // Use App Canvas template for app content (manual or auto-detected)
        if ( $app_canvas_enabled || $has_app_content ) {
            $app_canvas_template = get_template_directory() . '/template-canvas-app.php';
            if ( file_exists( $app_canvas_template ) ) {
                if ( defined('WP_DEBUG') && WP_DEBUG ) {
                    error_log('✅ Using app canvas template for post ' . $post->ID);
                }
                return $app_canvas_template;
            }
        }

        // Use regular Canvas template for HTML templates (manual or auto-detected)
        if ( $canvas_enabled || $has_html_template ) {
            $canvas_template = get_template_directory() . '/template-canvas.php';
            if ( file_exists( $canvas_template ) ) {
                if ( defined('WP_DEBUG') && WP_DEBUG ) {
                    error_log('✅ Using canvas template for post ' . $post->ID);
                }
                return $canvas_template;
            }
        }
    }

    return $template;
}, 99 );

/* ---------------------------------------------
 * GitHub Theme Updater (updated for Nexus)
 * Checks latest release on GitHub and tells WP if an update exists.
 * ------------------------------------------ */

function nexus_github_updater( $transient ) {

    if ( empty( $transient->checked ) ) {
        return $transient;
    }

    // Theme folder MUST match your theme directory name
    $theme_slug = 'nexus-theme';

    $theme           = wp_get_theme( $theme_slug );
    $current_version = $theme->get( 'Version' );

    // GitHub API for latest release
    $response = wp_remote_get( 'https://api.github.com/repos/stefangoldltd-sudo/base47-nexus-theme/releases/latest' );

    if ( is_wp_error( $response ) ) {
        return $transient;
    }

    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body );

    if ( empty( $data ) || empty( $data->tag_name ) || empty( $data->zipball_url ) ) {
        return $transient;
    }

    $latest_version = ltrim( $data->tag_name, 'v' );

    if ( version_compare( $current_version, $latest_version, '<' ) ) {
        // Must match your theme slug
        $transient->response[ $theme_slug ] = array(
            'theme'       => $theme_slug,
            'new_version' => $latest_version,
            'package'     => $data->zipball_url,
            'url'         => 'https://github.com/stefangoldltd-sudo/base47-nexus-theme',
        );
    }

    return $transient;
}
add_filter( 'pre_set_site_transient_update_themes', 'nexus_github_updater' );

/* ---------------------------------------------
 * Fix GitHub folder name issue
 * Forces WordPress to use 'nexus-theme' as folder name
 * ------------------------------------------ */
add_filter( 'upgrader_source_selection', 'nexus_fix_github_folder_name', 10, 4 );
function nexus_fix_github_folder_name( $source, $remote_source, $upgrader, $extra ) {
    // Only run for theme updates
    if ( ! isset( $extra['theme'] ) ) {
        return $source;
    }
    
    // Only run for nexus-theme
    if ( $extra['theme'] !== 'nexus-theme' && strpos( $source, 'nexus-theme' ) === false ) {
        return $source;
    }
    
    // Get the parent directory
    $parent_dir = dirname( $source );
    
    // New folder name
    $new_source = trailingslashit( $parent_dir ) . 'nexus-theme';
    
    // Rename the folder
    if ( $source !== $new_source ) {
        @rename( $source, $new_source );
        return $new_source;
    }
    
    return $source;
}

/* ---------------------------------------------
 * Load Theme Enhancement Files
 * ------------------------------------------ */

// Load customizer (Theme enhancement system)
$customizer_file = get_template_directory() . '/inc/customizer.php';
if ( file_exists( $customizer_file ) ) {
    require_once $customizer_file;
}

// Load widget areas
$widgets_file = get_template_directory() . '/inc/widgets.php';
if ( file_exists( $widgets_file ) ) {
    require_once $widgets_file;
}

// Load page builder compatibility
$page_builders_file = get_template_directory() . '/inc/page-builders.php';
if ( file_exists( $page_builders_file ) ) {
    require_once $page_builders_file;
}

// Load header builder
$header_builder_file = get_template_directory() . '/inc/header-builder.php';
if ( file_exists( $header_builder_file ) ) {
    require_once $header_builder_file;
}

// Load mega menu system
$mega_menu_file = get_template_directory() . '/inc/mega-menu.php';
if ( file_exists( $mega_menu_file ) ) {
    require_once $mega_menu_file;
}

// Load WooCommerce integration
$woocommerce_file = get_template_directory() . '/inc/woocommerce.php';
if ( file_exists( $woocommerce_file ) ) {
    require_once $woocommerce_file;
}

// Load performance panel
$performance_file = get_template_directory() . '/inc/performance.php';
if ( file_exists( $performance_file ) ) {
    require_once $performance_file;
}

// Load extra hooks file
$hooks_file = get_template_directory() . '/inc/hooks.php';
if ( file_exists( $hooks_file ) ) {
    require_once $hooks_file;
}