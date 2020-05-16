<?php
/**
 * The sidebar containing the mome page right top widget area
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
	if( is_active_sidebar( 'home-right-top-sidebar' ) ) {
		dynamic_sidebar( 'home-right-top-sidebar' );
	}
	?>
</div><!-- #secondary -->
