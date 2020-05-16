<?php
/**
 * EverStrap enqueue scripts
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'everstrap_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function everstrap_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' ) . time();
		// owl carousel css
		wp_enqueue_style( 'css-owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), $theme_version );
		wp_enqueue_style( 'css-slick', get_template_directory_uri() . '/assets/css/slick.css', array(), $theme_version );
		wp_enqueue_style( 'everstrap-styles', get_template_directory_uri() . '/assets/css/style.css', array(), $theme_version );

		// If user logged in then
		if( is_user_logged_in() )  {
			$styles = "
			@media screen and ( min-width: 600px ) {
				.sticky-header {
						top: 32px !important;
				}
			} ";
			wp_add_inline_style( 'everstrap-styles', $styles );
		}		
		
		// owl carousel js
		wp_enqueue_script( 'js-owl-carousel', get_template_directory_uri() . '/assets/js/
			owl.carousel.js', array( 'jquery' ), $theme_version, true );
		

		wp_enqueue_script( 'everstrap-slick', get_template_directory_uri() . '/assets/js/slick.js', array( 'jquery' ), $theme_version, true );		
		wp_enqueue_script( 'everstrap-loadmore', get_template_directory_uri() . '/assets/js/loadmore.js', array( 'jquery' ), $theme_version, true );		
		
		wp_enqueue_script( 'everstrap-scripts', get_template_directory_uri() . '/assets/js/bundle.js', array( 'jquery' ), $theme_version, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}		

		// Home page posts load more
		wp_localize_script( 'everstrap-loadmore', 'ajax_obj', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),			
		) );	
	    
	}
}

add_action( 'wp_enqueue_scripts', 'everstrap_scripts' );
