<?php
/**
 * Header template for Base47 Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">

    <header class="site-header">
        <div class="content-wrapper base47-nav">
            <div class="base47-logo">
                Studio47
            </div>

            <nav class="base47-menu" aria-label="<?php esc_attr_e( 'Primary Menu', 'base47-theme' ); ?>">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    )
                );
                ?>
            </nav>
        </div>
    </header>

    <main class="site-main">
        <div class="content-wrapper">