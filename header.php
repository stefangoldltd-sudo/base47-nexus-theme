<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Prevent WordPress from adding weird formatting -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Minimal theme CSS reset (loaded in functions.php) -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>