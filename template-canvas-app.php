<?php
/**
 * Template Name: Base47 Canvas App (Dashboard/Account Mode)
 * 
 * Specialized canvas mode for Base47 app templates (dashboard, account, etc.)
 * Handles WordPress login state and admin bar properly
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Set app canvas mode flag
$GLOBALS['base47_app_canvas_mode'] = true;

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
} else {
    // If no body tags found, use entire content
    $body_content = $content;
}

// Check if user is logged in and admin bar should show
$show_admin_bar = is_user_logged_in() && is_admin_bar_showing();
$admin_bar_class = $show_admin_bar ? 'admin-bar' : '';

// Output app canvas HTML with WordPress compatibility
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    // Include WordPress head for login state, admin bar, etc.
    wp_head(); 
    ?>
    
    <!-- App Canvas Mode Styles -->
    <style>
        /* Force app canvas mode - override all WordPress styling */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            background: #fafafa !important;
            min-height: 100vh !important;
            overflow-x: hidden !important;
        }
        
        /* Hide WordPress elements that interfere with app layout */
        .wp-site-blocks,
        .wp-block-group,
        .site-header,
        .site-footer,
        .entry-header,
        .entry-footer {
            display: none !important;
        }
        
        /* Ensure main content area is clean */
        #page,
        .site,
        .site-main,
        main,
        article,
        .entry-content {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
        }
        
        /* Admin bar compensation for logged-in users */
        body.admin-bar {
            margin-top: 0 !important;
        }
        
        body.admin-bar .dashboard-section {
            padding-top: 72px !important;
        }
        
        @media screen and (max-width: 782px) {
            body.admin-bar .dashboard-section {
                padding-top: 86px !important;
            }
        }
        
        /* Force app content to be visible and properly styled */
        .dashboard-section,
        .account-section,
        .app-section {
            display: block !important;
            background: #fafafa !important;
            min-height: 100vh !important;
            position: relative !important;
            z-index: 1 !important;
        }
        
        /* Remove any WordPress container constraints */
        .container,
        .wp-container {
            max-width: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        /* Ensure proper font loading */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }
    </style>
    
    <?php echo $head_content; ?>
</head>
<body <?php body_class( $admin_bar_class . ' base47-app-canvas' ); ?>>

<?php 
// Show admin bar if user is logged in
if ( $show_admin_bar ) {
    wp_admin_bar_render();
}
?>

<div id="page" class="site">
    <main id="main" class="site-main">
        <article class="entry-content">
            <?php echo $body_content; ?>
        </article>
    </main>
</div>

<?php wp_footer(); ?>

<script>
// Enhanced app canvas mode JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Force app canvas styling
    document.body.style.background = '#fafafa';
    document.documentElement.style.background = '#fafafa';
    
    // Ensure app sections are visible
    const appSections = document.querySelectorAll('.dashboard-section, .account-section, .app-section');
    appSections.forEach(section => {
        section.style.display = 'block';
        section.style.minHeight = '100vh';
        section.style.background = '#fafafa';
    });
    
    // Handle admin bar spacing dynamically
    const adminBar = document.getElementById('wpadminbar');
    const dashboardSection = document.querySelector('.dashboard-section, .account-section, .app-section');
    
    if (adminBar && dashboardSection) {
        const adminBarHeight = adminBar.offsetHeight;
        dashboardSection.style.paddingTop = (adminBarHeight + 40) + 'px';
    }
    
    // Remove WordPress body classes that might interfere
    document.body.classList.remove('wp-embed-responsive', 'wp-custom-logo');
    
    // Add app canvas class
    document.body.classList.add('base47-app-canvas');
});
</script>

</body>
</html>
<?php
// Don't exit like pure canvas - we need WordPress footer for login state
?>