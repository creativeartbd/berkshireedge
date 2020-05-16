<?php
/**
 * The sidebar containing event sidebar widget
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<div class="widget-area" id="secondary" role="complementary">
    <?php
    // Because we need put a full width advertisement on middle of the home page :(
    // Right top sidebar
    if( is_active_sidebar( 'event-sidebar' ) ) {
        dynamic_sidebar( 'event-sidebar' );
    }
    ?>
</div><!-- #secondary -->
