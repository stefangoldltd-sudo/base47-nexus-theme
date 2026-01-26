<?php
/**
 * Nexus WooCommerce Integration
 * Complete e-commerce support like OceanWP/Astra
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WooCommerce Theme Support
 */
function nexus_woocommerce_setup() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'nexus_woocommerce_setup' );

/**
 * WooCommerce Customizer Settings
 */
function nexus_woocommerce_customizer( $wp_customize ) {
    
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }
    
    /* =============================================
       WOOCOMMERCE SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_woocommerce', array(
        'title'    => __( '🛒 WooCommerce', 'nexus-theme' ),
        'priority' => 33,
        'description' => __( 'Customize your online store appearance and functionality', 'nexus-theme' ),
    ) );

    // Shop Layout
    $wp_customize->add_setting( 'nexus_shop_layout', array(
        'default'           => 'grid',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_shop_layout', array(
        'label'       => __( 'Shop Layout', 'nexus-theme' ),
        'section'     => 'nexus_woocommerce',
        'type'        => 'select',
        'choices'     => array(
            'grid' => __( 'Grid Layout', 'nexus-theme' ),
            'list' => __( 'List Layout', 'nexus-theme' ),
        ),
    ) );

    // Products Per Row
    $wp_customize->add_setting( 'nexus_shop_columns', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'nexus_shop_columns', array(
        'label'       => __( 'Products Per Row', 'nexus-theme' ),
        'section'     => 'nexus_woocommerce',
        'type'        => 'select',
        'choices'     => array(
            '2' => __( '2 Columns', 'nexus-theme' ),
            '3' => __( '3 Columns', 'nexus-theme' ),
            '4' => __( '4 Columns', 'nexus-theme' ),
            '5' => __( '5 Columns', 'nexus-theme' ),
        ),
    ) );

    // Products Per Page
    $wp_customize->add_setting( 'nexus_shop_products_per_page', array(
        'default'           => 12,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'nexus_shop_products_per_page', array(
        'label'       => __( 'Products Per Page', 'nexus-theme' ),
        'section'     => 'nexus_woocommerce',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 4,
            'max'  => 48,
            'step' => 4,
        ),
    ) );

    // Show Sale Badge
    $wp_customize->add_setting( 'nexus_shop_sale_badge', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_shop_sale_badge', array(
        'label'       => __( 'Show Sale Badge', 'nexus-theme' ),
        'section'     => 'nexus_woocommerce',
        'type'        => 'checkbox',
    ) );

    // Show Product Rating
    $wp_customize->add_setting( 'nexus_shop_rating', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_shop_rating', array(
        'label'       => __( 'Show Product Rating', 'nexus-theme' ),
        'section'     => 'nexus_woocommerce',
        'type'        => 'checkbox',
    ) );

    // Show Add to Cart Button
    $wp_customize->add_setting( 'nexus_shop_add_to_cart', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_shop_add_to_cart', array(
        'label'       => __( 'Show Add to Cart Button', 'nexus-theme' ),
        'section'     => 'nexus_woocommerce',
        'type'        => 'checkbox',
    ) );

    /* =============================================
       SINGLE PRODUCT SECTION
    ============================================= */

    $wp_customize->add_section( 'nexus_single_product', array(
        'title'    => __( '📦 Single Product', 'nexus-theme' ),
        'priority' => 34,
        'description' => __( 'Customize individual product page layout', 'nexus-theme' ),
    ) );

    // Product Image Width
    $wp_customize->add_setting( 'nexus_product_image_width', array(
        'default'           => 50,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'nexus_product_image_width', array(
        'label'       => __( 'Product Image Width (%)', 'nexus-theme' ),
        'section'     => 'nexus_single_product',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 30,
            'max'  => 70,
            'step' => 5,
        ),
    ) );

    // Show Related Products
    $wp_customize->add_setting( 'nexus_related_products', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_related_products', array(
        'label'       => __( 'Show Related Products', 'nexus-theme' ),
        'section'     => 'nexus_single_product',
        'type'        => 'checkbox',
    ) );

    // Related Products Count
    $wp_customize->add_setting( 'nexus_related_products_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'nexus_related_products_count', array(
        'label'       => __( 'Related Products Count', 'nexus-theme' ),
        'section'     => 'nexus_single_product',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 2,
            'max'  => 12,
            'step' => 1,
        ),
        'active_callback' => function() {
            return get_theme_mod( 'nexus_related_products', true );
        },
    ) );

    // Show Product Tabs
    $wp_customize->add_setting( 'nexus_product_tabs', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_product_tabs', array(
        'label'       => __( 'Show Product Tabs', 'nexus-theme' ),
        'description' => __( 'Description, Reviews, Additional Information', 'nexus-theme' ),
        'section'     => 'nexus_single_product',
        'type'        => 'checkbox',
    ) );

    /* =============================================
       CART & CHECKOUT SECTION
    ============================================= */

    $wp_customize->add_section( 'nexus_cart_checkout', array(
        'title'    => __( '🛍️ Cart & Checkout', 'nexus-theme' ),
        'priority' => 35,
        'description' => __( 'Customize cart and checkout experience', 'nexus-theme' ),
    ) );

    // Cart Icon in Header
    $wp_customize->add_setting( 'nexus_header_cart', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_header_cart', array(
        'label'       => __( 'Show Cart Icon in Header', 'nexus-theme' ),
        'section'     => 'nexus_cart_checkout',
        'type'        => 'checkbox',
    ) );

    // Cart Dropdown
    $wp_customize->add_setting( 'nexus_cart_dropdown', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_cart_dropdown', array(
        'label'       => __( 'Cart Dropdown on Hover', 'nexus-theme' ),
        'section'     => 'nexus_cart_checkout',
        'type'        => 'checkbox',
        'active_callback' => function() {
            return get_theme_mod( 'nexus_header_cart', true );
        },
    ) );

    // Checkout Layout
    $wp_customize->add_setting( 'nexus_checkout_layout', array(
        'default'           => 'two-column',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_checkout_layout', array(
        'label'       => __( 'Checkout Layout', 'nexus-theme' ),
        'section'     => 'nexus_cart_checkout',
        'type'        => 'select',
        'choices'     => array(
            'one-column' => __( 'One Column', 'nexus-theme' ),
            'two-column' => __( 'Two Column', 'nexus-theme' ),
        ),
    ) );

    /* =============================================
       WOOCOMMERCE COLORS
    ============================================= */

    // Primary Button Color
    $wp_customize->add_setting( 'nexus_woo_primary_color', array(
        'default'           => '#ff4d00',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_woo_primary_color', array(
        'label'       => __( 'Primary Button Color', 'nexus-theme' ),
        'section'     => 'nexus_woocommerce',
    ) ) );

    // Sale Badge Color
    $wp_customize->add_setting( 'nexus_woo_sale_color', array(
        'default'           => '#e74c3c',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_woo_sale_color', array(
        'label'       => __( 'Sale Badge Color', 'nexus-theme' ),
        'section'     => 'nexus_woocommerce',
    ) ) );

    // Star Rating Color
    $wp_customize->add_setting( 'nexus_woo_star_color', array(
        'default'           => '#f39c12',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_woo_star_color', array(
        'label'       => __( 'Star Rating Color', 'nexus-theme' ),
        'section'     => 'nexus_woocommerce',
    ) ) );
}
add_action( 'customize_register', 'nexus_woocommerce_customizer' );

/**
 * WooCommerce Hooks and Filters
 */
function nexus_woocommerce_hooks() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }
    
    // Shop columns
    add_filter( 'loop_shop_columns', 'nexus_shop_columns' );
    
    // Products per page
    add_filter( 'loop_shop_per_page', 'nexus_shop_products_per_page' );
    
    // Related products
    add_filter( 'woocommerce_output_related_products_args', 'nexus_related_products_args' );
    
    // Remove/Add elements based on settings
    add_action( 'init', 'nexus_woocommerce_remove_elements' );
    
    // Add cart to header
    add_action( 'nexus_header_elements', 'nexus_header_cart_icon' );
    
    // Enqueue WooCommerce styles
    add_action( 'wp_enqueue_scripts', 'nexus_woocommerce_styles' );
}
add_action( 'init', 'nexus_woocommerce_hooks' );

/**
 * Set Shop Columns
 */
function nexus_shop_columns() {
    return get_theme_mod( 'nexus_shop_columns', 3 );
}

/**
 * Set Products Per Page
 */
function nexus_shop_products_per_page() {
    return get_theme_mod( 'nexus_shop_products_per_page', 12 );
}

/**
 * Related Products Args
 */
function nexus_related_products_args( $args ) {
    if ( ! get_theme_mod( 'nexus_related_products', true ) ) {
        return array();
    }
    
    $args['posts_per_page'] = get_theme_mod( 'nexus_related_products_count', 4 );
    $args['columns'] = get_theme_mod( 'nexus_shop_columns', 3 );
    
    return $args;
}

/**
 * Remove WooCommerce Elements Based on Settings
 */
function nexus_woocommerce_remove_elements() {
    // Remove sale badge
    if ( ! get_theme_mod( 'nexus_shop_sale_badge', true ) ) {
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
    }
    
    // Remove rating
    if ( ! get_theme_mod( 'nexus_shop_rating', true ) ) {
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    }
    
    // Remove add to cart button
    if ( ! get_theme_mod( 'nexus_shop_add_to_cart', true ) ) {
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    }
    
    // Remove product tabs
    if ( ! get_theme_mod( 'nexus_product_tabs', true ) ) {
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    }
}

/**
 * Add Cart Icon to Header
 */
function nexus_header_cart_icon() {
    if ( ! class_exists( 'WooCommerce' ) || ! get_theme_mod( 'nexus_header_cart', true ) ) {
        return;
    }
    
    $cart_count = WC()->cart->get_cart_contents_count();
    $cart_url = wc_get_cart_url();
    $dropdown = get_theme_mod( 'nexus_cart_dropdown', true );
    
    echo '<div class="header-cart' . ( $dropdown ? ' has-dropdown' : '' ) . '">';
    echo '<a href="' . esc_url( $cart_url ) . '" class="cart-icon">';
    echo '<i class="fas fa-shopping-cart"></i>';
    if ( $cart_count > 0 ) {
        echo '<span class="cart-count">' . esc_html( $cart_count ) . '</span>';
    }
    echo '</a>';
    
    if ( $dropdown ) {
        echo '<div class="cart-dropdown">';
        echo '<div class="widget_shopping_cart_content">';
        woocommerce_mini_cart();
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
}

/**
 * Enqueue WooCommerce Styles
 */
function nexus_woocommerce_styles() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }
    
    $ver = nexus_theme_get_version();
    $dir = get_template_directory_uri();
    
    wp_enqueue_style(
        'nexus-woocommerce',
        $dir . '/assets/css/woocommerce.css',
        array( 'nexus-style' ),
        $ver
    );
}

/**
 * Generate WooCommerce CSS
 */
function nexus_woocommerce_css() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return '';
    }
    
    $primary_color = get_theme_mod( 'nexus_woo_primary_color', '#ff4d00' );
    $sale_color = get_theme_mod( 'nexus_woo_sale_color', '#e74c3c' );
    $star_color = get_theme_mod( 'nexus_woo_star_color', '#f39c12' );
    $columns = get_theme_mod( 'nexus_shop_columns', 3 );
    $image_width = get_theme_mod( 'nexus_product_image_width', 50 );
    $layout = get_theme_mod( 'nexus_shop_layout', 'grid' );
    
    $column_width = 100 / $columns;
    $content_width = 100 - $image_width;
    
    $css = "
    /* WooCommerce Styles */
    .woocommerce .products li {
        width: {$column_width}%;
    }
    
    .woocommerce .button,
    .woocommerce button.button,
    .woocommerce input.button,
    .woocommerce #respond input#submit {
        background-color: {$primary_color};
        border-color: {$primary_color};
    }
    
    .woocommerce .button:hover,
    .woocommerce button.button:hover,
    .woocommerce input.button:hover,
    .woocommerce #respond input#submit:hover {
        background-color: " . nexus_darken_color( $primary_color, 10 ) . ";
        border-color: " . nexus_darken_color( $primary_color, 10 ) . ";
    }
    
    .woocommerce span.onsale {
        background-color: {$sale_color};
    }
    
    .woocommerce .star-rating span {
        color: {$star_color};
    }
    
    .woocommerce div.product div.images {
        width: {$image_width}%;
    }
    
    .woocommerce div.product div.summary {
        width: {$content_width}%;
    }
    
    .header-cart .cart-count {
        background-color: {$primary_color};
    }
    ";
    
    if ( $layout === 'list' ) {
        $css .= "
        .woocommerce ul.products li.product {
            display: flex;
            width: 100%;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
            padding: 20px;
        }
        
        .woocommerce ul.products li.product .woocommerce-loop-product__link {
            display: flex;
            width: 100%;
        }
        
        .woocommerce ul.products li.product img {
            width: 200px;
            margin-right: 20px;
        }
        ";
    }
    
    return $css;
}

/**
 * Darken Color Helper
 */
function nexus_darken_color( $hex, $percent ) {
    $hex = str_replace( '#', '', $hex );
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );
    
    $r = max( 0, min( 255, $r - ( $r * $percent / 100 ) ) );
    $g = max( 0, min( 255, $g - ( $g * $percent / 100 ) ) );
    $b = max( 0, min( 255, $b - ( $b * $percent / 100 ) ) );
    
    return sprintf( '#%02x%02x%02x', $r, $g, $b );
}

/**
 * Update Cart Count via AJAX
 */
function nexus_update_cart_count() {
    if ( class_exists( 'WooCommerce' ) ) {
        wp_localize_script( 'nexus-theme', 'nexusWoo', array(
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'cart_url' => wc_get_cart_url(),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'nexus_update_cart_count' );

/**
 * AJAX Update Cart Count
 */
function nexus_ajax_update_cart_count() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        wp_die();
    }
    
    wp_send_json( array(
        'count' => WC()->cart->get_cart_contents_count(),
    ) );
}
add_action( 'wp_ajax_nexus_update_cart_count', 'nexus_ajax_update_cart_count' );
add_action( 'wp_ajax_nopriv_nexus_update_cart_count', 'nexus_ajax_update_cart_count' );