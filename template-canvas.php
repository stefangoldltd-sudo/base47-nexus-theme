<?php
/**
 * Template Name: Base47 Canvas (Raw HTML Mode)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body class="base47-canvas">

<?php
while ( have_posts() ) : the_post();
    // OUTPUT RAW HTML ONLY
    echo do_shortcode( get_the_content( null, false, $post ) );
endwhile;
?>

<?php wp_footer(); ?>
</body>
</html>