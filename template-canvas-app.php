<?php
/**
 * Template Name: Base47 Canvas App
 * 
 * Specialized canvas mode for Base47 app templates
 * Pure HTML output with app-specific optimizations
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Disable admin bar
show_admin_bar( false );

// Set pure canvas mode flag - CRITICAL for proper rendering
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
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- iOS-specific optimizations -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
    
    <?php echo $head_content; ?>
    
    <!-- Safe Canvas App Mode Fix -->
    <style>
        /* Safe Canvas App Mode CSS - Only affects Canvas App pages */
        body.base47-app-canvas {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Hide WordPress elements on Canvas App pages only */
        body.base47-app-canvas .scroll-to-top,
        body.base47-app-canvas #wpadminbar,
        body.base47-app-canvas .wp-toolbar {
            display: none !important;
        }
        
        /* Admin bar spacing */
        <?php if ( is_admin_bar_showing() ) : ?>
        body.base47-app-canvas {
            padding-top: 32px !important;
        }
        @media screen and (max-width: 782px) { 
            body.base47-app-canvas {
                padding-top: 46px !important;
            }
        }
        <?php endif; ?>
        
        /* Fix first section positioning - Universal fix for ALL templates */
        body.base47-app-canvas > *:first-child,
        body.base47-app-canvas > section:first-of-type,
        body.base47-app-canvas > div:first-of-type,
        body.base47-app-canvas .hero-style1,
        body.base47-app-canvas .hero-style4,
        body.base47-app-canvas .pg-hero {
            margin-top: 0 !important;
            padding-top: 100px !important; /* Space for fixed header */
        }
        
        /* Mobile spacing adjustment */
        @media screen and (max-width: 991px) {
            body.base47-app-canvas > *:first-child,
            body.base47-app-canvas > section:first-of-type,
            body.base47-app-canvas > div:first-of-type,
            body.base47-app-canvas .hero-style1,
            body.base47-app-canvas .hero-style4,
            body.base47-app-canvas .pg-hero {
                padding-top: 80px !important;
            }
        }
    </style>
    
    <!-- Safe JavaScript fixes -->
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            // Remove theme's scroll-to-top button
            const scrollButtons = document.querySelectorAll('.scroll-to-top');
            scrollButtons.forEach(btn => btn.remove());
            
            // Disable theme's scroll-to-top setup if it exists
            if (window.NexusTheme && window.NexusTheme.setupScrollToTop) {
                window.NexusTheme.setupScrollToTop = function() {};
            }
        });
    </script>
</head>
<body class="base47-app-canvas">
<?php echo $body_content; ?>
</body>
</html>
<?php
exit; // Stop WordPress immediately - CRITICAL
?>