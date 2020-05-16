<?php
/**
 * Theme basic setup
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 753; /* pixels */ //phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
}

add_action( 'after_setup_theme', 'everstrap_setup' );

if ( ! function_exists( 'everstrap_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function everstrap_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on everstrap, use a find and replace
		 * to change 'everstrap' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'everstrap', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'category_menu'        => __( 'Categories Menu', 'everstrap' ),
				'page_menu'            => __( 'Pages Menu', 'everstrap' ),
				'directories-dropdown' => __( 'Directory Dropdown', 'everstrap' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Adding Thumbnail basic support
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Adding Image Size
		 */
		add_image_size( 'site-header-logo', 199, 84, true );
		add_image_size( 'site-footer-logo', 165, 39, true );
		add_image_size( 'full-article', 753, 500, true );
		add_image_size( 'full-category', 753, 480, true );
		add_image_size( 'thumb-article', 369, 245, true );
		add_image_size( 'small-thumb', 80, 80, true );
		add_image_size( 'latest-thumb', 272, 211, true );
		add_image_size( 'slider-thumb', 146, 88, true );
		add_image_size( 'owner-thumb', 177, 159, array( 'center', 'top' ) );
		add_image_size( 'author-thumb', 97, 97, true );
		add_image_size( 'small-post-thumb', 80, 80, true );
		add_image_size( 'directory-search-result-thumb', 176, 133, true );
		add_image_size( 'event-featured-image', 690, 518, true );
		add_image_size( 'event-small', 180, 120, true );

		/*
		 * Adding support for Widget edit icons in customizer
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'everstrap_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Set up the WordPress Theme logo feature.
		add_theme_support( 'custom-logo' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Check and setup theme default settings.
		everstrap_setup_theme_default_settings();

	}
}


add_filter( 'excerpt_more', 'everstrap_custom_excerpt_more' );

if ( ! function_exists( 'everstrap_custom_excerpt_more' ) ) {
	/**
	 * Removes the ... from the excerpt read more link
	 *
	 * @param string $more The excerpt.
	 *
	 * @return string
	 */
	function everstrap_custom_excerpt_more( $more ) {
		if ( ! is_admin() ) {
			$more = '';
		}
		return $more;
	}
}

//phpcs:ignore Squiz.PHP.CommentedOutCode.Found
// add_filter( 'wp_trim_excerpt', 'everstrap_all_excerpts_get_more_link' );

// if ( ! function_exists( 'everstrap_all_excerpts_get_more_link' ) ) {
// **
// * Adds a custom read more link to all excerpts, manually or automatically generated
// *
// * @param string $post_excerpt Posts's excerpt.
// *
// * @return string
// */
// function everstrap_all_excerpts_get_more_link( $post_excerpt ) {
// if ( ! is_admin() ) {
// $post_excerpt = $post_excerpt . ' [...]<p><a class="btn btn-secondary everstrap-read-more-link" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __( 'Read More...',
// 'everstrap' ) . '</a></p>';
// }
// return $post_excerpt;
// }
// }

add_image_size( 'img-small-size', 225, 225, true );
