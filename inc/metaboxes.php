<?php
/**
 * Saving Metabox Data
 *
 * @param $post_id
 */
function everstrap_save_postmeta( $post_id, $post, $is_update ) {

	if ( ! $is_update ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}

	if ( 'post' !== get_post_type( $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, 'featured_post', empty( $_POST['featured_post'] ) ? '0' : '1' );
}

add_action( 'save_post', 'everstrap_save_postmeta', 10, 3 );


/**
 * Register Metabox
 */
function everstrap_register_metabox() {
	add_meta_box( 'post-controls', 'Post Controls', 'everstrap_post_controls_metabox', 'post', 'side', 'high' );
}

add_action( 'admin_init', 'everstrap_register_metabox' );


/*
 * Post Controls Metabox
 */
function everstrap_post_controls_metabox( $post ) {

	?>
	<div class="metabox-section">
		<p>
			<input type="checkbox" name="featured_post" class="post-format" id="featured_post" value="1" <?php checked( get_post_meta( $post->ID, 'featured_post', true ), '1' ); ?>>
			<label for="featured_post" class="post-format-icon"><b><?php echo esc_html__( 'Featured Post', 'everstrap' ) ?></b></label>
		</p>
	</div>
	<?php
}
