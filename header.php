<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    
    <!-- Enhanced viewport for mobile - iOS Safari fix -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">

    <!-- Prevent WordPress from adding weird formatting -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- iOS-specific optimizations -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <!-- Prevent format detection interference -->
    <meta name="format-detection" content="telephone=no">

    <!-- Minimal theme CSS reset (loaded in functions.php) -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
