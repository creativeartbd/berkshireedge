<?php

function moffly_listings( $attrs ) {
    global $listing_type;
    global $listing_query;
    global $sponsored_posts;
    global $listing_taxonomies;

    $attrs = wp_parse_args( $attrs, [ 'listing_type' => '', 'show_filter' => 'true' ] );
    if ( empty( $attrs['listing_type'] ) || ! post_type_exists( sanitize_key( $attrs['listing_type'] ) ) ) {
        return 'Empty or invalid post type';
    }

    $listing_type = sanitize_key( $attrs['listing_type'] );
    $latitude     = wdp_get_settings( 'latitude', '40.584710', 'wdp_general' );
    $longitude    = wdp_get_settings( 'longitude', '-105.075180', 'wdp_general' );
    if ( ! empty( $_GET['lat'] ) && ! empty( $_GET['lon'] ) ) {
        $latitude  = sanitize_text_field( $_GET['lat'] );
        $longitude = sanitize_text_field( $_GET['lon'] );
    }

    $paged      = get_query_var( 'paged', 1 );
    $query_args = array(
        'post_type'      => $listing_type,
        'posts_per_page' => 17,
        'post_status'    => 'publish',
        'paged'          => $paged,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_parent'    => 0,
        'lat'            => $latitude,
        'lon'            => $longitude,
        'address'        => empty( $_GET['address'] ) ? '' : sanitize_text_field( $_GET['address'] ),
        's'              => empty( $_GET['keyword'] ) ? '' : sanitize_text_field( $_GET['keyword'] ),
        'taxonomy'       => '',
    );

	if ( empty( $_GET['address'] ) ) {
		$query_args['post_parent'] = 0;
	}

    global $wp_taxonomies;
    $taxonomy_filter = array();
    foreach ( $wp_taxonomies as $taxonomy ) {
        if ( ! in_array( $listing_type, $taxonomy->object_type ) ) {
            continue;
        }
        $listing_taxonomies[] = $taxonomy;
        if ( ! array_key_exists( $taxonomy->name, $_GET ) ) {
            continue;
        }
        $taxonomy_filter[] = array(
            'taxonomy' => $taxonomy->name,
            'field'    => 'slug',
            'terms'    => array_map( 'sanitize_key', $_GET[ $taxonomy->name ] ),
        );
    }


    if ( ! empty( $query_args['s'] ) && empty( $taxonomy_filter ) ) {

        $taxonomies = wp_list_pluck( $listing_taxonomies, 'name' );
        $terms      = get_terms( array(
            'taxonomy' => $taxonomies,
            'search'   => $query_args['s']
        ) );

        foreach ( $terms as $term ) {
            $taxonomy_filter[] = array(
                'taxonomy' => $term->taxonomy,
                'field'    => 'slug',
                'terms'    => $term->slug,
            );
        }

    }

    if ( ! empty( $_GET['order_by'] ) && 'default' == $_GET['order_by'] ) {
        $query_args['orderby'] = 'menu_order';
    } elseif ( ! empty( $_GET['order_by'] ) && 'title_desc' == $_GET['order_by'] ) {
        $query_args['orderby'] = 'title';
        $query_args['order']   = 'DESC';
    } elseif ( ! empty( $_GET['order_by'] ) && 'title_asc' == $_GET['order_by'] ) {
        $query_args['orderby'] = 'title';
        $query_args['order']   = 'ASC';
    } elseif ( ! empty( $_GET['order_by'] ) ) {
        $query_args['orderby'] = sanitize_key( $_GET['order_by'] );
    } else {
        $query_args['orderby'] = 'title';
        $query_args['order']   = 'ASC';
    }

	if ( ! empty( $query_args[ 'address' ] ) ) {
		$query_args[ 'meta_query' ] = array(
			array(
				'relation' => 'OR',
				array(
					'key'     => '_street_address',
					'value'   => $query_args[ 'address' ],
					'compare' => 'LIKE',
				),
				array(
					'key'     => '_city',
					'value'   => $query_args[ 'address' ],
					'compare' => 'LIKE',
				),
				array(
					'key'     => '_zip',
					'value'   => $query_args[ 'address' ],
					'compare' => 'LIKE',
				),
			)
		);
	}

    /**
     * if taxonomy filter not empty,
     * if search keyword is empty, then $posts is only the tax_queried post
     * if search keyword is not empty, then merge tax_queried posts with the search posts
     */
    if ( ! empty( $taxonomy_filter ) ) {
        $taxonomy_filter['relation'] = 'AND';
        $query_args['tax_query']     = $taxonomy_filter;
        $query_args['s']             = '';
    }

    // Sponsored Query
    $show_featured = apply_filters( 'wdp_show_featured_listings', true );
    $excludes = [];

    if ( $show_featured ) {
        $featured_query_args                   = $query_args;
        $featured_query_args['posts_per_page'] = '4';
        $featured_query_args['meta_query'][]   = array(
            'key'     => '_sponsored_until',
            'type'    => 'DATE',
            'compare' => '>=',
            'value'   => date( 'Y-m-d' ),
        );
        $featured_query_args['orderby']        = 'rand';
        $sponsored_posts_query                 = new Query_Listing( apply_filters( 'wdp_featured_listing_query_args', $featured_query_args, $listing_type ) );

        $sponsored_posts = $sponsored_posts_query->get_posts();
        $sponsored_posts = array_map( 'wdp_add_pinned', $sponsored_posts );


        if ( ! empty( $sponsored_posts ) ) {
            $excludes = wp_list_pluck( $sponsored_posts, 'ID' );
        }
    }

    $query_args['post__not_in']   = $excludes;

    $listing_query = new Query_Listing( apply_filters( 'wdp_listing_query', $query_args, $listing_type ) );
    $posts         = $listing_query->get_posts();

    if ( empty( $posts ) && ! empty( $sponsored_posts ) ) {
        $posts = $sponsored_posts;
        $sponsored_posts = [];
    }

    $posts = apply_filters( 'wdp_listing_posts', $posts, $listing_type, $query_args );

    ob_start();

    ?>
    <?php
    do_action( 'wdp_listing_filter_before', $listing_type );
    if ( 'true' == $attrs[ 'show_filter' ] ) {
        wdp_get_template( 'listing-filter.php', [ 'listing_type' => $listing_type ] );
    }
    do_action( 'wdp_listing_filter_after', $listing_type );
    ?>

        <div class="wrapper-directory-content">
            <div class="container">
                <div class="col-lg-8 col-md-12 col-sm-12 bk-directory-left">
                    <?php if ( $posts ){ ?>

                        <?php

                        wdp_get_template( 'list-result.php', array( 'listing_query' => $listing_query ) );
                        wdp_get_template( 'listing-start.php', [ 'listing_query' => $listing_query ] );

                        do_action( 'wdp_listing_loop_before_start', $listing_query );

                        global $counter;
                        $counter = 1;

                        //the loop
                        foreach ( $posts as $post ) {
                            setup_postdata( $post );

                            do_action( 'wdp_listing_loop_start', $post, $counter );

                            setup_postdata( $post );

                            wdp_get_template( 'listing-loop.php', [ 'post' => $post ] );

                            $counter += 1;

                            do_action( 'wdp_listing_loop_end', $post, $counter );
                        }

                        //end of the loop
                        do_action( 'wdp_listing_loop_before_end', $listing_query );

                        wdp_get_template( 'listing-end.php', [ 'listing_query' => $listing_query ] );

                        do_action( 'wdp_listing_loop_after_end', $listing_query ); ?>

                        <div class="wdp-listing-footer">
                            <?php wdp_get_template( 'list-footer.php', array( 'listing_query' => $listing_query ) ); ?>
                        </div>
                    <?php }else{ ?><?php wdp_get_template( 'no-result.php' ); } ?>
                </div>

                <?php get_sidebar('wedding'); ?>
            </div>
        </div>
    <?php
    wp_reset_query();
    $output = ob_get_contents();
    ob_get_clean();

    return apply_filters( 'wdp_listing_output', $output );
}



function dfw_overwrite_shortcode() {
    remove_shortcode( 'wdp_listing' );
    add_shortcode( 'wdp_listing', 'moffly_listings' );
}

add_action( 'wp_loaded', 'dfw_overwrite_shortcode' );

function moffly_add_contact_name( $post )
{
    echo web_directory_pro()->elements->input( array(
        'type'  => 'text',
        'label' => 'Contact Name',
        'name'  => '_contactname',
        'value' => wdp_get_post_meta( $post->ID, '_contactname' ),
    ) );

}

add_action( 'wdp_after_listing_metabox_content', 'moffly_add_contact_name' );

function moffly_save_additional_doctors_field( $post_id, $posted  ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        return;
    }

    if ( 'doctor' == get_post_type( $post_id ) ) {
        $contactname        = ! empty( $posted[ '_contactname' ] ) ? sanitize_text_field( $posted[ '_contactname' ] ) : '';

        update_post_meta( $post_id, '_contactname', $contactname );
        return;
    }
}
add_action( 'wdp_update_listing_details_meta', 'moffly_save_additional_doctors_field', 11, 2 );

//filter post template
function moffly_filter_template( $template ) {

	if ( function_exists( 'wdp_get_listing_post_types' ) ) {
		if ( is_single() && in_array( get_post_type(), wdp_get_listing_post_types() ) ) {
			$template = get_template_directory() . '/single-directory.php';
		}
	}

	return $template;
}

add_filter( 'template_include', 'moffly_filter_template' );



/**
 * Check whether the post is top listing or not
 *
 * @param $post
 *
 * @return bool
 */

function moffly_is_top_listing( $post ) {

	$taxonomies = array(
		'top_doctor'  => 'doctor_category',
	);

	$taxonomies = apply_filters( 'wdp_top_listing_taxonomies', $taxonomies );
	$year       = apply_filters( 'wdp_top_listing_year_to_check', date( 'Y' ), $post );

	if ( array_key_exists( $post->post_type, $taxonomies ) && has_term( sprintf( '%ss-%s', str_replace( '_', '-', $post->post_type ), $year ), $taxonomies[ $post->post_type ], $post->ID ) ) {
		return true;
	}

	return false;
}

function moffly_pagination_rewrite() {
	add_rewrite_rule(
		'([a-z\-]+)/page/([0-9]+)/?$',
		'index.php?pagename=$matches[1]&paged=$matches[2]',
		'top'
	);
}


add_action('init', 'moffly_pagination_rewrite');

function everstrap_ad_after_loop( $post, $counter ) {
	if ( $counter == 8 || $counter == 18 ) {
		?>
        <broadstreet-zone zone-id="78626"></broadstreet-zone>
		<?php
	}
}

add_action( 'wdp_listing_loop_end', 'everstrap_ad_after_loop', 10, 2 );

?>
