<?php
/**
 * Check and setup theme's default settings
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'everstrap_setup_theme_default_settings' ) ) {
	function everstrap_setup_theme_default_settings() {

		// check if settings are set, if not set defaults.
		// Caution: DO NOT check existence using === always check with == .
		// Latest blog posts style.
		$everstrap_posts_index_style = get_theme_mod( 'everstrap_posts_index_style' );
		if ( '' === $everstrap_posts_index_style ) {
			set_theme_mod( 'everstrap_posts_index_style', 'default' );
		}

		// Sidebar position.
		$everstrap_sidebar_position = get_theme_mod( 'everstrap_sidebar_position' );
		if ( '' === $everstrap_sidebar_position ) {
			set_theme_mod( 'everstrap_sidebar_position', 'right' );
		}

		// Container width.
		$everstrap_container_type = get_theme_mod( 'everstrap_container_type' );
		if ( '' === $everstrap_container_type ) {
			set_theme_mod( 'everstrap_container_type', 'container' );
		}
	}
}


/**
 * Support theme option using ACF
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page( array(
		'page_title' => 'Theme Options',
		'menu_title' => 'Theme Options',
		'menu_slug'  => 'theme-options',
		'capability' => 'edit_posts',
		'redirect'   => false,
	) );
}
