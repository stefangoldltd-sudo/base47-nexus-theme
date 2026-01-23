<?php
/**
 * Template Name: Base47 App Canvas (Self-Contained Mode)
 * 
 * Pure HTML output for app templates with self-contained CSS
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Disable admin bar
show_admin_bar( false );

// Set app canvas mode flag (NEW MODE)
$GLOBALS['base47_app_canvas_mode'] = true;

// Get the post content and process shortcodes
while ( have_posts() ) : the_post();
    $content = do_shortcode( get_the_content( null, false, $post ) );
endwhile;

// For app templates, the content is already a complete HTML document
// Just output it directly - no extraction needed
echo $content;

exit; // Stop WordPress immediately
?>