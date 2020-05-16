<?php
/**
 * This template is for home post
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// We are getting $what_type_of_post variable from the home.php file to conditionaly load the posts
if ( 'multiple-categories' == $what_type_of_post ) {

	// Set post args
	$all_categories = get_categories();
	$category_needed = [];
	$counter = 1; // Because we want to show latest POST of 5 categories

	foreach ( $all_categories as $key => $category ) {
		$category_needed[] = $category->term_id;
		$counter++;
		if( 6 == $counter ) {
			break;
		}
	}

	$category_needed = implode( ', ', $category_needed );
	$post_args = [
		'post_type' => 'post',
		'numberposts' => 5,
		'category' => [ $category_needed ],
	];
}

// Args is true
if( $post_args ) {
	// get the post using the args
	$posts = get_posts( $post_args );
	// if posts found
	if( $posts ) {
		$category_counter = 1;
		echo '<div class="row p-r-70">';
			foreach ( $posts as $post) {
				setup_postdata( $post );
				$GLOBALS['category_counter'] = $category_counter;
				get_template_part( 'loop-templates/content', 'home-latest-category' );
				$category_counter++;
			}
		echo '</div>';
		wp_reset_postdata();
	}
}

