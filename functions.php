<?php
/**
 * Theme functions and definitions
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$everstrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/jetpack.php',                         // Load Jetpack compatibility file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation?
	'/wp-admin.php',                        // /wp-admin/ related functions
	'/modules.php',                         // Common module functions.
	'/metaboxes.php',                        //Custom metaboxes function
	'/short-codes.php',                     // Theme short codes
	'/migration.php',                       // Migration file
	'/custom-post-type.php',                // Custom Post Type

);

// phpcs:disable
foreach ( $everstrap_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}


/**
 * Load webDirectoryPro functions.
 */
if ( class_exists( 'WebDirectoryPro' ) ) {

    $wdp_includes = array(
        '/directory-post-types.php',
        '/directory-functions.php'
    );

    foreach ( $wdp_includes as $wdp ) {

        $filepath = locate_template( 'web-directory-pro' . $wdp );

        if ( ! $filepath ) {
            trigger_error( sprintf( 'Error locating /inc%s for inclusion', $wdp ), E_USER_ERROR );
        }

        require_once $filepath;
    }
}