<?php
/**
 * This template is for real estate short post
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Get 1 real-estate 'post type' post which cateogry is equal to 'property of the week'

// get the 'property of the week' category ID
$potw = get_term_by( 'slug', 'property-of-the-week', 're-category' );
$term_id = $potw->term_id;

$post_to_exclude = ! empty( $GLOBALS['re_first_post'] ) ? $GLOBALS['re_first_post'] : [];

$args = array(
    'post_type' => 'real-estate',
    'posts_per_page' => 4,
    'exclude' => $post_to_exclude,
    'tax_query' => array(
        array(
            'taxonomy' => 're-category',
            'field' => 'slug',
            'terms' => 'property-of-the-week',
            'operator' => 'NOT IN',
        )
    )  
);

$posts = get_posts( $args );


if( $posts ) {    
//	echo '<div class="more-in-real-estate">';
//        echo '<h2>';
//            _e( 'More In Real Estate');
//        echo '</h2>';
//    echo '</div>';

    $GLOBALS['exclude_to_load_more'] = []; 
    array_push( $GLOBALS['exclude_to_load_more'], $post_to_exclude );

	foreach ( $posts as $post ) {
		setup_postdata( $post );
        array_push( $GLOBALS['exclude_to_load_more'], get_the_ID() );
		get_template_part( 'loop-templates/content', 'real-estate-thumb-post' );
	}
	wp_reset_postdata();
}
unset( $GLOBALS['re_first_post'] );