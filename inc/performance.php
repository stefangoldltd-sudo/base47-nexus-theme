<?php
/**
 * Nexus Performance Panel
 * Speed optimization features like OceanWP/Astra
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Performance Customizer Settings
 */
function nexus_performance_customizer( $wp_customize ) {
    
    /* =============================================
       PERFORMANCE SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_performance', array(
        'title'    => __( '⚡ Performance', 'nexus-theme' ),
        'priority' => 36,
        'description' => __( 'Optimize your website speed and performance', 'nexus-theme' ),
    ) );

    // CSS Optimization
    $wp_customize->add_setting( 'nexus_minify_css', array(
        'default'           => false,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_minify_css', array(
        'label'       => __( 'Minify CSS', 'nexus-theme' ),
        'description' => __( 'Remove whitespace and comments from CSS files', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'checkbox',
    ) );

    // JavaScript Optimization
    $wp_customize->add_setting( 'nexus_minify_js', array(
        'default'           => false,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_minify_js', array(
        'label'       => __( 'Minify JavaScript', 'nexus-theme' ),
        'description' => __( 'Remove whitespace and comments from JS files', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'checkbox',
    ) );

    // Lazy Loading
    $wp_customize->add_setting( 'nexus_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_lazy_loading', array(
        'label'       => __( 'Lazy Load Images', 'nexus-theme' ),
        'description' => __( 'Load images only when they come into view', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'checkbox',
    ) );

    // Preload Fonts
    $wp_customize->add_setting( 'nexus_preload_fonts', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_preload_fonts', array(
        'label'       => __( 'Preload Google Fonts', 'nexus-theme' ),
        'description' => __( 'Improve font loading speed', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'checkbox',
    ) );

    // Remove Query Strings
    $wp_customize->add_setting( 'nexus_remove_query_strings', array(
        'default'           => false,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_remove_query_strings', array(
        'label'       => __( 'Remove Query Strings', 'nexus-theme' ),
        'description' => __( 'Remove version numbers from CSS/JS URLs', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'checkbox',
    ) );

    // Disable Emojis
    $wp_customize->add_setting( 'nexus_disable_emojis', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_disable_emojis', array(
        'label'       => __( 'Disable WordPress Emojis', 'nexus-theme' ),
        'description' => __( 'Remove emoji scripts and styles', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'checkbox',
    ) );

    // Disable Embeds
    $wp_customize->add_setting( 'nexus_disable_embeds', array(
        'default'           => false,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_disable_embeds', array(
        'label'       => __( 'Disable WordPress Embeds', 'nexus-theme' ),
        'description' => __( 'Remove embed functionality and scripts', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'checkbox',
    ) );

    // Disable XML-RPC
    $wp_customize->add_setting( 'nexus_disable_xmlrpc', array(
        'default'           => false,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_disable_xmlrpc', array(
        'label'       => __( 'Disable XML-RPC', 'nexus-theme' ),
        'description' => __( 'Disable XML-RPC functionality for security', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'checkbox',
    ) );

    /* =============================================
       ADVANCED PERFORMANCE
    ============================================= */

    // DNS Prefetch
    $wp_customize->add_setting( 'nexus_dns_prefetch', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'nexus_dns_prefetch', array(
        'label'       => __( 'DNS Prefetch Domains', 'nexus-theme' ),
        'description' => __( 'One domain per line (e.g., fonts.googleapis.com)', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'textarea',
        'input_attrs' => array(
            'rows' => 4,
        ),
    ) );

    // Preconnect
    $wp_customize->add_setting( 'nexus_preconnect', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );

    $wp_customize->add_control( 'nexus_preconnect', array(
        'label'       => __( 'Preconnect Domains', 'nexus-theme' ),
        'description' => __( 'One domain per line (e.g., https://fonts.gstatic.com)', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'textarea',
        'input_attrs' => array(
            'rows' => 4,
        ),
    ) );

    // Critical CSS
    $wp_customize->add_setting( 'nexus_critical_css', array(
        'default'           => '',
        'sanitize_callback' => 'wp_strip_all_tags',
    ) );

    $wp_customize->add_control( 'nexus_critical_css', array(
        'label'       => __( 'Critical CSS', 'nexus-theme' ),
        'description' => __( 'Above-the-fold CSS for faster rendering', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'textarea',
        'input_attrs' => array(
            'rows' => 8,
        ),
    ) );

    /* =============================================
       CACHING HINTS
    ============================================= */

    $wp_customize->add_setting( 'nexus_caching_info', array(
        'sanitize_callback' => 'wp_strip_all_tags',
    ) );

    $wp_customize->add_control( new Nexus_Info_Control( $wp_customize, 'nexus_caching_info', array(
        'label'       => __( '💡 Caching Recommendations', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'description' => __( 'For maximum performance, consider using:<br>• WP Rocket (Premium)<br>• W3 Total Cache (Free)<br>• WP Super Cache (Free)<br>• LiteSpeed Cache (Free)', 'nexus-theme' ),
    ) ) );
}
add_action( 'customize_register', 'nexus_performance_customizer' );

/**
 * Initialize Performance Features
 */
function nexus_performance_init() {
    
    // Lazy Loading
    if ( get_theme_mod( 'nexus_lazy_loading', true ) ) {
        add_filter( 'wp_get_attachment_image_attributes', 'nexus_add_lazy_loading' );
        add_filter( 'the_content', 'nexus_add_lazy_loading_to_content' );
    }
    
    // Remove Query Strings
    if ( get_theme_mod( 'nexus_remove_query_strings', false ) ) {
        add_filter( 'script_loader_src', 'nexus_remove_query_strings' );
        add_filter( 'style_loader_src', 'nexus_remove_query_strings' );
    }
    
    // Disable Emojis
    if ( get_theme_mod( 'nexus_disable_emojis', true ) ) {
        nexus_disable_emojis();
    }
    
    // Disable Embeds
    if ( get_theme_mod( 'nexus_disable_embeds', false ) ) {
        nexus_disable_embeds();
    }
    
    // Disable XML-RPC
    if ( get_theme_mod( 'nexus_disable_xmlrpc', false ) ) {
        add_filter( 'xmlrpc_enabled', '__return_false' );
    }
    
    // Add performance headers
    add_action( 'wp_head', 'nexus_performance_headers', 1 );
    
    // Minification
    if ( get_theme_mod( 'nexus_minify_css', false ) || get_theme_mod( 'nexus_minify_js', false ) ) {
        add_action( 'wp_enqueue_scripts', 'nexus_minify_assets', 999 );
    }
}
add_action( 'init', 'nexus_performance_init' );

/**
 * Add Lazy Loading to Images
 */
function nexus_add_lazy_loading( $attr ) {
    if ( is_admin() ) {
        return $attr;
    }
    
    $attr['loading'] = 'lazy';
    return $attr;
}

/**
 * Add Lazy Loading to Content Images
 */
function nexus_add_lazy_loading_to_content( $content ) {
    if ( is_admin() || is_feed() ) {
        return $content;
    }
    
    // Add loading="lazy" to img tags
    $content = preg_replace( '/<img((?![^>]*loading=)[^>]*)>/i', '<img$1 loading="lazy">', $content );
    
    return $content;
}

/**
 * Remove Query Strings from Static Resources
 */
function nexus_remove_query_strings( $src ) {
    $parts = explode( '?', $src );
    return $parts[0];
}

/**
 * Disable WordPress Emojis
 */
function nexus_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    
    add_filter( 'tiny_mce_plugins', 'nexus_disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'nexus_disable_emojis_dns_prefetch', 10, 2 );
}

function nexus_disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

function nexus_disable_emojis_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' == $relation_type ) {
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
        $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }
    return $urls;
}

/**
 * Disable WordPress Embeds
 */
function nexus_disable_embeds() {
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
    add_filter( 'embed_oembed_discover', '__return_false' );
    add_filter( 'tiny_mce_plugins', 'nexus_disable_embeds_tiny_mce_plugin' );
    add_filter( 'rewrite_rules_array', 'nexus_disable_embeds_rewrites' );
}

function nexus_disable_embeds_tiny_mce_plugin( $plugins ) {
    return array_diff( $plugins, array( 'wpembed' ) );
}

function nexus_disable_embeds_rewrites( $rules ) {
    foreach ( $rules as $rule => $rewrite ) {
        if ( false !== strpos( $rewrite, 'embed=true' ) ) {
            unset( $rules[ $rule ] );
        }
    }
    return $rules;
}

/**
 * Add Performance Headers
 */
function nexus_performance_headers() {
    
    // DNS Prefetch
    $dns_prefetch = get_theme_mod( 'nexus_dns_prefetch', '' );
    if ( $dns_prefetch ) {
        $domains = explode( "\n", $dns_prefetch );
        foreach ( $domains as $domain ) {
            $domain = trim( $domain );
            if ( $domain ) {
                echo '<link rel="dns-prefetch" href="//' . esc_attr( $domain ) . '">' . "\n";
            }
        }
    }
    
    // Preconnect
    $preconnect = get_theme_mod( 'nexus_preconnect', '' );
    if ( $preconnect ) {
        $domains = explode( "\n", $preconnect );
        foreach ( $domains as $domain ) {
            $domain = trim( $domain );
            if ( $domain ) {
                echo '<link rel="preconnect" href="' . esc_url( $domain ) . '">' . "\n";
            }
        }
    }
    
    // Preload Google Fonts
    if ( get_theme_mod( 'nexus_preload_fonts', true ) ) {
        $font_family = get_theme_mod( 'nexus_font_family', 'Inter' );
        if ( $font_family && $font_family !== 'default' ) {
            $font_url = 'https://fonts.googleapis.com/css2?family=' . str_replace( ' ', '+', $font_family ) . ':wght@300;400;500;600;700&display=swap';
            echo '<link rel="preload" href="' . esc_url( $font_url ) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
            echo '<noscript><link rel="stylesheet" href="' . esc_url( $font_url ) . '"></noscript>' . "\n";
        }
    }
    
    // Critical CSS
    $critical_css = get_theme_mod( 'nexus_critical_css', '' );
    if ( $critical_css ) {
        echo '<style id="nexus-critical-css">' . wp_strip_all_tags( $critical_css ) . '</style>' . "\n";
    }
}

/**
 * Minify Assets
 */
function nexus_minify_assets() {
    global $wp_styles, $wp_scripts;
    
    if ( get_theme_mod( 'nexus_minify_css', false ) ) {
        nexus_minify_css_files();
    }
    
    if ( get_theme_mod( 'nexus_minify_js', false ) ) {
        nexus_minify_js_files();
    }
}

/**
 * Minify CSS Files
 */
function nexus_minify_css_files() {
    global $wp_styles;
    
    if ( ! $wp_styles instanceof WP_Styles ) {
        return;
    }
    
    foreach ( $wp_styles->queue as $handle ) {
        if ( isset( $wp_styles->registered[ $handle ] ) ) {
            $style = $wp_styles->registered[ $handle ];
            
            // Only minify theme CSS files
            if ( strpos( $style->src, get_template_directory_uri() ) !== false ) {
                $minified_src = nexus_get_minified_css_url( $style->src );
                if ( $minified_src ) {
                    $wp_styles->registered[ $handle ]->src = $minified_src;
                }
            }
        }
    }
}

/**
 * Minify JS Files
 */
function nexus_minify_js_files() {
    global $wp_scripts;
    
    if ( ! $wp_scripts instanceof WP_Scripts ) {
        return;
    }
    
    foreach ( $wp_scripts->queue as $handle ) {
        if ( isset( $wp_scripts->registered[ $handle ] ) ) {
            $script = $wp_scripts->registered[ $handle ];
            
            // Only minify theme JS files
            if ( strpos( $script->src, get_template_directory_uri() ) !== false ) {
                $minified_src = nexus_get_minified_js_url( $script->src );
                if ( $minified_src ) {
                    $wp_scripts->registered[ $handle ]->src = $minified_src;
                }
            }
        }
    }
}

/**
 * Get Minified CSS URL
 */
function nexus_get_minified_css_url( $src ) {
    $file_path = str_replace( get_template_directory_uri(), get_template_directory(), $src );
    
    if ( ! file_exists( $file_path ) ) {
        return false;
    }
    
    $minified_path = str_replace( '.css', '.min.css', $file_path );
    $minified_url = str_replace( '.css', '.min.css', $src );
    
    // Check if minified version exists and is newer
    if ( file_exists( $minified_path ) && filemtime( $minified_path ) >= filemtime( $file_path ) ) {
        return $minified_url;
    }
    
    // Create minified version
    $css_content = file_get_contents( $file_path );
    $minified_css = nexus_minify_css_content( $css_content );
    
    if ( file_put_contents( $minified_path, $minified_css ) ) {
        return $minified_url;
    }
    
    return false;
}

/**
 * Get Minified JS URL
 */
function nexus_get_minified_js_url( $src ) {
    $file_path = str_replace( get_template_directory_uri(), get_template_directory(), $src );
    
    if ( ! file_exists( $file_path ) ) {
        return false;
    }
    
    $minified_path = str_replace( '.js', '.min.js', $file_path );
    $minified_url = str_replace( '.js', '.min.js', $src );
    
    // Check if minified version exists and is newer
    if ( file_exists( $minified_path ) && filemtime( $minified_path ) >= filemtime( $file_path ) ) {
        return $minified_url;
    }
    
    // Create minified version
    $js_content = file_get_contents( $file_path );
    $minified_js = nexus_minify_js_content( $js_content );
    
    if ( file_put_contents( $minified_path, $minified_js ) ) {
        return $minified_url;
    }
    
    return false;
}

/**
 * Minify CSS Content
 */
function nexus_minify_css_content( $css ) {
    // Remove comments
    $css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
    
    // Remove whitespace
    $css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );
    
    // Remove unnecessary spaces
    $css = str_replace( array( '; ', ' ;', ' {', '{ ', '} ', ' }', ': ', ' :', ', ', ' ,', ' > ', ' + ', ' ~ ' ), 
                       array( ';', ';', '{', '{', '}', '}', ':', ':', ',', ',', '>', '+', '~' ), $css );
    
    return trim( $css );
}

/**
 * Minify JS Content
 */
function nexus_minify_js_content( $js ) {
    // Remove single line comments
    $js = preg_replace( '/\/\/.*$/m', '', $js );
    
    // Remove multi-line comments
    $js = preg_replace( '/\/\*[\s\S]*?\*\//', '', $js );
    
    // Remove extra whitespace
    $js = preg_replace( '/\s+/', ' ', $js );
    
    // Remove whitespace around operators
    $js = str_replace( array( ' = ', ' + ', ' - ', ' * ', ' / ', ' == ', ' != ', ' === ', ' !== ', ' && ', ' || ' ),
                      array( '=', '+', '-', '*', '/', '==', '!=', '===', '!==', '&&', '||' ), $js );
    
    return trim( $js );
}

/**
 * Performance Dashboard Widget
 */
function nexus_performance_dashboard_widget() {
    wp_add_dashboard_widget(
        'nexus_performance_widget',
        __( 'Nexus Performance', 'nexus-theme' ),
        'nexus_performance_widget_content'
    );
}
add_action( 'wp_dashboard_setup', 'nexus_performance_dashboard_widget' );

/**
 * Performance Widget Content
 */
function nexus_performance_widget_content() {
    $optimizations = array(
        'lazy_loading' => get_theme_mod( 'nexus_lazy_loading', true ),
        'minify_css' => get_theme_mod( 'nexus_minify_css', false ),
        'minify_js' => get_theme_mod( 'nexus_minify_js', false ),
        'disable_emojis' => get_theme_mod( 'nexus_disable_emojis', true ),
        'preload_fonts' => get_theme_mod( 'nexus_preload_fonts', true ),
    );
    
    $active_count = count( array_filter( $optimizations ) );
    $total_count = count( $optimizations );
    
    echo '<div class="nexus-performance-widget">';
    echo '<p><strong>' . sprintf( __( '%d of %d optimizations active', 'nexus-theme' ), $active_count, $total_count ) . '</strong></p>';
    
    echo '<ul>';
    foreach ( $optimizations as $key => $active ) {
        $label = str_replace( '_', ' ', ucwords( $key ) );
        $status = $active ? '✅' : '❌';
        echo '<li>' . $status . ' ' . esc_html( $label ) . '</li>';
    }
    echo '</ul>';
    
    echo '<p><a href="' . admin_url( 'customize.php?autofocus[section]=nexus_performance' ) . '" class="button button-primary">' . __( 'Optimize Performance', 'nexus-theme' ) . '</a></p>';
    echo '</div>';
}

/**
 * Custom Info Control for Customizer
 */
class Nexus_Info_Control extends WP_Customize_Control {
    public $type = 'info';
    
    public function render_content() {
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
        </label>
        <?php
    }
}