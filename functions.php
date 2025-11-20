<?php

/* ---------------------------------------------
   Base47 Theme – Minimal + Useful
   Optimized for raw HTML templates and Mivon HTML Editor
--------------------------------------------- */

// Disable Gutenberg everywhere (we are raw HTML people)
add_filter('use_block_editor_for_post', '__return_false', 10);

// Disable WP emojis (performance)
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Disable WP’s default frontend styles that break designs
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
}, 100);


/* ---------------------------------------------
   Load our minimal CSS resets + helpers
--------------------------------------------- */

add_action('wp_enqueue_scripts', function () {

    // Normalize.css (reset)
    wp_enqueue_style(
        'base47-normalize',
        get_template_directory_uri() . '/assets/css/normalize.css',
        [],
        '8.0'
    );

    // Base47 core helpers (will create file next)
    wp_enqueue_style(
        'base47-core',
        get_template_directory_uri() . '/assets/css/base47-core.css',
        [],
        '1.0'
    );
});


/* ---------------------------------------------
   Theme support
--------------------------------------------- */

add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );


/* ---------------------------------------------
   Remove automatic <p> and <br> from content
   (raw HTML should stay RAW)
--------------------------------------------- */

remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');


/* ---------------------------------------------
   Disable srcset to avoid layout break
--------------------------------------------- */

add_filter('wp_calculate_image_srcset', '__return_false');