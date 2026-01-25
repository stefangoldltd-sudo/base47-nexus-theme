<?php
/**
 * Base47 Theme Customizer
 * Complete customization system - competitive with Astra, OceanWP, Hello Elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add customizer settings
 */
function base47_customize_register( $wp_customize ) {

    // Remove default sections we don't need
    $wp_customize->remove_section( 'colors' );
    $wp_customize->remove_section( 'background_image' );

    /* =============================================
       BASE47 HTML EDITOR INTEGRATION (PRIORITY #1)
    ============================================= */
    
    $wp_customize->add_section( 'base47_html_editor', array(
        'title'    => __( '🚀 Base47 HTML Editor', 'base47-theme' ),
        'priority' => 25, // Very high priority - our main feature
        'description' => __( 'Settings for Base47 HTML Editor integration and canvas mode.', 'base47-theme' ),
    ) );

    // Canvas Mode Default
    $wp_customize->add_setting( 'base47_canvas_mode_default', array(
        'default'           => false,
        'sanitize_callback' => 'base47_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'base47_canvas_mode_default', array(
        'label'       => __( 'Enable Canvas Mode by Default', 'base47-theme' ),
        'description' => __( 'New pages will automatically use Canvas Mode for Base47 templates', 'base47-theme' ),
        'section'     => 'base47_html_editor',
        'type'        => 'checkbox',
    ) );

    // Template Auto-Detection
    $wp_customize->add_setting( 'base47_auto_detect_templates', array(
        'default'           => true,
        'sanitize_callback' => 'base47_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'base47_auto_detect_templates', array(
        'label'       => __( 'Auto-Detect Base47 Templates', 'base47-theme' ),
        'description' => __( 'Automatically switch to Canvas Mode when Base47 shortcodes are detected', 'base47-theme' ),
        'section'     => 'base47_html_editor',
        'type'        => 'checkbox',
    ) );

    // Template Marketplace Integration
    $wp_customize->add_setting( 'base47_marketplace_integration', array(
        'default'           => true,
        'sanitize_callback' => 'base47_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'base47_marketplace_integration', array(
        'label'       => __( 'Enable Template Marketplace', 'base47-theme' ),
        'description' => __( 'Show template marketplace in customizer for easy template installation', 'base47-theme' ),
        'section'     => 'base47_html_editor',
        'type'        => 'checkbox',
    ) );

    /* =============================================
       SITE IDENTITY ENHANCEMENTS
    ============================================= */
    
    // Logo Width
    $wp_customize->add_setting( 'base47_logo_width', array(
        'default'           => 150,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'base47_logo_width', array(
        'label'       => __( 'Logo Width (px)', 'base47-theme' ),
        'section'     => 'title_tagline',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 50,
            'max'  => 400,
            'step' => 10,
        ),
    ) );

    // Logo Height
    $wp_customize->add_setting( 'base47_logo_height', array(
        'default'           => 60,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'base47_logo_height', array(
        'label'       => __( 'Logo Height (px)', 'base47-theme' ),
        'section'     => 'title_tagline',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 30,
            'max'  => 200,
            'step' => 5,
        ),
    ) );

    /* =============================================
       COLORS SECTION
    ============================================= */
    
    $wp_customize->add_section( 'base47_colors', array(
        'title'    => __( '🎨 Colors', 'base47-theme' ),
        'priority' => 40,
    ) );

    // Primary Color
    $wp_customize->add_setting( 'base47_primary_color', array(
        'default'           => '#ff4d00',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'base47_primary_color', array(
        'label'   => __( 'Primary Color', 'base47-theme' ),
        'section' => 'base47_colors',
    ) ) );

    // Secondary Color
    $wp_customize->add_setting( 'base47_secondary_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'base47_secondary_color', array(
        'label'   => __( 'Secondary Color', 'base47-theme' ),
        'section' => 'base47_colors',
    ) ) );

    // Text Color
    $wp_customize->add_setting( 'base47_text_color', array(
        'default'           => '#666666',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'base47_text_color', array(
        'label'   => __( 'Text Color', 'base47-theme' ),
        'section' => 'base47_colors',
    ) ) );

    // Link Color
    $wp_customize->add_setting( 'base47_link_color', array(
        'default'           => '#ff4d00',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'base47_link_color', array(
        'label'   => __( 'Link Color', 'base47-theme' ),
        'section' => 'base47_colors',
    ) ) );

    // Button Color
    $wp_customize->add_setting( 'base47_button_color', array(
        'default'           => '#ff4d00',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'base47_button_color', array(
        'label'   => __( 'Button Color', 'base47-theme' ),
        'section' => 'base47_colors',
    ) ) );

    /* =============================================
       TYPOGRAPHY SECTION
    ============================================= */
    
    $wp_customize->add_section( 'base47_typography', array(
        'title'    => __( '📝 Typography', 'base47-theme' ),
        'priority' => 50,
    ) );

    // Body Font
    $wp_customize->add_setting( 'base47_body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'base47_body_font', array(
        'label'   => __( 'Body Font', 'base47-theme' ),
        'section' => 'base47_typography',
        'type'    => 'select',
        'choices' => base47_get_google_fonts(),
    ) );

    // Heading Font
    $wp_customize->add_setting( 'base47_heading_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'base47_heading_font', array(
        'label'   => __( 'Heading Font', 'base47-theme' ),
        'section' => 'base47_typography',
        'type'    => 'select',
        'choices' => base47_get_google_fonts(),
    ) );

    // Body Font Size
    $wp_customize->add_setting( 'base47_body_font_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'base47_body_font_size', array(
        'label'       => __( 'Body Font Size (px)', 'base47-theme' ),
        'section'     => 'base47_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ) );

    // Heading Font Size
    $wp_customize->add_setting( 'base47_heading_font_size', array(
        'default'           => 32,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'base47_heading_font_size', array(
        'label'       => __( 'H1 Font Size (px)', 'base47-theme' ),
        'section'     => 'base47_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 20,
            'max'  => 60,
            'step' => 2,
        ),
    ) );

    /* =============================================
       LAYOUT SECTION
    ============================================= */
    
    $wp_customize->add_section( 'base47_layout', array(
        'title'    => __( '📐 Layout', 'base47-theme' ),
        'priority' => 60,
    ) );

    // Container Width
    $wp_customize->add_setting( 'base47_container_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'base47_container_width', array(
        'label'       => __( 'Container Width (px)', 'base47-theme' ),
        'section'     => 'base47_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1920,
            'step' => 20,
        ),
    ) );

    // Site Layout
    $wp_customize->add_setting( 'base47_site_layout', array(
        'default'           => 'full-width',
        'sanitize_callback' => 'base47_sanitize_select',
    ) );

    $wp_customize->add_control( 'base47_site_layout', array(
        'label'   => __( 'Site Layout', 'base47-theme' ),
        'section' => 'base47_layout',
        'type'    => 'select',
        'choices' => array(
            'full-width' => __( 'Full Width', 'base47-theme' ),
            'boxed'      => __( 'Boxed', 'base47-theme' ),
        ),
    ) );

    // Sidebar Position
    $wp_customize->add_setting( 'base47_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'base47_sanitize_select',
    ) );

    $wp_customize->add_control( 'base47_sidebar_position', array(
        'label'   => __( 'Sidebar Position', 'base47-theme' ),
        'section' => 'base47_layout',
        'type'    => 'select',
        'choices' => array(
            'none'  => __( 'No Sidebar', 'base47-theme' ),
            'left'  => __( 'Left Sidebar', 'base47-theme' ),
            'right' => __( 'Right Sidebar', 'base47-theme' ),
        ),
    ) );

    /* =============================================
       HEADER SECTION
    ============================================= */
    
    $wp_customize->add_section( 'base47_header', array(
        'title'    => __( '🔝 Header', 'base47-theme' ),
        'priority' => 70,
    ) );

    // Header Layout
    $wp_customize->add_setting( 'base47_header_layout', array(
        'default'           => 'layout-1',
        'sanitize_callback' => 'base47_sanitize_select',
    ) );

    $wp_customize->add_control( 'base47_header_layout', array(
        'label'   => __( 'Header Layout', 'base47-theme' ),
        'section' => 'base47_header',
        'type'    => 'select',
        'choices' => array(
            'layout-1' => __( 'Logo Left, Menu Right', 'base47-theme' ),
            'layout-2' => __( 'Centered Logo, Menu Below', 'base47-theme' ),
            'layout-3' => __( 'Logo Center, Menu Sides', 'base47-theme' ),
            'layout-4' => __( 'Minimal Header', 'base47-theme' ),
        ),
    ) );

    // Sticky Header
    $wp_customize->add_setting( 'base47_sticky_header', array(
        'default'           => false,
        'sanitize_callback' => 'base47_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'base47_sticky_header', array(
        'label'   => __( 'Sticky Header', 'base47-theme' ),
        'section' => 'base47_header',
        'type'    => 'checkbox',
    ) );

    // Header Background Color
    $wp_customize->add_setting( 'base47_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'base47_header_bg_color', array(
        'label'   => __( 'Header Background Color', 'base47-theme' ),
        'section' => 'base47_header',
    ) ) );

    // Transparent Header
    $wp_customize->add_setting( 'base47_transparent_header', array(
        'default'           => false,
        'sanitize_callback' => 'base47_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'base47_transparent_header', array(
        'label'       => __( 'Transparent Header', 'base47-theme' ),
        'description' => __( 'Make header transparent on homepage', 'base47-theme' ),
        'section'     => 'base47_header',
        'type'        => 'checkbox',
    ) );

    /* =============================================
       PAGE BUILDER COMPATIBILITY
    ============================================= */
    
    $wp_customize->add_section( 'base47_page_builders', array(
        'title'    => __( '🔧 Page Builder Compatibility', 'base47-theme' ),
        'priority' => 80,
    ) );

    // Elementor Compatibility
    $wp_customize->add_setting( 'base47_elementor_compat', array(
        'default'           => true,
        'sanitize_callback' => 'base47_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'base47_elementor_compat', array(
        'label'       => __( 'Elementor Compatibility', 'base47-theme' ),
        'description' => __( 'Enable enhanced Elementor integration and styling', 'base47-theme' ),
        'section'     => 'base47_page_builders',
        'type'        => 'checkbox',
    ) );

    // Gutenberg Enhancements
    $wp_customize->add_setting( 'base47_gutenberg_enhancements', array(
        'default'           => true,
        'sanitize_callback' => 'base47_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'base47_gutenberg_enhancements', array(
        'label'       => __( 'Gutenberg Enhancements', 'base47-theme' ),
        'description' => __( 'Enable enhanced Gutenberg block styling', 'base47-theme' ),
        'section'     => 'base47_page_builders',
        'type'        => 'checkbox',
    ) );

    // Beaver Builder Support
    $wp_customize->add_setting( 'base47_beaver_builder_compat', array(
        'default'           => true,
        'sanitize_callback' => 'base47_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'base47_beaver_builder_compat', array(
        'label'       => __( 'Beaver Builder Compatibility', 'base47-theme' ),
        'description' => __( 'Enable Beaver Builder theme integration', 'base47-theme' ),
        'section'     => 'base47_page_builders',
        'type'        => 'checkbox',
    ) );

    /* =============================================
       BLOG SECTION
    ============================================= */
    
    $wp_customize->add_section( 'base47_blog', array(
        'title'    => __( '📰 Blog', 'base47-theme' ),
        'priority' => 85,
    ) );

    // Blog Layout
    $wp_customize->add_setting( 'base47_blog_layout', array(
        'default'           => 'list',
        'sanitize_callback' => 'base47_sanitize_select',
    ) );

    $wp_customize->add_control( 'base47_blog_layout', array(
        'label'   => __( 'Blog Layout', 'base47-theme' ),
        'section' => 'base47_blog',
        'type'    => 'select',
        'choices' => array(
            'list'     => __( 'List View', 'base47-theme' ),
            'grid'     => __( 'Grid View', 'base47-theme' ),
            'masonry'  => __( 'Masonry', 'base47-theme' ),
        ),
    ) );

    // Excerpt Length
    $wp_customize->add_setting( 'base47_excerpt_length', array(
        'default'           => 55,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'base47_excerpt_length', array(
        'label'       => __( 'Excerpt Length (words)', 'base47-theme' ),
        'section'     => 'base47_blog',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 5,
        ),
    ) );

    /* =============================================
       FOOTER SECTION
    ============================================= */
    
    $wp_customize->add_section( 'base47_footer', array(
        'title'    => __( '🔻 Footer', 'base47-theme' ),
        'priority' => 90,
    ) );

    // Footer Layout
    $wp_customize->add_setting( 'base47_footer_layout', array(
        'default'           => 'layout-1',
        'sanitize_callback' => 'base47_sanitize_select',
    ) );

    $wp_customize->add_control( 'base47_footer_layout', array(
        'label'   => __( 'Footer Layout', 'base47-theme' ),
        'section' => 'base47_footer',
        'type'    => 'select',
        'choices' => array(
            'layout-1' => __( '1 Column', 'base47-theme' ),
            'layout-2' => __( '2 Columns', 'base47-theme' ),
            'layout-3' => __( '3 Columns', 'base47-theme' ),
            'layout-4' => __( '4 Columns', 'base47-theme' ),
        ),
    ) );

    // Footer Background Color
    $wp_customize->add_setting( 'base47_footer_bg_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'base47_footer_bg_color', array(
        'label'   => __( 'Footer Background Color', 'base47-theme' ),
        'section' => 'base47_footer',
    ) ) );

    // Footer Text Color
    $wp_customize->add_setting( 'base47_footer_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'base47_footer_text_color', array(
        'label'   => __( 'Footer Text Color', 'base47-theme' ),
        'section' => 'base47_footer',
    ) ) );

    // Copyright Text
    $wp_customize->add_setting( 'base47_footer_copyright', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'base47_footer_copyright', array(
        'label'       => __( 'Copyright Text', 'base47-theme' ),
        'description' => __( 'Leave empty to use default copyright text', 'base47-theme' ),
        'section'     => 'base47_footer',
        'type'        => 'text',
    ) );

    /* =============================================
       PERFORMANCE SECTION
    ============================================= */
    
    $wp_customize->add_section( 'base47_performance', array(
        'title'    => __( '⚡ Performance', 'base47-theme' ),
        'priority' => 100,
    ) );

    // Lazy Loading
    $wp_customize->add_setting( 'base47_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'base47_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'base47_lazy_loading', array(
        'label'       => __( 'Enable Lazy Loading', 'base47-theme' ),
        'description' => __( 'Lazy load images for better performance', 'base47-theme' ),
        'section'     => 'base47_performance',
        'type'        => 'checkbox',
    ) );

    // Minify CSS
    $wp_customize->add_setting( 'base47_minify_css', array(
        'default'           => false,
        'sanitize_callback' => 'base47_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'base47_minify_css', array(
        'label'       => __( 'Minify CSS', 'base47-theme' ),
        'description' => __( 'Minify CSS files for faster loading', 'base47-theme' ),
        'section'     => 'base47_performance',
        'type'        => 'checkbox',
    ) );

    // Preload Fonts
    $wp_customize->add_setting( 'base47_preload_fonts', array(
        'default'           => true,
        'sanitize_callback' => 'base47_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'base47_preload_fonts', array(
        'label'       => __( 'Preload Google Fonts', 'base47-theme' ),
        'description' => __( 'Preload Google Fonts for faster text rendering', 'base47-theme' ),
        'section'     => 'base47_performance',
        'type'        => 'checkbox',
    ) );
}
add_action( 'customize_register', 'base47_customize_register' );

/**
 * Sanitization functions
 */
function base47_sanitize_select( $input, $setting ) {
    $input = sanitize_key( $input );
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function base47_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Google Fonts list - Popular fonts for competitive advantage
 */
function base47_get_google_fonts() {
    return array(
        'Inter'         => 'Inter',
        'Roboto'        => 'Roboto',
        'Open Sans'     => 'Open Sans',
        'Lato'          => 'Lato',
        'Montserrat'    => 'Montserrat',
        'Poppins'       => 'Poppins',
        'Source Sans Pro' => 'Source Sans Pro',
        'Nunito'        => 'Nunito',
        'Raleway'       => 'Raleway',
        'Ubuntu'        => 'Ubuntu',
        'Playfair Display' => 'Playfair Display',
        'Merriweather'  => 'Merriweather',
        'PT Sans'       => 'PT Sans',
        'Oswald'        => 'Oswald',
        'Libre Baskerville' => 'Libre Baskerville',
        'Quicksand'     => 'Quicksand',
        'Work Sans'     => 'Work Sans',
        'Fira Sans'     => 'Fira Sans',
        'DM Sans'       => 'DM Sans',
        'Space Grotesk' => 'Space Grotesk',
    );
}

/**
 * Live preview JavaScript
 */
function base47_customize_preview_js() {
    wp_enqueue_script(
        'base47-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array( 'customize-preview' ),
        base47_theme_get_version(),
        true
    );
}
add_action( 'customize_preview_init', 'base47_customize_preview_js' );

/**
 * Customizer controls JavaScript
 */
function base47_customize_controls_js() {
    wp_enqueue_script(
        'base47-customizer-controls',
        get_template_directory_uri() . '/assets/js/customizer-controls.js',
        array( 'customize-controls' ),
        base47_theme_get_version(),
        true
    );
}
add_action( 'customize_controls_enqueue_scripts', 'base47_customize_controls_js' );