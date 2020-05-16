<?php
/**
 * Custom hooks
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'everstrap_site_info' ) ) {
	/**
	 * Add site info hook to WP hook library.
	 */
	function everstrap_site_info() {
		do_action( 'everstrap_site_info' );
	}
}

if ( ! function_exists( 'everstrap_add_site_info' ) ) {
	add_action( 'everstrap_site_info', 'everstrap_add_site_info' );

	/**
	 * Add site info content.
	 */
	function everstrap_add_site_info() {
		$the_theme   = wp_get_theme();
		$curent_year = date( 'Y' );

		$site_info = sprintf(
			'<p class="site-info-text">%1$s<span class="sep"> | </span>%2$s</p>',
			sprintf(
				esc_html__( '© %1$s Magazine ' . $curent_year . ', All rights reserved.', 'everstrap' ),
				'<a href="' . esc_url( __( site_url( '/' ), 'everstrap' ) ) . '">' . $the_theme->get( 'Name' ) . '</a>'
			),
			sprintf(
				esc_html__( 'Website by %1$s .', 'everstrap' ),
				'<a href="' . esc_url( __( 'https://webpublisherpro.com/', 'everstrap' ) ) . '">Web Publisher PRO</a>'
			)
		);

		echo apply_filters( 'everstrap_site_info_content', $site_info );
	}
}


/**
* Everstrap Load more ajax handler
*/
function everstrap_loadmore_ajax_handler(){

 	// Term id of load more post
 	$term_id = isset( $_POST['term_id'] ) ? intval( $_POST['term_id'] ) : '';
 	$post_type = isset( $_POST['post_type'] ) ? $_POST['post_type'] : '';


 	$post_ids = $_POST['post_ids'];
 	// Get all post id to be excludeed
 	$post_ids_neeed = [];
 	foreach ( $post_ids as $post_id ) {
 		$post_ids_neeed[] = intval( $post_id );
 	}

 	// How more post to load on button click
 	$no_of_load_more_post = everstrap_get_field( 'no_of_load_more_post', 'option' );
 	if( $no_of_load_more_post ) {
 		$no_of_load_more_post =  $no_of_load_more_post;
 	} else {
 		$no_of_load_more_post = '';
 	}

 	$bootstrap_class = isset( $_POST[ 'bootstrap_class' ] ) ? sanitize_text_field( $_POST[ 'bootstrap_class' ] ) : '';
 	$post_class = isset( $_POST[ 'post_class'] ) ? sanitize_text_field( $_POST[ 'post_class' ] ) : '';
 	$thumb_size = isset( $_POST[ 'thumb_size'] ) ? sanitize_text_field( $_POST[ 'thumb_size' ] ) : '';
 	$show_excerpt = isset( $_POST[ 'show_excerpt'] ) ? $_POST[ 'show_excerpt'] : false;
 	$show_author = isset( $_POST[ 'show_author'] ) ? $_POST[ 'show_author'] : false;
 	$show_thumb_caption = isset( $_POST[ 'show_thumb_caption'] ) ? $_POST[ 'show_thumb_caption'] : false;

 	$args = [
 		'post_type' => $post_type,
        'numberposts' => $no_of_load_more_post,
        'category' => $term_id,
        'post_class' => $post_class,
        'first_full_width' => false,
        'thumb_size' => $thumb_size,
        'bootstrap_class' => $bootstrap_class,
        'show_thumb_caption' => $show_thumb_caption,
        'read_more' => false,
        'exclude' => $post_ids_neeed,
        'show_excerpt' => $show_excerpt,
        'show_author' => $show_author,
    ];

    if( $term_id ) {
    	$args['category'] = $term_id;
 	} else {
		$args['post_type'] = $post_type;
 	}

	echo evertstrap_conditional_posts( $args );

	wp_die();
}

add_action('wp_ajax_loadmore', 'everstrap_loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmore', 'everstrap_loadmore_ajax_handler');
