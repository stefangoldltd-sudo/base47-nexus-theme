<?php

// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Load theme assets
 */
function base47_enqueue_assets() {
    wp_enqueue_style('base47-style', get_stylesheet_uri(), [], '1.0.0');
}
add_action('wp_enqueue_scripts', 'base47_enqueue_assets');

/**
 * Remove default WP junk for ultra clean HTML output
 */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header');
