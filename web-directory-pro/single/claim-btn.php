<?php
$claim_page_id = wdp_get_settings( 'claim_submit_page', '0', 'wdp_pages' );
if ( ! empty( $claim_page_id ) ) {
	echo '<a href="' . add_query_arg( array( 'claim' => get_permalink() ), get_permalink( $claim_page_id ) ) . '" class="directory-btn">CLAIM YOUR LISTING</a>';
}

$print_ad = function_exists( 'get_field' ) ? get_field( 'print_ad' ) : '';

if ( ! empty( $print_ad ) ) {
	printf( '<a href="%s" class="directory-btn">VIEW PRINT AD</a>', $print_ad );
}
?>