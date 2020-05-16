<?php
$taxonomies = apply_filters( 'wdp_single_list_output_taxonomies', get_post_taxonomies( $post ), $post );

foreach ( $taxonomies as $taxonomy ) {

	if ( $taxonomy === 'yst_prominent_words' ) {
		continue;
	}

	$terms = wp_get_post_terms( $post->ID, $taxonomy, apply_filters( 'wdp_single_page_taxonomy_terms_arg', array(
		'hide_empty' => true
	), $taxonomy ) );

	if ( empty( $terms ) ) {
		continue;
	}

	$taxonomy = get_taxonomy( $taxonomy );
	?>
    <div class="directory-cat-menu">
        <ul>
        <?php foreach ( $terms as $term ): ?>
            <?php $link = add_query_arg( array( "$term->taxonomy[]" => $term->slug ), wdp_get_listing_page_url( $post->post_type ) ); ?>
            <li><a href="<?php echo esc_url( $link ); ?>"><?php echo $term->name; ?></a></li>
        <?php endforeach; ?>
        </ul>
    </div>

	<?php
}
?>




