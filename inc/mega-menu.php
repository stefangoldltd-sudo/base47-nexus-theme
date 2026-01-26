<?php
/**
 * Nexus Mega Menu System
 * Advanced navigation like OceanWP/Astra
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Mega Menu Customizer Settings
 */
function nexus_mega_menu_customizer( $wp_customize ) {
    
    /* =============================================
       MEGA MENU SECTION
    ============================================= */
    
    $wp_customize->add_section( 'nexus_mega_menu', array(
        'title'    => __( '🚀 Mega Menu', 'nexus-theme' ),
        'priority' => 32,
        'description' => __( 'Advanced navigation with multi-column layouts, images, and widgets', 'nexus-theme' ),
    ) );

    // Enable Mega Menu
    $wp_customize->add_setting( 'nexus_mega_menu_enabled', array(
        'default'           => true,
        'sanitize_callback' => 'nexus_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'nexus_mega_menu_enabled', array(
        'label'       => __( 'Enable Mega Menu', 'nexus-theme' ),
        'description' => __( 'Activate advanced mega menu functionality', 'nexus-theme' ),
        'section'     => 'nexus_mega_menu',
        'type'        => 'checkbox',
    ) );

    // Mega Menu Width
    $wp_customize->add_setting( 'nexus_mega_menu_width', array(
        'default'           => 'container',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_mega_menu_width', array(
        'label'       => __( 'Mega Menu Width', 'nexus-theme' ),
        'section'     => 'nexus_mega_menu',
        'type'        => 'select',
        'choices'     => array(
            'container' => __( 'Container Width', 'nexus-theme' ),
            'full'      => __( 'Full Width', 'nexus-theme' ),
            'custom'    => __( 'Custom Width', 'nexus-theme' ),
        ),
    ) );

    // Custom Width
    $wp_customize->add_setting( 'nexus_mega_menu_custom_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'nexus_mega_menu_custom_width', array(
        'label'       => __( 'Custom Width (px)', 'nexus-theme' ),
        'section'     => 'nexus_mega_menu',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 800,
            'max'  => 1920,
            'step' => 50,
        ),
        'active_callback' => function() {
            return get_theme_mod( 'nexus_mega_menu_width' ) === 'custom';
        },
    ) );

    // Animation
    $wp_customize->add_setting( 'nexus_mega_menu_animation', array(
        'default'           => 'fade',
        'sanitize_callback' => 'nexus_sanitize_select',
    ) );

    $wp_customize->add_control( 'nexus_mega_menu_animation', array(
        'label'       => __( 'Animation Effect', 'nexus-theme' ),
        'section'     => 'nexus_mega_menu',
        'type'        => 'select',
        'choices'     => array(
            'none'      => __( 'None', 'nexus-theme' ),
            'fade'      => __( 'Fade In', 'nexus-theme' ),
            'slide'     => __( 'Slide Down', 'nexus-theme' ),
            'zoom'      => __( 'Zoom In', 'nexus-theme' ),
        ),
    ) );

    // Mobile Breakpoint
    $wp_customize->add_setting( 'nexus_mega_menu_mobile_breakpoint', array(
        'default'           => 768,
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'nexus_mega_menu_mobile_breakpoint', array(
        'label'       => __( 'Mobile Breakpoint (px)', 'nexus-theme' ),
        'description' => __( 'Switch to mobile menu below this width', 'nexus-theme' ),
        'section'     => 'nexus_mega_menu',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 480,
            'max'  => 1024,
            'step' => 1,
        ),
    ) );

    /* =============================================
       MEGA MENU STYLING
    ============================================= */

    // Background Color
    $wp_customize->add_setting( 'nexus_mega_menu_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_mega_menu_bg_color', array(
        'label'       => __( 'Background Color', 'nexus-theme' ),
        'section'     => 'nexus_mega_menu',
    ) ) );

    // Text Color
    $wp_customize->add_setting( 'nexus_mega_menu_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_mega_menu_text_color', array(
        'label'       => __( 'Text Color', 'nexus-theme' ),
        'section'     => 'nexus_mega_menu',
    ) ) );

    // Link Hover Color
    $wp_customize->add_setting( 'nexus_mega_menu_hover_color', array(
        'default'           => '#ff4d00',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_mega_menu_hover_color', array(
        'label'       => __( 'Link Hover Color', 'nexus-theme' ),
        'section'     => 'nexus_mega_menu',
    ) ) );

    // Border Color
    $wp_customize->add_setting( 'nexus_mega_menu_border_color', array(
        'default'           => '#e0e0e0',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nexus_mega_menu_border_color', array(
        'label'       => __( 'Border Color', 'nexus-theme' ),
        'section'     => 'nexus_mega_menu',
    ) ) );
}
add_action( 'customize_register', 'nexus_mega_menu_customizer' );

/**
 * Initialize Mega Menu
 */
function nexus_mega_menu_init() {
    if ( ! get_theme_mod( 'nexus_mega_menu_enabled', true ) ) {
        return;
    }
    
    // Add mega menu support to nav menus
    add_action( 'wp_nav_menu_item_custom_fields', 'nexus_mega_menu_fields', 10, 4 );
    add_action( 'wp_update_nav_menu_item', 'nexus_save_mega_menu_fields', 10, 3 );
    add_filter( 'wp_nav_menu_objects', 'nexus_mega_menu_objects', 10, 2 );
    
    // Enqueue mega menu assets
    add_action( 'wp_enqueue_scripts', 'nexus_mega_menu_assets' );
}
add_action( 'init', 'nexus_mega_menu_init' );

/**
 * Add Mega Menu Fields to Menu Items
 */
function nexus_mega_menu_fields( $item_id, $item, $depth, $args ) {
    if ( $depth !== 0 ) return; // Only for top-level items
    
    $mega_enabled = get_post_meta( $item_id, '_nexus_mega_enabled', true );
    $mega_columns = get_post_meta( $item_id, '_nexus_mega_columns', true ) ?: '4';
    $mega_image = get_post_meta( $item_id, '_nexus_mega_image', true );
    $mega_description = get_post_meta( $item_id, '_nexus_mega_description', true );
    ?>
    <div class="nexus-mega-menu-fields" style="margin: 10px 0; padding: 10px; border: 1px solid #ddd; background: #f9f9f9;">
        <h4><?php _e( 'Mega Menu Settings', 'nexus-theme' ); ?></h4>
        
        <p>
            <label>
                <input type="checkbox" name="nexus_mega_enabled[<?php echo $item_id; ?>]" value="1" <?php checked( $mega_enabled, '1' ); ?>>
                <?php _e( 'Enable Mega Menu', 'nexus-theme' ); ?>
            </label>
        </p>
        
        <p>
            <label><?php _e( 'Columns:', 'nexus-theme' ); ?></label><br>
            <select name="nexus_mega_columns[<?php echo $item_id; ?>]">
                <option value="2" <?php selected( $mega_columns, '2' ); ?>>2 <?php _e( 'Columns', 'nexus-theme' ); ?></option>
                <option value="3" <?php selected( $mega_columns, '3' ); ?>>3 <?php _e( 'Columns', 'nexus-theme' ); ?></option>
                <option value="4" <?php selected( $mega_columns, '4' ); ?>>4 <?php _e( 'Columns', 'nexus-theme' ); ?></option>
                <option value="5" <?php selected( $mega_columns, '5' ); ?>>5 <?php _e( 'Columns', 'nexus-theme' ); ?></option>
            </select>
        </p>
        
        <p>
            <label><?php _e( 'Featured Image URL:', 'nexus-theme' ); ?></label><br>
            <input type="url" name="nexus_mega_image[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $mega_image ); ?>" style="width: 100%;">
            <small><?php _e( 'Optional: Add a featured image to this mega menu', 'nexus-theme' ); ?></small>
        </p>
        
        <p>
            <label><?php _e( 'Description:', 'nexus-theme' ); ?></label><br>
            <textarea name="nexus_mega_description[<?php echo $item_id; ?>]" rows="3" style="width: 100%;"><?php echo esc_textarea( $mega_description ); ?></textarea>
            <small><?php _e( 'Optional: Add a description for this menu item', 'nexus-theme' ); ?></small>
        </p>
    </div>
    <?php
}

/**
 * Save Mega Menu Fields
 */
function nexus_save_mega_menu_fields( $menu_id, $menu_item_db_id, $args ) {
    if ( isset( $_POST['nexus_mega_enabled'][$menu_item_db_id] ) ) {
        update_post_meta( $menu_item_db_id, '_nexus_mega_enabled', '1' );
    } else {
        delete_post_meta( $menu_item_db_id, '_nexus_mega_enabled' );
    }
    
    if ( isset( $_POST['nexus_mega_columns'][$menu_item_db_id] ) ) {
        update_post_meta( $menu_item_db_id, '_nexus_mega_columns', sanitize_text_field( $_POST['nexus_mega_columns'][$menu_item_db_id] ) );
    }
    
    if ( isset( $_POST['nexus_mega_image'][$menu_item_db_id] ) ) {
        update_post_meta( $menu_item_db_id, '_nexus_mega_image', esc_url_raw( $_POST['nexus_mega_image'][$menu_item_db_id] ) );
    }
    
    if ( isset( $_POST['nexus_mega_description'][$menu_item_db_id] ) ) {
        update_post_meta( $menu_item_db_id, '_nexus_mega_description', sanitize_textarea_field( $_POST['nexus_mega_description'][$menu_item_db_id] ) );
    }
}

/**
 * Process Mega Menu Objects
 */
function nexus_mega_menu_objects( $items, $args ) {
    if ( ! get_theme_mod( 'nexus_mega_menu_enabled', true ) ) {
        return $items;
    }
    
    foreach ( $items as $item ) {
        $item->mega_enabled = get_post_meta( $item->ID, '_nexus_mega_enabled', true );
        $item->mega_columns = get_post_meta( $item->ID, '_nexus_mega_columns', true ) ?: '4';
        $item->mega_image = get_post_meta( $item->ID, '_nexus_mega_image', true );
        $item->mega_description = get_post_meta( $item->ID, '_nexus_mega_description', true );
    }
    
    return $items;
}

/**
 * Enqueue Mega Menu Assets
 */
function nexus_mega_menu_assets() {
    if ( ! get_theme_mod( 'nexus_mega_menu_enabled', true ) ) {
        return;
    }
    
    $ver = nexus_theme_get_version();
    $dir = get_template_directory_uri();
    
    // Mega Menu CSS
    wp_enqueue_style(
        'nexus-mega-menu',
        $dir . '/assets/css/mega-menu.css',
        array( 'nexus-style' ),
        $ver
    );
    
    // Mega Menu JS
    wp_enqueue_script(
        'nexus-mega-menu',
        $dir . '/assets/js/mega-menu.js',
        array( 'jquery' ),
        $ver,
        true
    );
    
    // Localize script
    wp_localize_script( 'nexus-mega-menu', 'nexusMegaMenu', array(
        'animation' => get_theme_mod( 'nexus_mega_menu_animation', 'fade' ),
        'mobileBreakpoint' => get_theme_mod( 'nexus_mega_menu_mobile_breakpoint', 768 ),
    ) );
}

/**
 * Generate Mega Menu CSS
 */
function nexus_mega_menu_css() {
    if ( ! get_theme_mod( 'nexus_mega_menu_enabled', true ) ) {
        return '';
    }
    
    $bg_color = get_theme_mod( 'nexus_mega_menu_bg_color', '#ffffff' );
    $text_color = get_theme_mod( 'nexus_mega_menu_text_color', '#333333' );
    $hover_color = get_theme_mod( 'nexus_mega_menu_hover_color', '#ff4d00' );
    $border_color = get_theme_mod( 'nexus_mega_menu_border_color', '#e0e0e0' );
    $width = get_theme_mod( 'nexus_mega_menu_width', 'container' );
    $custom_width = get_theme_mod( 'nexus_mega_menu_custom_width', 1200 );
    $mobile_breakpoint = get_theme_mod( 'nexus_mega_menu_mobile_breakpoint', 768 );
    
    $mega_width = 'container';
    if ( $width === 'full' ) {
        $mega_width = '100vw';
    } elseif ( $width === 'custom' ) {
        $mega_width = $custom_width . 'px';
    }
    
    $css = "
    /* Mega Menu Styles */
    .nexus-mega-menu {
        background-color: {$bg_color};
        color: {$text_color};
        border: 1px solid {$border_color};
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    
    .nexus-mega-menu .mega-menu-content {
        width: {$mega_width};
        max-width: 100%;
    }
    
    .nexus-mega-menu a {
        color: {$text_color};
        transition: color 0.3s ease;
    }
    
    .nexus-mega-menu a:hover {
        color: {$hover_color};
    }
    
    .nexus-mega-menu .mega-menu-column h4 {
        color: {$hover_color};
        border-bottom: 2px solid {$border_color};
    }
    
    @media (max-width: {$mobile_breakpoint}px) {
        .nexus-mega-menu {
            position: static !important;
            width: 100% !important;
            box-shadow: none;
            border-radius: 0;
        }
        
        .nexus-mega-menu .mega-menu-columns {
            flex-direction: column;
        }
        
        .nexus-mega-menu .mega-menu-column {
            width: 100% !important;
            margin-bottom: 20px;
        }
    }
    ";
    
    return $css;
}

/**
 * Custom Walker for Mega Menu
 */
class Nexus_Mega_Menu_Walker extends Walker_Nav_Menu {
    
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        
        if ( $depth === 0 ) {
            $output .= "\n$indent<div class=\"nexus-mega-menu\">\n";
            $output .= "$indent\t<div class=\"mega-menu-content\">\n";
            $output .= "$indent\t\t<div class=\"mega-menu-columns\">\n";
        } else {
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        }
    }
    
    function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        
        if ( $depth === 0 ) {
            $output .= "$indent\t\t</div>\n";
            $output .= "$indent\t</div>\n";
            $output .= "$indent</div>\n";
        } else {
            $output .= "$indent</ul>\n";
        }
    }
    
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        if ( $item->mega_enabled && $depth === 0 ) {
            $classes[] = 'has-mega-menu';
            $classes[] = 'mega-columns-' . $item->mega_columns;
        }
        
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        
        if ( $depth === 1 && $this->is_mega_menu_parent( $item ) ) {
            // Mega menu column
            $output .= $indent . '<div class="mega-menu-column">';
            
            if ( $item->mega_image ) {
                $output .= '<div class="mega-menu-image">';
                $output .= '<img src="' . esc_url( $item->mega_image ) . '" alt="' . esc_attr( $item->title ) . '">';
                $output .= '</div>';
            }
            
            $output .= '<h4>' . esc_html( $item->title ) . '</h4>';
            
            if ( $item->mega_description ) {
                $output .= '<p class="mega-menu-description">' . esc_html( $item->mega_description ) . '</p>';
            }
            
            $output .= '<ul class="mega-menu-links">';
        } else {
            $output .= $indent . '<li' . $id . $class_names .'>';
        }
        
        $attributes = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        
        $item_output = isset( $args->before ) ? $args->before : '';
        $item_output .= '<a' . $attributes .'>';
        $item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . apply_filters( 'the_title', $item->title, $item->ID ) . ( isset( $args->link_after ) ? $args->link_after : '' );
        $item_output .= '</a>';
        $item_output .= isset( $args->after ) ? $args->after : '';
        
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    
    function end_el( &$output, $item, $depth = 0, $args = null ) {
        if ( $depth === 1 && $this->is_mega_menu_parent( $item ) ) {
            $output .= "</ul></div>\n";
        } else {
            $output .= "</li>\n";
        }
    }
    
    private function is_mega_menu_parent( $item ) {
        // Check if parent has mega menu enabled
        $parent_id = $item->menu_item_parent;
        if ( $parent_id ) {
            return get_post_meta( $parent_id, '_nexus_mega_enabled', true );
        }
        return false;
    }
}