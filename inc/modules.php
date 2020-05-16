<?php
/**
 * everstrap modules and definitions
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$everstrap_modules = array(
	'/class-everstrap-load-more.php',                  // Load more posts functions.
	'/class-everstrap-infinite-scroll.php',            // Load infinite scroll for single post.
);

foreach ( $everstrap_modules as $file ) {
	$filepath = locate_template( 'modules' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /modules%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
