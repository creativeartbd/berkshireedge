<?php
/**
 * The sidebar containing real estate sidebar widget
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
	if( is_active_sidebar( 'real-estate-sidebar' ) ) {
		dynamic_sidebar( 'real-estate-sidebar' );
	}
	?>
</div><!-- #secondary -->
