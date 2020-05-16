<?php
/**
 * The sidebar containing the mome page right bottom widget area
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<div class="col-md-4 widget-area custom-sidebar home-bottom-sidebar" id="secondary" role="complementary">
	<?php
	// Because we need put a full width advertisement on middle of the home page :(
	// Right top sidebar
	if( is_active_sidebar( 'home-right-bottom-sidebar' ) ) {
		dynamic_sidebar( 'home-right-bottom-sidebar' );
	}
	?>
</div><!-- #secondary -->
