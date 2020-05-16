<?php
/**
 * This template is for real estate full post
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Get 1 real-estate 'post type' post which cateogry is equal to 'property of the week'

// get the 'property of the week' category ID
$potw = get_term_by( 'slug', 'property-of-the-week', 're-category' );
$term_id = $potw->term_id;

$args = array(
	'posts_per_page' => 2,
	'post_type'      => 'real-estate',
	'orderby'        => 'publish_date',
	'tax_query'      => array(
		array(
			'taxonomy' => 're-category',
			'field'    => 'slug',
			'terms'    => 'property-of-the-week',
		)
	),
	'meta_query'     => array(
		array(
			'key'     => 'is_sponsored_post',
			'value'   => '1',
			'compare' => '='
		)
	)
);

$posts = get_posts( $args );

if( $posts ) {
	$i = 0;
	foreach ( $posts as $post ) {
		setup_postdata( $post );

		$GLOBALS['re_first_post'][] = get_the_ID();

		if ( $i == 1 ) {
			get_template_part( 'loop-templates/content', 'real-estate-thumb-post' );
			break;
		}

        get_template_part( 'loop-templates/content', 'real-estate-archive-title' );
        if( is_front_page() ) {
            get_template_part( 'loop-templates/content', 'home-real-estate-full-post' );
        } else {
            get_template_part( 'loop-templates/content', 'real-estate-full-post' );    
        }

		if( is_active_sidebar( 'real-estate-archive-ad' ) ) {
			dynamic_sidebar( 'real-estate-archive-ad' );
		}
        $i++;
		
	}
   
	wp_reset_postdata();
}