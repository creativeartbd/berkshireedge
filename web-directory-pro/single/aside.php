<?php

$multi_location_disabled = wdp_get_settings( 'disable_multi_location' );

if ( $multi_location_disabled != 'on' ) {
	$addresses = wdp_get_addresses($post->ID);
	if ( ! empty( $addresses ) ) {
	?>
    <h2>LOCATIONS</h2>
    <ul>
		<?php foreach ( $addresses as $id => $address ) {
			$child_id = ! empty( $_REQUEST['child_id'] ) ? intval( $_REQUEST['child_id'] ) : '';
			echo sprintf( '<li class="location %s"><a href="%s">%s</a></li>', $child_id == $id ? 'directory-active' : '', add_query_arg( array( 'child_id' => $id ), get_permalink() ), $address );
		} ?>
    </ul>
<?php } } ?>
<div class="directory-right-down-doc">
	<?php if ( ! wdp_is_sponsored( $post->ID ) ) { ?>
		<?php wdp_get_template( 'single/claim-btn.php', [ 'post' => $post ] ); ?>
	<?php } ?>
	<?php if ( wdp_is_sponsored( $post->ID ) ) {
		wdp_get_template( 'single/timing.php', [ 'post' => $post ] );
	} ?>
</div>

