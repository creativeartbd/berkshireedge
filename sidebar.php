<?php
/**
 * The sidebar containing the main widget area
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div class="col-md-4 widget-area custom-sidebar" id="secondary" role="complementary">
	<?php
	// Because we need put a full width advertisement on middle of the home page :(
	// Right top sidebar
	if( is_active_sidebar( 'right-top-sidebar' ) ) {
		dynamic_sidebar( 'right-top-sidebar' );
	}

	// Right bottom sidebar
	if( is_active_sidebar( 'right-bottom-sidebar' ) ) {
		dynamic_sidebar( 'right-bottom-sidebar' );
	}
	?>
</div><!-- #secondary -->
