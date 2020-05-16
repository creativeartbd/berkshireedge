<?php
/**
 * Theme functions and definitions
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


add_action( 'template_redirect', 'everstrap_do_migration' );
function everstrap_do_migration() {

	// checl specific post type 
	if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'check_one_post_type' ) {
		 $types = get_posts(['post_type' => 'real-estate']);
		 echo '<pre>';
		 	print_r( $types );
		 echo '</pre>';
	}



	// checl all post type 
	if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'check_post_type' ) {
		 $types = get_post_types( [], 'objects' );
		 echo '<pre>';
		 	print_r( $types );
		 echo '</pre>';
	}


	if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'acf_to_featured_image' ) {

		// Migration to convert acf image to wordpress featured image.
		$get_posts = get_posts(array(
		    'fields'          => 'ids', // Only get post IDs
		    'posts_per_page'  => -1
		));
		
		foreach ( $get_posts as $post_id ) {
			$acf_image_id = get_field( 'photo', $post_id );	
			if( $acf_image_id ) {
				if( add_post_meta( $post_id, '_thumbnail_id', $acf_image_id) ) {
					echo 'Done' . $post_id;
					echo '<br/>';
				}	
			}			
		}

		// Set caption to featued image ( Dont' do this )
		// foreach ( $get_posts as $post_id ) {
		//  	$featured_image_id = get_post_thumbnail_id( $post_id );
		//  	if( $featured_image_id ) {
		//  		$acf_featured_image_title = get_field( 'caption', $post_id );
		//  		if( $acf_featured_image_title) {
		//  			$new_caption_text = sanitize_text_field( $acf_featured_image_title );		
		//  			if( wp_update_post( 'post_excerpt', $new_caption_text ) ) {
		//  				echo 'Set featured image done';
		//  				echo '<br/>';
		//  			}	
		//  		}	
		//  	}			 
		// }
	    
    }  
}