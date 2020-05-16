<?php
global $listing_type;
$paged     = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$limit     = $listing_query->get( 'posts_per_page' );
$offset    = ( $paged - 1 ) * $limit;
$post_from = $offset + 1;
$post_to   = '';
$total     = $listing_query->found_posts;
if ( $total > $limit ) {
	$post_to = $offset + $limit;
	if ( $post_to > $total ) {
		$post_to = $total;
	}
} else {
	$post_to = $total;
}
$post_type_object = get_post_type_object( $listing_type );
?>
<div class="bk-directory-head">
	<div class="bk-directory-result">
			<span><?php echo apply_filters( 'wdp_result_text', sprintf( 'Displaying: <span class="result-for">%s</span>', $post_type_object->label ) ); ?></span>
			<!-- <div class="clear-filter-mobile-device">
				<a href="#" class="search-clear-button clear-filters" style="display: inline-block;"><i class="fa fa-close"></i>Clear Filters</a>
			</div> -->
	</div>

	<div class="bk-directory-counter">
        <span><?php echo sprintf( 'Showing %s - %s of %s', $post_from, $post_to, $total ); ?></span>
	</div>
</div>
