<?php
/**
 * The sidebar containing the main widget area
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<div class="col-md-4 widget-area custom-sidebar" id="secondary" role="complementary">
	<?php
	// Because we need put a full width advertisement on middle of the home page :(
	// Right top sidebar

	// Only show on advetisement page
	if ( is_page( 'advertise' ) ) {
		if ( is_active_sidebar( 'media-kit-widget' ) ) {
			dynamic_sidebar( 'media-kit-widget' );
		}
	} else if ( is_singular( 'post' ) ) {
		if ( is_active_sidebar( 'single-right-sidebar' ) ) {
			dynamic_sidebar( 'single-right-sidebar' );
		}
	} else if ( is_author() ) {
		if ( is_active_sidebar( 'author-right-sidebar' ) ) {
			dynamic_sidebar( 'author-right-sidebar' );
		}
	} else {
		if ( is_active_sidebar( 'right-top-sidebar' ) ) {
			dynamic_sidebar( 'right-top-sidebar' );
		}
	}

	
	?>
</div><!-- #secondary -->
