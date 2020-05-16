<h2 class="directory-single-title">
	<?php echo wdp_get_title( $post ); ?>
</h2>
<?php $subtitle = get_post_meta( $post->ID, 'editor-notes', true );
if ( $subtitle ) {
	echo sprintf( '<p class="directory-subtitle">%s</p>', esc_html( wp_trim_words( $subtitle ) ) );
}

if ( $post->post_type === 'top_doctor' ) {
	$term = wp_get_post_terms( $post->ID, 'doctor_speciality' );
	if ( ! empty( $term ) ) { ?>
        <h4 class="directory-single-category">
			<?php
			$term = $term[ 0 ];
			echo $term->name;
			?>
        </h4>
	<?php }
} ?>