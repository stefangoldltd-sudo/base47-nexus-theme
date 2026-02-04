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
       COLORS SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_colors', array(
        'title'    => __( 'Colors', 'nexus-theme' ),
        'priority' => 40,
    ) );

    // Primary Color
    $wp_customize->add_setting( 'nexus_primary_color', array(
        'default'           => '#0073aa',
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

    // Header Background Color
    $wp_customize->add_setting( 'nexus_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_header_bg_color', array(
        'label'   => __( 'Header Background Color', 'nexus-theme' ),
        'section' => 'nexus_colors',
    ) ) );

    /* =============================================
       TYPOGRAPHY SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_typography', array(
        'title'    => __( 'Typography', 'nexus-theme' ),
        'priority' => 50,
    ) );

    // Body Font
    $wp_customize->add_setting( 'nexus_body_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'nexus_sanitize_select',
        'transport'         => 'postMessage',
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

    /* =============================================
       LAYOUT SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_layout', array(
        'title'    => __( 'Layout', 'nexus-theme' ),
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
       LOGO SETTINGS
    ============================================= */

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

    // Show/Hide Tagline
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
       FOOTER SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_footer', array(
        'title'    => __( 'Footer', 'nexus-theme' ),
        'priority' => 90,
    ) );

    // Footer Text
    $wp_customize->add_setting( 'nexus_footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'nexus_footer_text', array(
        'label'       => __( 'Footer Text', 'nexus-theme' ),
        'section'     => 'nexus_footer',
        'type'        => 'textarea',
        'description' => __( 'Custom text to display in the footer.', 'nexus-theme' ),
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
}
add_action( 'customize_register', 'nexus_customize_register' );

/**
 * Sanitization functions are defined in functions.php
 * No need to redeclare them here
 */

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
    
    // Footer colors
    $footer_bg = get_theme_mod( 'nexus_footer_bg_color', '#333333' );
    if ( $footer_bg != '#333333' ) {
        $css .= '.site-footer { background-color: ' . sanitize_hex_color( $footer_bg ) . '; }';
    }
    
    $footer_text = get_theme_mod( 'nexus_footer_text_color', '#ffffff' );
    if ( $footer_text != '#ffffff' ) {
        $css .= '.site-footer { color: ' . sanitize_hex_color( $footer_text ) . '; }';
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