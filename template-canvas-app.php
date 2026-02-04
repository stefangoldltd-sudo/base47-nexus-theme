<?php
/**
 * Template Name: Base47 Canvas App
 * 
 * Specialized canvas mode for Base47 app templates
 * Handles WordPress login state and admin bar properly
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    
    <!-- Enhanced viewport for mobile - iOS Safari fix -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- iOS-specific optimizations -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">

    <?php wp_head(); ?>
    
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
        body.admin-bar .dashboard-section,
        body.admin-bar .account-section,
        body.admin-bar .app-section {
            padding-top: 72px !important;
        }
        
        @media screen and (max-width: 782px) {
            body.admin-bar .dashboard-section,
            body.admin-bar .account-section,
            body.admin-bar .app-section {
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
</head>
<body <?php body_class('base47-app-canvas'); ?>>

<?php
// PURE HTML OUTPUT - NO WRAPPERS AT ALL
while ( have_posts() ) : the_post();
    the_content();
endwhile;
?>

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