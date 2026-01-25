<?php
/**
 * Template Name: Base47 Canvas (Raw HTML Mode)
 * 
 * Pure HTML output - bypasses WordPress completely
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Disable admin bar
show_admin_bar( false );

// Set pure canvas mode flag
$GLOBALS['base47_pure_canvas_mode'] = true;

// Get the post content and process shortcodes
while ( have_posts() ) : the_post();
    $content = do_shortcode( get_the_content( null, false, $post ) );
endwhile;

// Extract <head> content (CSS, scripts)
$head_content = '';
if ( preg_match( '#<head\b[^>]*>(.*?)</head>#is', $content, $head_match ) ) {
    $head_content = $head_match[1];
}

// Extract <body> content (HTML)
$body_content = '';
if ( preg_match( '#<body\b[^>]*>(.*?)</body>#is', $content, $body_match ) ) {
    $body_content = $body_match[1];
}

// Output pure HTML - NO WordPress hooks
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $head_content; ?>
</head>
<body>
<?php echo $body_content; ?>
</body>
</html>
<?php
exit; // Stop WordPress immediately
?>
