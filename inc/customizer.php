<?php
/**
 * Nexus Theme Customizer
 * WordPress.org compliant customizer settings
 * 
 * @package Nexus
 * @since 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add customizer settings
 */
function nexus_customize_register( $wp_customize ) {

    /* =============================================
       THEME OPTIONS
    ============================================= */
    
    $wp_customize->add_section( 'nexus_theme_options', array(
        'title'    => __( 'Theme Options', 'nexus-theme' ),
        'priority' => 30,
        'description' => __( 'Customize your theme appearance and behavior.', 'nexus-theme' ),
    ) );

    // Logo Width
    $wp_customize->add_setting( 'nexus_logo_width', array(
        'default'           => 150,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'nexus_logo_width', array(
        'label'       => __( 'Logo Width (px)', 'nexus-theme' ),
        'section'     => 'title_tagline',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 50,
            'max'  => 400,
            'step' => 10,
        ),
    ) );

    // Header Background Color
    $wp_customize->add_setting( 'nexus_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_header_bg_color', array(
        'label'    => __( 'Header Background Color', 'nexus-theme' ),
        'section'  => 'nexus_theme_options',
    ) ) );

    // Primary Color
    $wp_customize->add_setting( 'nexus_primary_color', array(
        'default'           => '#0073aa',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_primary_color', array(
        'label'    => __( 'Primary Color', 'nexus-theme' ),
        'section'  => 'nexus_theme_options',
    ) ) );

    // Footer Text
    $wp_customize->add_setting( 'nexus_footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'nexus_footer_text', array(
        'label'       => __( 'Footer Text', 'nexus-theme' ),
        'section'     => 'nexus_theme_options',
        'type'        => 'textarea',
        'description' => __( 'Custom text to display in the footer.', 'nexus-theme' ),
    ) );

    // Show/Hide Elements
    $wp_customize->add_setting( 'nexus_show_tagline', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_show_tagline', array(
        'label'   => __( 'Show Site Tagline', 'nexus-theme' ),
        'section' => 'title_tagline',
        'type'    => 'checkbox',
    ) );

    /* =============================================
       LAYOUT OPTIONS
    ============================================= */
    
    $wp_customize->add_section( 'nexus_layout', array(
        'title'    => __( 'Layout', 'nexus-theme' ),
        'priority' => 35,
    ) );

    // Container Width
    $wp_customize->add_setting( 'nexus_container_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'nexus_container_width', array(
        'label'       => __( 'Container Width (px)', 'nexus-theme' ),
        'section'     => 'nexus_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 800,
            'max'  => 1600,
            'step' => 50,
        ),
    ) );

    // Sidebar Position
    $wp_customize->add_setting( 'nexus_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_sidebar_position', array(
        'label'   => __( 'Sidebar Position', 'nexus-theme' ),
        'section' => 'nexus_layout',
        'type'    => 'select',
        'choices' => array(
            'left'  => __( 'Left', 'nexus-theme' ),
            'right' => __( 'Right', 'nexus-theme' ),
            'none'  => __( 'No Sidebar', 'nexus-theme' ),
        ),
    ) );

    /* =============================================
       TYPOGRAPHY
    ============================================= */
    
    $wp_customize->add_section( 'nexus_typography', array(
        'title'    => __( 'Typography', 'nexus-theme' ),
        'priority' => 40,
    ) );

    // Body Font Family
    $wp_customize->add_setting( 'nexus_body_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_body_font', array(
        'label'   => __( 'Body Font', 'nexus-theme' ),
        'section' => 'nexus_typography',
        'type'    => 'select',
        'choices' => array(
            'system'     => __( 'System Font', 'nexus-theme' ),
            'arial'      => __( 'Arial', 'nexus-theme' ),
            'helvetica'  => __( 'Helvetica', 'nexus-theme' ),
            'georgia'    => __( 'Georgia', 'nexus-theme' ),
            'times'      => __( 'Times New Roman', 'nexus-theme' ),
        ),
    ) );

    // Body Font Size
    $wp_customize->add_setting( 'nexus_body_font_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'nexus_body_font_size', array(
        'label'       => __( 'Body Font Size (px)', 'nexus-theme' ),
        'section'     => 'nexus_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ) );
}
add_action( 'customize_register', 'nexus_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 */
function nexus_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function nexus_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function nexus_customize_preview_js() {
    wp_enqueue_script( 'nexus-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), nexus_theme_get_version(), true );
}
add_action( 'customize_preview_init', 'nexus_customize_preview_js' );

/**
 * Generate dynamic CSS from customizer settings
 */
function nexus_customizer_css() {
    $css = '';
    
    // Logo width
    $logo_width = get_theme_mod( 'nexus_logo_width', 150 );
    if ( $logo_width != 150 ) {
        $css .= '.custom-logo { max-width: ' . absint( $logo_width ) . 'px; }';
    }
    
    // Header background color
    $header_bg = get_theme_mod( 'nexus_header_bg_color', '#ffffff' );
    if ( $header_bg != '#ffffff' ) {
        $css .= '.site-header { background-color: ' . sanitize_hex_color( $header_bg ) . '; }';
    }
    
    // Primary color
    $primary_color = get_theme_mod( 'nexus_primary_color', '#0073aa' );
    if ( $primary_color != '#0073aa' ) {
        $css .= 'a, .primary-color { color: ' . sanitize_hex_color( $primary_color ) . '; }';
        $css .= '.btn-primary, .primary-bg { background-color: ' . sanitize_hex_color( $primary_color ) . '; }';
    }
    
    // Container width
    $container_width = get_theme_mod( 'nexus_container_width', 1200 );
    if ( $container_width != 1200 ) {
        $css .= '.container { max-width: ' . absint( $container_width ) . 'px; }';
    }
    
    // Body font
    $body_font = get_theme_mod( 'nexus_body_font', 'system' );
    $font_family = '';
    switch ( $body_font ) {
        case 'arial':
            $font_family = 'Arial, sans-serif';
            break;
        case 'helvetica':
            $font_family = 'Helvetica, Arial, sans-serif';
            break;
        case 'georgia':
            $font_family = 'Georgia, serif';
            break;
        case 'times':
            $font_family = '"Times New Roman", Times, serif';
            break;
        default:
            $font_family = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
    }
    if ( $body_font != 'system' ) {
        $css .= 'body { font-family: ' . $font_family . '; }';
    }
    
    // Body font size
    $body_font_size = get_theme_mod( 'nexus_body_font_size', 16 );
    if ( $body_font_size != 16 ) {
        $css .= 'body { font-size: ' . absint( $body_font_size ) . 'px; }';
    }
    
    return $css;
}

/**
 * Add customizer CSS to head
 */
function nexus_customizer_head_css() {
    $css = nexus_customizer_css();
    if ( $css ) {
        echo '<style type="text/css" id="nexus-customizer-css">' . $css . '</style>';
    }
}
add_action( 'wp_head', 'nexus_customizer_head_css' );

    // Logo Height
    $wp_customize->add_setting( 'nexus_logo_height', array(
        'default'           => 60,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'nexus_logo_height', array(
        'label'       => __( 'Logo Height (px)', 'nexus-theme' ),
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
    
    $wp_customize->add_section( 'nexus_colors', array(
        'title'    => __( '🎨 Colors', 'nexus-theme' ),
        'priority' => 40,
    ) );

    // Primary Color
    $wp_customize->add_setting( 'nexus_primary_color', array(
        'default'           => '#ff4d00',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_primary_color', array(
        'label'   => __( 'Primary Color', 'nexus-theme' ),
        'section' => 'nexus_colors',
    ) ) );

    // Secondary Color
    $wp_customize->add_setting( 'nexus_secondary_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_secondary_color', array(
        'label'   => __( 'Secondary Color', 'nexus-theme' ),
        'section' => 'nexus_colors',
    ) ) );

    // Text Color
    $wp_customize->add_setting( 'nexus_text_color', array(
        'default'           => '#666666',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_text_color', array(
        'label'   => __( 'Text Color', 'nexus-theme' ),
        'section' => 'nexus_colors',
    ) ) );

    // Link Color
    $wp_customize->add_setting( 'nexus_link_color', array(
        'default'           => '#ff4d00',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_link_color', array(
        'label'   => __( 'Link Color', 'nexus-theme' ),
        'section' => 'nexus_colors',
    ) ) );

    // Button Color
    $wp_customize->add_setting( 'nexus_button_color', array(
        'default'           => '#ff4d00',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_button_color', array(
        'label'   => __( 'Button Color', 'nexus-theme' ),
        'section' => 'nexus_colors',
    ) ) );

    /* =============================================
       TYPOGRAPHY SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_typography', array(
        'title'    => __( '📝 Typography', 'nexus-theme' ),
        'priority' => 50,
    ) );

    // Body Font
    $wp_customize->add_setting( 'nexus_body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'nexus_body_font', array(
        'label'   => __( 'Body Font', 'nexus-theme' ),
        'section' => 'nexus_typography',
        'type'    => 'select',
        'choices' => nexus_get_google_fonts(),
    ) );

    // Heading Font
    $wp_customize->add_setting( 'nexus_heading_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'nexus_heading_font', array(
        'label'   => __( 'Heading Font', 'nexus-theme' ),
        'section' => 'nexus_typography',
        'type'    => 'select',
        'choices' => nexus_get_google_fonts(),
    ) );

    // Body Font Size
    $wp_customize->add_setting( 'nexus_body_font_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'nexus_body_font_size', array(
        'label'       => __( 'Body Font Size (px)', 'nexus-theme' ),
        'section'     => 'nexus_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ) );

    // Heading Font Size
    $wp_customize->add_setting( 'nexus_heading_font_size', array(
        'default'           => 32,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'nexus_heading_font_size', array(
        'label'       => __( 'H1 Font Size (px)', 'nexus-theme' ),
        'section'     => 'nexus_typography',
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
    
    $wp_customize->add_section( 'nexus_layout', array(
        'title'    => __( '📐 Layout', 'nexus-theme' ),
        'priority' => 60,
    ) );

    // Container Width
    $wp_customize->add_setting( 'nexus_container_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'nexus_container_width', array(
        'label'       => __( 'Container Width (px)', 'nexus-theme' ),
        'section'     => 'nexus_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1920,
            'step' => 20,
        ),
    ) );

    // Site Layout
    $wp_customize->add_setting( 'nexus_site_layout', array(
        'default'           => 'full-width',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_site_layout', array(
        'label'   => __( 'Site Layout', 'nexus-theme' ),
        'section' => 'nexus_layout',
        'type'    => 'select',
        'choices' => array(
            'full-width' => __( 'Full Width', 'nexus-theme' ),
            'boxed'      => __( 'Boxed', 'nexus-theme' ),
        ),
    ) );

    // Sidebar Position
    $wp_customize->add_setting( 'nexus_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_sidebar_position', array(
        'label'   => __( 'Sidebar Position', 'nexus-theme' ),
        'section' => 'nexus_layout',
        'type'    => 'select',
        'choices' => array(
            'none'  => __( 'No Sidebar', 'nexus-theme' ),
            'left'  => __( 'Left Sidebar', 'nexus-theme' ),
            'right' => __( 'Right Sidebar', 'nexus-theme' ),
        ),
    ) );

    /* =============================================
       HEADER SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_header', array(
        'title'    => __( '🔝 Header', 'nexus-theme' ),
        'priority' => 70,
    ) );

    // Header Layout
    $wp_customize->add_setting( 'nexus_header_layout', array(
        'default'           => 'layout-1',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_header_layout', array(
        'label'   => __( 'Header Layout', 'nexus-theme' ),
        'section' => 'nexus_header',
        'type'    => 'select',
        'choices' => array(
            'layout-1' => __( 'Logo Left, Menu Right', 'nexus-theme' ),
            'layout-2' => __( 'Centered Logo, Menu Below', 'nexus-theme' ),
            'layout-3' => __( 'Logo Center, Menu Sides', 'nexus-theme' ),
            'layout-4' => __( 'Minimal Header', 'nexus-theme' ),
        ),
    ) );

    // Sticky Header
    $wp_customize->add_setting( 'nexus_sticky_header', array(
        'default'           => false,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_sticky_header', array(
        'label'   => __( 'Sticky Header', 'nexus-theme' ),
        'section' => 'nexus_header',
        'type'    => 'checkbox',
    ) );

    // Header Background Color
    $wp_customize->add_setting( 'nexus_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_header_bg_color', array(
        'label'   => __( 'Header Background Color', 'nexus-theme' ),
        'section' => 'nexus_header',
    ) ) );

    // Transparent Header
    $wp_customize->add_setting( 'nexus_transparent_header', array(
        'default'           => false,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_transparent_header', array(
        'label'       => __( 'Transparent Header', 'nexus-theme' ),
        'description' => __( 'Make header transparent on homepage', 'nexus-theme' ),
        'section'     => 'nexus_header',
        'type'        => 'checkbox',
    ) );

    /* =============================================
       PAGE BUILDER COMPATIBILITY
    ============================================= */
    
    $wp_customize->add_section( 'nexus_page_builders', array(
        'title'    => __( '🔧 Page Builder Compatibility', 'nexus-theme' ),
        'priority' => 80,
    ) );

    // Elementor Compatibility
    $wp_customize->add_setting( 'nexus_elementor_compat', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_elementor_compat', array(
        'label'       => __( 'Elementor Compatibility', 'nexus-theme' ),
        'description' => __( 'Enable enhanced Elementor integration and styling', 'nexus-theme' ),
        'section'     => 'nexus_page_builders',
        'type'        => 'checkbox',
    ) );

    // Gutenberg Enhancements
    $wp_customize->add_setting( 'nexus_gutenberg_enhancements', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_gutenberg_enhancements', array(
        'label'       => __( 'Gutenberg Enhancements', 'nexus-theme' ),
        'description' => __( 'Enable enhanced Gutenberg block styling', 'nexus-theme' ),
        'section'     => 'nexus_page_builders',
        'type'        => 'checkbox',
    ) );

    // Beaver Builder Support
    $wp_customize->add_setting( 'nexus_beaver_builder_compat', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_beaver_builder_compat', array(
        'label'       => __( 'Beaver Builder Compatibility', 'nexus-theme' ),
        'description' => __( 'Enable Beaver Builder theme integration', 'nexus-theme' ),
        'section'     => 'nexus_page_builders',
        'type'        => 'checkbox',
    ) );

    /* =============================================
       BLOG SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_blog', array(
        'title'    => __( '📰 Blog', 'nexus-theme' ),
        'priority' => 85,
    ) );

    // Blog Layout
    $wp_customize->add_setting( 'nexus_blog_layout', array(
        'default'           => 'list',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_blog_layout', array(
        'label'   => __( 'Blog Layout', 'nexus-theme' ),
        'section' => 'nexus_blog',
        'type'    => 'select',
        'choices' => array(
            'list'     => __( 'List View', 'nexus-theme' ),
            'grid'     => __( 'Grid View', 'nexus-theme' ),
            'masonry'  => __( 'Masonry', 'nexus-theme' ),
        ),
    ) );

    // Excerpt Length
    $wp_customize->add_setting( 'nexus_excerpt_length', array(
        'default'           => 55,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'nexus_excerpt_length', array(
        'label'       => __( 'Excerpt Length (words)', 'nexus-theme' ),
        'section'     => 'nexus_blog',
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
    
    $wp_customize->add_section( 'nexus_footer', array(
        'title'    => __( '🔻 Footer', 'nexus-theme' ),
        'priority' => 90,
    ) );

    // Footer Layout
    $wp_customize->add_setting( 'nexus_footer_layout', array(
        'default'           => 'layout-1',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_footer_layout', array(
        'label'   => __( 'Footer Layout', 'nexus-theme' ),
        'section' => 'nexus_footer',
        'type'    => 'select',
        'choices' => array(
            'layout-1' => __( '1 Column', 'nexus-theme' ),
            'layout-2' => __( '2 Columns', 'nexus-theme' ),
            'layout-3' => __( '3 Columns', 'nexus-theme' ),
            'layout-4' => __( '4 Columns', 'nexus-theme' ),
        ),
    ) );

    // Footer Background Color
    $wp_customize->add_setting( 'nexus_footer_bg_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_footer_bg_color', array(
        'label'   => __( 'Footer Background Color', 'nexus-theme' ),
        'section' => 'nexus_footer',
    ) ) );

    // Footer Text Color
    $wp_customize->add_setting( 'nexus_footer_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_footer_text_color', array(
        'label'   => __( 'Footer Text Color', 'nexus-theme' ),
        'section' => 'nexus_footer',
    ) ) );

    // Copyright Text
    $wp_customize->add_setting( 'nexus_footer_copyright', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'nexus_footer_copyright', array(
        'label'       => __( 'Copyright Text', 'nexus-theme' ),
        'description' => __( 'Leave empty to use default copyright text', 'nexus-theme' ),
        'section'     => 'nexus_footer',
        'type'        => 'text',
    ) );

    /* =============================================
       PERFORMANCE SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_performance', array(
        'title'    => __( '⚡ Performance', 'nexus-theme' ),
        'priority' => 100,
    ) );

    // Lazy Loading
    $wp_customize->add_setting( 'nexus_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_lazy_loading', array(
        'label'       => __( 'Enable Lazy Loading', 'nexus-theme' ),
        'description' => __( 'Lazy load images for better performance', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'checkbox',
    ) );

    // Minify CSS
    $wp_customize->add_setting( 'nexus_minify_css', array(
        'default'           => false,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_minify_css', array(
        'label'       => __( 'Minify CSS', 'nexus-theme' ),
        'description' => __( 'Minify CSS files for faster loading', 'nexus-theme' ),
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
        'description' => __( 'Preload Google Fonts for faster text rendering', 'nexus-theme' ),
        'section'     => 'nexus_performance',
        'type'        => 'checkbox',
    ) );
}
add_action( 'customize_register', 'nexus_customize_register' );

/**
 * Sanitization functions
 */
function nexus_sanitize_select( $input, $setting ) {
    $input = sanitize_key( $input );
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function nexus_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Google Fonts list - Popular fonts for competitive advantage
 */
function nexus_get_google_fonts() {
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
function nexus_customize_preview_js() {
    wp_enqueue_script(
        'nexus-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array( 'customize-preview' ),
        nexus_theme_get_version(),
        true
    );
}
add_action( 'customize_preview_init', 'nexus_customize_preview_js' );

/**
 * Customizer controls JavaScript
 */
function nexus_customize_controls_js() {
    wp_enqueue_script(
        'nexus-customizer-controls',
        get_template_directory_uri() . '/assets/js/customizer-controls.js',
        array( 'customize-controls' ),
        nexus_theme_get_version(),
        true
    );
}
add_action( 'customize_controls_enqueue_scripts', 'nexus_customize_controls_js' );