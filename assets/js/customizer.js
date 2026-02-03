/**
 * Nexus Theme Customizer JS
 * WordPress.org compliant customizer preview
 * 
 * @package Nexus
 * @since 4.0.0
 */

( function( $ ) {

    // Site title and description.
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            $( '.site-title a' ).text( to );
        } );
    } );
    
    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( to ) {
            $( '.site-description' ).text( to );
        } );
    } );

    // Logo width
    wp.customize( 'nexus_logo_width', function( value ) {
        value.bind( function( to ) {
            $( '.custom-logo' ).css( 'max-width', to + 'px' );
        } );
    } );

    // Header background color
    wp.customize( 'nexus_header_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '.site-header' ).css( 'background-color', to );
        } );
    } );

    // Primary color
    wp.customize( 'nexus_primary_color', function( value ) {
        value.bind( function( to ) {
            $( 'a, .primary-color' ).css( 'color', to );
            $( '.btn-primary, .primary-bg' ).css( 'background-color', to );
        } );
    } );

    // Container width
    wp.customize( 'nexus_container_width', function( value ) {
        value.bind( function( to ) {
            $( '.container' ).css( 'max-width', to + 'px' );
        } );
    } );

    // Body font size
    wp.customize( 'nexus_body_font_size', function( value ) {
        value.bind( function( to ) {
            $( 'body' ).css( 'font-size', to + 'px' );
        } );
    } );

    // Footer text
    wp.customize( 'nexus_footer_text', function( value ) {
        value.bind( function( to ) {
            $( '.footer-text' ).html( to );
        } );
    } );

} )( jQuery );