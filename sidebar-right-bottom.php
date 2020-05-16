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
	// Right bottom sidebar
	for ( $i = 1; $i <= 5; $i++ ) {
		if( is_active_sidebar( 'ad-bottom-sidebar-'.$i ) ) {
			dynamic_sidebar( 'ad-bottom-sidebar-'.$i );
		}
	}
	?>
</div><!-- #secondary -->
