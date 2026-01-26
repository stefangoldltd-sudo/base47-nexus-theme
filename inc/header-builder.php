<?php
/**
 * Nexus Header Builder System
 * Visual header customization like OceanWP/Astra
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Header Builder Customizer Settings
 */
function nexus_header_builder_customizer( $wp_customize ) {
    
    /* =============================================
       HEADER BUILDER SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_header_builder', array(
        'title'    => __( '🏗️ Header Builder', 'nexus-theme' ),
        'priority' => 30,
        'description' => __( 'Build your perfect header with drag & drop elements', 'nexus-theme' ),
    ) );

    // Header Layout
    $wp_customize->add_setting( 'nexus_header_layout', array(
        'default'           => 'layout_1',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_header_layout', array(
        'label'       => __( 'Header Layout', 'nexus-theme' ),
        'section'     => 'nexus_header_builder',
        'type'        => 'select',
        'choices'     => array(
            'layout_1' => __( 'Layout 1: Logo Left, Menu Right', 'nexus-theme' ),
            'layout_2' => __( 'Layout 2: Centered Logo, Menu Below', 'nexus-theme' ),
            'layout_3' => __( 'Layout 3: Logo Center, Menu Sides', 'nexus-theme' ),
            'layout_4' => __( 'Layout 4: Minimal Header', 'nexus-theme' ),
            'layout_5' => __( 'Layout 5: Logo Right, Menu Left', 'nexus-theme' ),
            'layout_6' => __( 'Layout 6: Stacked Center', 'nexus-theme' ),
        ),
    ) );

    // Header Height
    $wp_customize->add_setting( 'nexus_header_height', array(
        'default'           => 80,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'nexus_header_height', array(
        'label'       => __( 'Header Height (px)', 'nexus-theme' ),
        'section'     => 'nexus_header_builder',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 50,
            'max'  => 200,
            'step' => 1,
        ),
    ) );

    // Sticky Header
    $wp_customize->add_setting( 'nexus_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_sticky_header', array(
        'label'       => __( 'Sticky Header', 'nexus-theme' ),
        'description' => __( 'Header stays at top when scrolling', 'nexus-theme' ),
        'section'     => 'nexus_header_builder',
        'type'        => 'checkbox',
    ) );

    // Transparent Header
    $wp_customize->add_setting( 'nexus_transparent_header', array(
        'default'           => false,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_transparent_header', array(
        'label'       => __( 'Transparent Header', 'nexus-theme' ),
        'description' => __( 'Header overlays content (good for hero sections)', 'nexus-theme' ),
        'section'     => 'nexus_header_builder',
        'type'        => 'checkbox',
    ) );

    // Header Background Color
    $wp_customize->add_setting( 'nexus_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_header_bg_color', array(
        'label'       => __( 'Header Background Color', 'nexus-theme' ),
        'section'     => 'nexus_header_builder',
    ) ) );

    // Header Text Color
    $wp_customize->add_setting( 'nexus_header_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_header_text_color', array(
        'label'       => __( 'Header Text Color', 'nexus-theme' ),
        'section'     => 'nexus_header_builder',
    ) ) );

    // Logo Max Width
    $wp_customize->add_setting( 'nexus_logo_max_width', array(
        'default'           => 200,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'nexus_logo_max_width', array(
        'label'       => __( 'Logo Max Width (px)', 'nexus-theme' ),
        'section'     => 'nexus_header_builder',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 50,
            'max'  => 500,
            'step' => 10,
        ),
    ) );

    /* =============================================
       HEADER ELEMENTS SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_header_elements', array(
        'title'    => __( '🧩 Header Elements', 'nexus-theme' ),
        'priority' => 31,
        'description' => __( 'Add elements to your header: contact info, social icons, buttons', 'nexus-theme' ),
    ) );

    // Show Search
    $wp_customize->add_setting( 'nexus_header_search', array(
        'default'           => false,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_header_search', array(
        'label'       => __( 'Show Search Icon', 'nexus-theme' ),
        'section'     => 'nexus_header_elements',
        'type'        => 'checkbox',
    ) );

    // Header Phone
    $wp_customize->add_setting( 'nexus_header_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'nexus_header_phone', array(
        'label'       => __( 'Phone Number', 'nexus-theme' ),
        'section'     => 'nexus_header_elements',
        'type'        => 'text',
        'description' => __( 'e.g. +1 (555) 123-4567', 'nexus-theme' ),
    ) );

    // Header Email
    $wp_customize->add_setting( 'nexus_header_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ) );

    $wp_customize->add_control( 'nexus_header_email', array(
        'label'       => __( 'Email Address', 'nexus-theme' ),
        'section'     => 'nexus_header_elements',
        'type'        => 'email',
        'description' => __( 'e.g. info@yoursite.com', 'nexus-theme' ),
    ) );

    // Header Button Text
    $wp_customize->add_setting( 'nexus_header_button_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'nexus_header_button_text', array(
        'label'       => __( 'Header Button Text', 'nexus-theme' ),
        'section'     => 'nexus_header_elements',
        'type'        => 'text',
        'description' => __( 'e.g. Get Quote, Contact Us', 'nexus-theme' ),
    ) );

    // Header Button URL
    $wp_customize->add_setting( 'nexus_header_button_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'nexus_header_button_url', array(
        'label'       => __( 'Header Button URL', 'nexus-theme' ),
        'section'     => 'nexus_header_elements',
        'type'        => 'url',
        'description' => __( 'Where the button links to', 'nexus-theme' ),
    ) );

    // Social Icons
    $wp_customize->add_setting( 'nexus_header_social', array(
        'default'           => false,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_header_social', array(
        'label'       => __( 'Show Social Icons', 'nexus-theme' ),
        'section'     => 'nexus_header_elements',
        'type'        => 'checkbox',
        'description' => __( 'Configure social links in Social Media section', 'nexus-theme' ),
    ) );
}
add_action( 'customize_register', 'nexus_header_builder_customizer' );

/**
 * Generate Header CSS
 */
function nexus_header_builder_css() {
    $header_height = get_theme_mod( 'nexus_header_height', 80 );
    $header_bg = get_theme_mod( 'nexus_header_bg_color', '#ffffff' );
    $header_text = get_theme_mod( 'nexus_header_text_color', '#333333' );
    $logo_width = get_theme_mod( 'nexus_logo_max_width', 200 );
    $transparent = get_theme_mod( 'nexus_transparent_header', false );
    
    $css = "
    /* Header Builder Styles */
    .nexus-header {
        height: {$header_height}px;
        background-color: " . ($transparent ? 'transparent' : $header_bg) . ";
        color: {$header_text};
        transition: all 0.3s ease;
    }
    
    .nexus-header .custom-logo {
        max-width: {$logo_width}px;
        height: auto;
    }
    
    .nexus-header a {
        color: {$header_text};
    }
    
    .nexus-header.sticky {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 999;
        background-color: {$header_bg};
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    ";
    
    return $css;
}

/**
 * Render Header Layout
 */
function nexus_render_header() {
    $layout = get_theme_mod( 'nexus_header_layout', 'layout_1' );
    $sticky = get_theme_mod( 'nexus_sticky_header', true );
    
    $classes = array( 'nexus-header', 'header-' . $layout );
    if ( $sticky ) {
        $classes[] = 'sticky-enabled';
    }
    
    echo '<header class="' . esc_attr( implode( ' ', $classes ) ) . '">';
    echo '<div class="container">';
    
    switch ( $layout ) {
        case 'layout_1':
            nexus_header_layout_1();
            break;
        case 'layout_2':
            nexus_header_layout_2();
            break;
        case 'layout_3':
            nexus_header_layout_3();
            break;
        case 'layout_4':
            nexus_header_layout_4();
            break;
        case 'layout_5':
            nexus_header_layout_5();
            break;
        case 'layout_6':
            nexus_header_layout_6();
            break;
        default:
            nexus_header_layout_1();
    }
    
    echo '</div>';
    echo '</header>';
}

/**
 * Header Layout 1: Logo Left, Menu Right
 */
function nexus_header_layout_1() {
    echo '<div class="header-row">';
    echo '<div class="header-left">';
    nexus_render_logo();
    echo '</div>';
    echo '<div class="header-center"></div>';
    echo '<div class="header-right">';
    nexus_render_navigation();
    nexus_render_header_elements();
    echo '</div>';
    echo '</div>';
}

/**
 * Header Layout 2: Centered Logo, Menu Below
 */
function nexus_header_layout_2() {
    echo '<div class="header-row header-top">';
    echo '<div class="header-center">';
    nexus_render_logo();
    echo '</div>';
    echo '</div>';
    echo '<div class="header-row header-bottom">';
    echo '<div class="header-center">';
    nexus_render_navigation();
    nexus_render_header_elements();
    echo '</div>';
    echo '</div>';
}

/**
 * Header Layout 3: Logo Center, Menu Sides
 */
function nexus_header_layout_3() {
    echo '<div class="header-row">';
    echo '<div class="header-left">';
    nexus_render_navigation( 'left' );
    echo '</div>';
    echo '<div class="header-center">';
    nexus_render_logo();
    echo '</div>';
    echo '<div class="header-right">';
    nexus_render_navigation( 'right' );
    nexus_render_header_elements();
    echo '</div>';
    echo '</div>';
}

/**
 * Header Layout 4: Minimal Header
 */
function nexus_header_layout_4() {
    echo '<div class="header-row minimal">';
    echo '<div class="header-left">';
    nexus_render_logo();
    echo '</div>';
    echo '<div class="header-right">';
    nexus_render_mobile_menu_toggle();
    echo '</div>';
    echo '</div>';
}

/**
 * Header Layout 5: Logo Right, Menu Left
 */
function nexus_header_layout_5() {
    echo '<div class="header-row">';
    echo '<div class="header-left">';
    nexus_render_navigation();
    echo '</div>';
    echo '<div class="header-center"></div>';
    echo '<div class="header-right">';
    nexus_render_logo();
    nexus_render_header_elements();
    echo '</div>';
    echo '</div>';
}

/**
 * Header Layout 6: Stacked Center
 */
function nexus_header_layout_6() {
    echo '<div class="header-row header-top">';
    echo '<div class="header-center">';
    nexus_render_logo();
    echo '</div>';
    echo '</div>';
    echo '<div class="header-row header-bottom">';
    echo '<div class="header-left">';
    nexus_render_navigation();
    echo '</div>';
    echo '<div class="header-right">';
    nexus_render_header_elements();
    echo '</div>';
    echo '</div>';
}

/**
 * Render Logo
 */
function nexus_render_logo() {
    if ( has_custom_logo() ) {
        the_custom_logo();
    } else {
        echo '<h1 class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a></h1>';
    }
}

/**
 * Render Navigation
 */
function nexus_render_navigation( $position = 'full' ) {
    if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'menu_class'     => 'nexus-nav nav-' . $position,
            'container'      => 'nav',
            'container_class' => 'primary-navigation',
        ) );
    }
}

/**
 * Render Header Elements
 */
function nexus_render_header_elements() {
    echo '<div class="header-elements">';
    
    // Phone
    $phone = get_theme_mod( 'nexus_header_phone' );
    if ( $phone ) {
        echo '<div class="header-phone">';
        echo '<i class="fas fa-phone"></i>';
        echo '<a href="tel:' . esc_attr( $phone ) . '">' . esc_html( $phone ) . '</a>';
        echo '</div>';
    }
    
    // Email
    $email = get_theme_mod( 'nexus_header_email' );
    if ( $email ) {
        echo '<div class="header-email">';
        echo '<i class="fas fa-envelope"></i>';
        echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
        echo '</div>';
    }
    
    // Search
    if ( get_theme_mod( 'nexus_header_search', false ) ) {
        echo '<div class="header-search">';
        echo '<button class="search-toggle"><i class="fas fa-search"></i></button>';
        echo '</div>';
    }
    
    // Social Icons
    if ( get_theme_mod( 'nexus_header_social', false ) ) {
        nexus_render_social_icons();
    }
    
    // Header Button
    $button_text = get_theme_mod( 'nexus_header_button_text' );
    $button_url = get_theme_mod( 'nexus_header_button_url' );
    if ( $button_text && $button_url ) {
        echo '<div class="header-button">';
        echo '<a href="' . esc_url( $button_url ) . '" class="btn btn-primary">' . esc_html( $button_text ) . '</a>';
        echo '</div>';
    }
    
    // Mobile Menu Toggle
    nexus_render_mobile_menu_toggle();
    
    echo '</div>';
}

/**
 * Render Mobile Menu Toggle
 */
function nexus_render_mobile_menu_toggle() {
    echo '<button class="mobile-menu-toggle" aria-label="' . esc_attr__( 'Toggle Menu', 'nexus-theme' ) . '">';
    echo '<span class="hamburger">';
    echo '<span></span>';
    echo '<span></span>';
    echo '<span></span>';
    echo '</span>';
    echo '</button>';
}

/**
 * Render Social Icons
 */
function nexus_render_social_icons() {
    $social_links = array(
        'facebook' => get_theme_mod( 'nexus_social_facebook' ),
        'twitter' => get_theme_mod( 'nexus_social_twitter' ),
        'instagram' => get_theme_mod( 'nexus_social_instagram' ),
        'linkedin' => get_theme_mod( 'nexus_social_linkedin' ),
        'youtube' => get_theme_mod( 'nexus_social_youtube' ),
    );
    
    $has_social = array_filter( $social_links );
    
    if ( $has_social ) {
        echo '<div class="header-social">';
        foreach ( $social_links as $platform => $url ) {
            if ( $url ) {
                echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener">';
                echo '<i class="fab fa-' . esc_attr( $platform ) . '"></i>';
                echo '</a>';
            }
        }
        echo '</div>';
    }
}