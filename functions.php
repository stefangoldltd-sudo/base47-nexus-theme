<?php
/**
 * Base47 Theme functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Setup theme supports & menus.
 */
function base47_theme_setup() {

    // Let WordPress handle <title> tag.
    add_theme_support( 'title-tag' );

    // Enable featured images (if you ever use posts).
    add_theme_support( 'post-thumbnails' );

    // Basic menu location.
    register_nav_menus(
        array(
            'primary' => __( 'Primary Menu', 'base47-theme' ),
        )
    );
}
add_action( 'after_setup_theme', 'base47_theme_setup' );

/**
 * Enqueue styles & scripts.
 * Keep it ultra-light so it doesn’t fight Mivon template CSS.
 */
function base47_theme_scripts() {

    // Theme main stylesheet.
    wp_enqueue_style(
        'base47-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'base47_theme_scripts' );