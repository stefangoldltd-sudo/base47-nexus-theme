<?php
/**
 * Main template file for Base47 Theme
 */

get_header();
?>

<?php
if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();

        // For your Mivon-based pages, the HTML will usually come from a shortcode
        // inside the page content. We just output the_content() and stay out of the way.
        the_content();

    endwhile;
else :
    echo '<p>' . esc_html__( 'No content found.', 'base47-theme' ) . '</p>';
endif;
?>

<?php
get_footer();