<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package everstrap
 */

//phpcs:ignore PHPCompatibility.Syntax.NewShortArray.Found

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_filter( 'body_class', 'everstrap_body_classes' );

if ( ! function_exists( 'everstrap_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	function everstrap_body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}
}

// Removes tag class from the body_class array to avoid Bootstrap markup styling issues.
add_filter( 'body_class', 'everstrap_adjust_body_class' );

if ( ! function_exists( 'everstrap_adjust_body_class' ) ) {
	/**
	 * Setup body classes.
	 *
	 * @param string $classes CSS classes.
	 *
	 * @return mixed
	 */
	function everstrap_adjust_body_class( $classes ) {

		foreach ( $classes as $key => $value ) {
			if ( 'tag' === $value ) {
				unset( $classes[ $key ] );
			}
		}

		return $classes;

	}
}

// Filter custom logo with correct classes.
add_filter( 'get_custom_logo', 'everstrap_change_logo_class' );

if ( ! function_exists( 'everstrap_change_logo_class' ) ) {
	/**
	 * Replaces logo CSS class.
	 *
	 * @param string $html Markup.
	 *
	 * @return mixed
	 */
	function everstrap_change_logo_class( $html ) {

		$html = str_replace( 'class="custom-logo"', 'class="img-fluid"', $html );
		$html = str_replace( 'class="custom-logo-link"', 'class="navbar-brand custom-logo-link"', $html );
		$html = str_replace( 'alt=""', 'title="Home" alt="logo"', $html );

		return $html;
	}
}

/**
 * Display navigation to next/previous post when applicable.
 */

if ( ! function_exists( 'everstrap_post_nav' ) ) {
	/**
	 * Prints post navigation
	 */
	function everstrap_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="container navigation post-navigation">
			<h2 class="sr-only"><?php esc_html_e( 'Post navigation', 'everstrap' ); ?></h2>
			<div class="row nav-links justify-content-between">
				<?php
				if ( get_previous_post_link() ) {
					previous_post_link( '<span class="nav-previous">%link</span>', _x( '<i class="fa fa-angle-left"></i>&nbsp;%title', 'Previous post link', 'everstrap' ) );
				}
				if ( get_next_post_link() ) {
					next_post_link( '<span class="nav-next">%link</span>', _x( '%title&nbsp;<i class="fa fa-angle-right"></i>', 'Next post link', 'everstrap' ) );
				}
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}

if ( ! function_exists( 'everstrap_pingback' ) ) {
	/**
	 * Add a pingback url auto-discovery header for single posts of any post type.
	 */
	function everstrap_pingback() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">' . "\n";
		}
	}
}
add_action( 'wp_head', 'everstrap_pingback' );

if ( ! function_exists( 'everstrap_mobile_web_app_meta' ) ) {
	/**
	 * Add mobile-web-app meta.
	 */
	function everstrap_mobile_web_app_meta() {
		echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
		echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
		echo '<meta name="apple-mobile-web-app-title" content="' . esc_attr( get_bloginfo( 'name' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'everstrap_mobile_web_app_meta' );


/**
 * Primary Taxonomy Function
 *
 * @param bool $post_id
 * @param string $taxonomy
 *
 * @return array|bool|null|WP_Error|WP_Term
 */
if ( ! function_exists( 'everstrap_get_primary_term' ) ) {
	function everstrap_get_primary_term( $post_id = false, $taxonomy = 'category' ) {
		if ( ! $taxonomy ) {
			return false;
		}

		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		if ( class_exists( 'WPSEO_Primary_Term' ) ) {
			$wpseo_primary_term = new WPSEO_Primary_Term( $taxonomy, $post_id );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			if ( $wpseo_primary_term ) {
				return get_term( $wpseo_primary_term );
			}
		}

		$terms = get_the_terms( $post_id, $taxonomy );

		if ( ! $terms || is_wp_error( $terms ) ) {
			return false;
		}

		return $terms[0];
	}
}


/**
 * Social Share Function
 *
 * @param $post_id
 * @param $type
 *
 * @return string
 */
if ( ! function_exists( 'everstrap_get_share_link' ) ) {
	function everstrap_get_share_link( $post_id, $type ) {
		$url = '';
		switch ( $type ) {
			case 'facebook':
				$url = add_query_arg(
					[
						'u'       => get_the_permalink( $post_id ),
						'[title]' => apply_filters( 'everstrap_share_fb_title', get_the_title( $post_id ) ),
					],
					'http://www.facebook.com/sharer.php'
				);
				break;

			case 'twitter':
				$url = add_query_arg(
					[
						'url'  => get_the_permalink( $post_id ),
						'text' => apply_filters( 'everstrap_share_twitter_text', get_the_title( $post_id ) ),
						'via'  => '',
					],
					'http://twitter.com/share'
				);
				break;

			case 'linkedin':
				$url = add_query_arg(
					[
						'url'     => get_the_permalink( $post_id ),
						'title'   => apply_filters( 'everstrap_share_twitter_text', wp_strip_all_tags( get_the_title( $post_id ) ) ),
						'summary' => get_post_field( 'the_excerpt', $post_id ),
					],
					'https://www.linkedin.com/shareArticle?mini=true'
				);
				break;

			case 'envelope':
				$url = add_query_arg(
					[
						'subject' => 'I thought you might be interested in this article',
						'body'    => sprintf( 'Check out this site %s ', get_the_permalink( $post_id ) ),
					],
					'mailto:'
				);
				break;
		}

		return $url;
	}
}

/*
 * Custom function for ACF
 */

if( !function_exists( 'everstrap_get_field' ) ) {
	function everstrap_get_field( $field_name, $id = null )
	{

		if (class_exists('acf')) {

			if (empty($field_name)) {
				return;
			}

			$data = get_field($field_name);

			if ( $id ) {
				$data = get_field( $field_name, $id );
			}

			if ( $data ) {
				//return do_shortcode($data);
				return $data;
			} else {
				return false;
			}
		}
	}
}

/**
 * Everstrap site Logo
 */

if( !function_exists( 'everstrap_site_logo' ) ) {
	function everstrap_site_logo( $acf_field_name ) {

		if( ! $acf_field_name )
			return;

		$get_logo = everstrap_get_field( $acf_field_name, 'option' );
		$site_url = site_url( '/' );

		if( $get_logo ) {

			if( 'site_header_sticky_logo' == $acf_field_name ) {
				$registered_img_size = 'site-footer-logo';
			} elseif( 'site_header_logo' == $acf_field_name ) {
				$registered_img_size = str_replace( '_', '-', $acf_field_name );
			}

			$logo_size = $get_logo['sizes'][$registered_img_size];

			if( !$logo_size )
				return;

			$heading_open = '';
				$title_or_img = "<img src='{$logo_size}'>";
			$heading_close = '';

		} else {

			$heading_open = '<h1>';
				$title_or_img = get_bloginfo( 'name' );
			$heading_close = '</h1>';

		}


		echo $heading_open;
			echo "<a href='{$site_url}'>";
				echo $title_or_img;
			echo '</a>';
			if( get_bloginfo( 'description') ) {
				echo '<span>';
					bloginfo( 'description' );
				echo '</span>';
			}
		echo $heading_close;

	}
}


/**
 * Everstrap fotter logo
 */
if( !function_exists( 'everstrap_footer_logo' ) ) {
	function everstrap_footer_logo() {
		// Site small logo
		$site_footer_logo = everstrap_get_field('site_footer_logo', 'option');
		if( $site_footer_logo ) {
			$site_footer_logo = $site_footer_logo['sizes']['site-footer-logo'];

			if( get_bloginfo( 'description') ) {
				$description = '';
				$description .= '<span>';
				$description .= get_bloginfo( 'description' );
				$description .= '</span>';
			}

			if( $site_footer_logo ) {
				echo "<img src='{$site_footer_logo}' />";
				echo $description;
			} else {
				echo '<h1>';
					bloginfo( 'name' );
					echo $description;
				echo '</h1>';
			}
		}
	}
}


/**
 * Everstrap get events list
 */

if( !function_exists( 'everstrap_get_event_list' ) ) {
	function everstrap_get_event_list( $args = array(), $count = false ) {

		global $wpdb;

		$post_type = 'pro_event';

		$args = wp_parse_args( $args, array(
			'number'     => get_option( 'posts_per_page' ),
			'offset'     => 0,
			'search'     => '',
			'date'       => date( 'Y-m-d', current_time( 'timestamp' ) ),
			'start_date' => '',
			'end_date'   => '',
			'location'   => '',
			'categories' => '',
			'orderby'    => 'events.start_date',
			'order'      => 'ASC',
		) );

		if ( empty( $args['start_date'] ) && empty( $args['date'] ) ) {
			$args['date'] = date( 'Y-m-d', current_time( 'timestamp' ) );
		}

		if ( $args['orderby'] == 'id' ) {
			$args['orderby'] = 'p.ID';
		}

		if ( $args['orderby'] == 'title' ) {
			$args['orderby'] = 'p.post_title';
		}

		if ( $args['number'] < 1 ) {
			$args['number'] = 9999999;
		}

		$where = ' WHERE 1=1 ';
		$join  = "LEFT JOIN {$wpdb->prefix}ecp_events events on events.post_id=p.ID ";

		// Specific id
		if ( ! empty( $args['id'] ) ) {

			if ( is_array( $args['id'] ) ) {
				$ids = implode( ',', array_map( 'intval', $args['id'] ) );
			} else {
				$ids = intval( $args['id'] );
			}

			$where .= " AND p.ID IN( {$ids} ) ";
		}

		// exclude id
		if ( ! empty( $args['not_in'] ) ) {

			if ( is_array( $args['not_in'] ) ) {
				$ids = implode( ',', array_map( 'intval', $args['not_in'] ) );
			} else {
				$ids = intval( $args['not_in'] );
			}

			$where .= " AND p.ID NOT IN( {$ids} ) ";
		}

		if ( ! empty( $args['search'] ) ) {
			$where .= " AND ( p.post_title LIKE '%%" . esc_sql( $args['search'] ) . "%%' OR p.post_content LIKE '%%" . esc_sql( $args['search'] ) . "%%' OR ms.meta_value LIKE '%%" . esc_sql( $args['search'] ) . "%%')";
		}

		//Default list query (Select all events, which enddate is >= currentdate)
		if ( ! empty( $args['date'] ) ) {
			$where .= " AND date(events.start_date) >= date('{$args['date']}') ";
		}

		if ( ! empty( $args['start_date'] ) && ! empty( $args['end_date'] ) ) {
			//$where .= " AND date(events.start_date) >= date('{$args['start_date']}') AND  date(events.start_date) <= date('{$args['end_date']}') ";
		} else {

			if ( ! empty( $args['start_date'] ) ) {
				//$where .= " AND date(events.start_date) = date('{$args['start_date']}') ";
			}

			if ( ! empty( $args['end_date'] ) ) {
				//$where .= " AND date(events.start_date) <= date('{$args['end_date']}') ";
			}

		}

		if ( ! empty( $args['categories'] ) ) {
			if ( is_array( $args['categories'] ) ) {
				$categories = implode( ',', array_map( 'intval', $args['categories'] ) );
			} else {
				$categories = intval( $args['categories'] );
			}

			$join  .= " INNER JOIN $wpdb->term_relationships tr on tr.object_id=p.ID";
			$where .= " AND tr.term_taxonomy_id IN ('$categories') ";
		}

		if ( ! empty( $args['featured'] ) ) {
			$join .= " LEFT JOIN $wpdb->postmeta featured ON featured.post_id = p.ID ";
		}

		$join .= " LEFT JOIN $wpdb->postmeta m ON m.post_id = p.ID ";
		$join .= " LEFT JOIN $wpdb->postmeta ms ON ms.post_id = p.ID ";
		$join = apply_filters( 'ecp_sql_join', $join, $args );

		$meta_key = apply_filters( 'ecp_select_meta_key', 'startdate' );
		$where    .= " AND m.meta_key = '$meta_key' ";
		$where    .= " AND ms.meta_key IN ('location', 'address', 'zip') ";

		$where .= " AND p.post_status = 'publish' AND p.post_type = '{$post_type}' ";

		if ( ! empty( $args['featured'] ) ) {
			$where .= " AND featured.meta_key = 'featured' AND featured.meta_value = 'yes' ";
		}

		$where = apply_filters( 'ecp_sql_where', $where, $args );

		$args['orderby'] = esc_sql( $args['orderby'] );
		$args['order']   = esc_sql( $args['order'] );

		//if count
		if ( $count ) {
			$total = $wpdb->get_col( "select p.ID FROM $wpdb->posts p $join $where GROUP BY p.ID " );

			return count( $total );
		}

		$distinct = apply_filters( 'ecp_select_distinct_event', null );
		$group_by = apply_filters( 'ecp_group_by_event', ' GROUP BY p.ID ' );

		$sql = $wpdb->prepare( "SELECT {$distinct} m.meta_value, p.ID, p.post_title, p.post_content, p.post_excerpt, events.start_date, events.end_date, events.start_time, events.end_time FROM $wpdb->posts p $join $where {$group_by} ORDER BY  {$args['orderby']} {$args['order']} , events.start_time ASC LIMIT %d,%d ; ", absint( $args['offset'] ), absint( $args['number'] ) );

		return $wpdb->get_results( $sql );
	}
}

/**
 * Everstrap Posts
 */

if( !function_exists( 'evertstrap_multiple_category_posts' ) ) {
	function evertstrap_multiple_category_posts( $type_of_post = null ) {

		global $post;

		$category_ids_needed = [];

		$selected_categories = everstrap_get_field( 'top_categories_post', 'option');
		if( !empty($selected_categories) ) {

			foreach ( $selected_categories as $key => $category ) {
				if( $category ) {
					$category_ids_needed[] = $category['add_categories'];
				}
			}
		}

		// Prepare the category needed
		$all_categories = get_categories();


		$selected_categories = everstrap_get_field( 'top_categories_post', 'option');

		if( $selected_categories ) {

			foreach ( $selected_categories as $key => $category ) {

				if( $category ) {
					$category_ids_needed[] = $category['add_categories'];
				}
			}

			// Prepare the category needed
			$all_categories = get_categories();

			if( $category_ids_needed ) {
			
				$latest_posts = array();
				$exclude_post_ids = array();

				// Loop to get post using each category id
				$counter = 0;
				foreach ( $category_ids_needed as $cat_id ) {
					$post_args = array(
						'post_type' => 'post',						
						'category' => $cat_id,
						'exclude' => $exclude_post_ids,					
					);

					$latest_post_of_category = get_posts( $post_args );

					if( $latest_post_of_category ) {
						$latest_posts[] = $latest_post_of_category[0];
						$exclude_post_ids[] = $latest_post_of_category[0]->ID;
					}
					if( 4 == $counter ) {
						break;
					}
					$counter++;
				}

				if( $latest_posts ) {
					// Now show the post of each category
					$post_counter =1;
					$output = '';
					$output .= '<div class="row">';
					foreach( $latest_posts as $key => $post ) {
						setup_postdata( $post );
						// Show the HTML part

						$author_post_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
						$post_permalink = get_permalink( get_the_ID() );
						$title = get_the_title();
						$post_category = get_cat_name( $category_ids_needed[$key] );
						$post_category_link = get_category_link( $category_ids_needed[$key] );

						if( 1 == $post_counter ) {
							$heading_tag = 'h1';
							$col = 12;
							$thumb_size =  'full-article';
							$col_6 = '';
							$excerpt = get_the_excerpt();
							$full_post_class = 'full-post';
							$thumb_post_class = '';

						} else {
							$heading_tag = 'h2';
							$col = 6;
							$thumb_size = 'thumb-article';
							$col_6 = 'col-6';
							$excerpt = '';
							$full_post_class = '';
							$thumb_post_class = 'thumb-post';
						}


						$output .= "<div class='{$col_6} col-sm-{$col} col-md-{$col}'>";

						$output .= '<article class="'.$full_post_class. ' '.$thumb_post_class .'">';
							$output .= '<div class="post-thumb">';
								$output .= '<a href="'.$post_permalink.'">';
									$output .= get_the_post_thumbnail( get_the_ID(), $thumb_size );
								$output .= '</a>';
							$output .= '</div>';
							$output .= '<div class="post-meta">';
								$output .= '<span>';
									$output .= '<a href="'. $post_category_link .'">';
										$output .= $post_category;
									$output .= '</a>';
								$output .= '</span>';

								$output .= '<a href="'.$post_permalink.'">';
									$output .= "<{$heading_tag}>" . $title . "</{$heading_tag}>";
								$output .= '</a>';

								$output .= '<p>' . $excerpt . '</p>';
								$output .= '<div class="post-author">';
									$output .= 'by ';
									$output .= '<a href="' . $author_post_url . '">';

										$fname = get_the_author_meta('first_name');
										$lname = get_the_author_meta('last_name');
										$full_name = '';

										if( empty($fname)){
										    $full_name = $lname;
										} elseif( empty( $lname )){
										    $full_name = $fname;
										} else {
										    //both first name and last name are present
										    $full_name = "{$fname} {$lname}";
										}

										//$output .= get_the_author_meta( 'nickname' );
										$output .= $full_name;

									$output .=  '</a>';
								$output .=  '</div>';
							$output .=  '</div>';

						$output .= '</article>';
						$output .= "</div>";
						// End HTML part
						$post_counter++;
					}
					$output .= '</div>';
					wp_reset_postdata();
					// finally output the post
					return $output;
				}
			}
		}

	}
}


/**
 * Everstrap Posts
 */

if( !function_exists( 'evertstrap_conditional_posts' ) ) {
	function evertstrap_conditional_posts( $args = null ) {
		global $post;

		$default = array(
			'post_type' => 'post',
			'numberposts' => 10,
			'bootstrap_class' => 'col-6 col-sm-12 col-md-12',
			'thumb_size'	=> 'thumb',
			'show_excerpt'	=> true,
			'show_author'	=> true,
			'first_full_width' => false,
		);



		$args = wp_parse_args( $args, $default );

		 // echo '<pre>';
		 // 	print_r( $args );
		 // echo '</pre>';

		$recent_posts = get_posts( $args );

		if( $recent_posts ) {

			$output = '';

				$title_text = isset( $args['title_text'] ) ? $args['title_text'] : '';
				$post_class = isset( $args['post_class'] ) ? $args['post_class'] : '';
				$thumb_size = isset( $args['thumb_size'] ) ? $args['thumb_size'] : '';
				$show_excerpt = isset( $args['show_excerpt'] ) ? $args['show_excerpt'] : '';
				$show_author = isset( $args['show_author'] ) ? $args['show_author'] : '';
				$show_thumb_caption = isset( $args['show_thumb_caption'] ) ? $args['show_thumb_caption'] : '';
				$read_more = isset( $args['read_more'] ) ? $args['read_more'] : '';
				$term_id = isset( $args['category'] ) ? $args['category'] : '';
				$class = isset( $args['bootstrap_class'] ) ? $args['bootstrap_class'] : '';
				$first_full_width = isset( $args['first_full_width'] ) ? $args['first_full_width'] : '';
				$show_date = isset( $args['show_date'] ) ? $args['show_date'] : '';
				$post_type = isset( $args['post_type'] ) ? $args['post_type'] : '';


				// For advertisement
				$ad_id = isset( $args['ad_id'] ) ? $args['ad_id'] : '';
				$ad_loop_offset = isset( $args['ad_loop_offset'] ) ? $args['ad_loop_offset'] : ''; // How many loop the ad should offset


				$counter = 1;
				foreach ( $recent_posts as $post ) {
					setup_postdata( $post );
					$post_id = get_the_id();

					if( 'real-estate' == get_post_type() ) {
						
						$post_category = get_the_terms( $post_id, 're-category' );
						

						if( $post_category ) {
							$post_category_link = get_term_link( $post_category[0]->slug, 're-category' );
							$post_category = $post_category[0]->name;
						} else {
							$post_category = $post_category_link = '';
						}

					} else {
						
						$post_category = get_the_category();						
						

						if( $post_category ) {
							$post_category_link =  get_term_link( $post_category[0]->term_id );
							$post_category = $post_category[0]->name;
						} else {
							$post_category = $post_category_link = '';
						}
					}


					$author_post_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
					$post_permalink = get_permalink( get_the_ID() );
					$title = get_the_title();
					$excerpt = get_the_excerpt();

					//$output .= "<div class='{$col_6} col-sm-{$col} col-md-{$col}'>";
					if( 1 == $counter && ! empty( $title_text ) ) {
						$output .= '<div class="col-md-12">';
							$output .= '<div class="main-heading-title">';
								$output .= '<h2>';
									$output .= $title_text;
								$output .= '</h2>';
							$output .= '</div>';
						$output .= '</div>';
					}


					if( 1 == $counter && $first_full_width ) {
						$conditional_bootstrap_class = 'col-md-12';
						$conditional_thumb_size = 'full-article';
						$conditional_article_class = 'full-post';
						$heading_tag = 'h1';
					} else {
						$conditional_bootstrap_class = $class;
						$conditional_thumb_size = $thumb_size;
						$conditional_article_class = $post_class;
						$heading_tag = 'h2';
					}


					$output .= "<div class='{$conditional_bootstrap_class}'>";

						$output .= '<article class="'.$conditional_article_class.'">';
						$is_sponsored_post = everstrap_get_field( 'is_sponsored_post', get_the_ID() );

						if( $is_sponsored_post ) {
							$output .= '<div class="sponsored">sponsored content</div>';
						}

							$output .= '<div class="post-thumb">';
								$output .= '<a href="' . $post_permalink . '">';
									$output .= get_the_post_thumbnail(get_the_ID(), $conditional_thumb_size);
								$output .= '</a>';
								if( $show_thumb_caption ) {
									if( get_the_post_thumbnail_caption() ) {
										$output .= '<div class="thumb-caption">';
											$output .= get_the_post_thumbnail_caption();
										$output .= '</div>';
									}
								}
							$output .= '</div>';

							$output .= '<div class="post-meta">';
								$output .= '<span>';
									$output .= '<a href="' . $post_category_link . '">';
										$output .= $post_category;
									$output .= '</a>';
								$output .= '</span>';

								$output .= '<a href="' . $post_permalink . '">';
									$output .= "<{$heading_tag}>" . $title . "</{$heading_tag}>";
								$output .= '</a>';


								if( $show_excerpt && !empty( $show_excerpt ) ) {
									$output .= '<p>' . $excerpt . '</p>';
								}

								if( $show_author && !empty( $show_author ) ) {
									$output .= '<div class="post-author">';
										$output .= '<a href="' . $author_post_url . '">';

										$fname = get_the_author_meta('first_name');
										$lname = get_the_author_meta('last_name');
										$full_name = '';

										if( empty($fname)){
										    $full_name = $lname;
										} elseif( empty( $lname )){
										    $full_name = $fname;
										} else {
										    //both first name and last name are present
										    $full_name = "{$fname} {$lname}";
										}
											
											//$output .= 'by ' . get_the_author_meta('nickname');
											$output .= 'by ' . $full_name;
										$output .= '</a>';
									$output .= '</div>';
								}

								if( $show_date ) {
									$output .= '<div class="post-author">';
										$output .= get_the_date();
									$output .= '</div>';
								}

							$output .= '</div>';

							$output .= "<input type='hidden' name='post_type' class='post_type' value='{$post_type}'>";
							$output .= "<input type='hidden' name='term_id' class='term_id' value='{$term_id}'>";

							$output .= "<input type='hidden' name='post_ids[]' class='post_id' value='{$post_id}'>";
							$output .= "<input type='hidden' name='show_thumb_caption' class='show_thumb_caption' value='{$show_thumb_caption}'>";
							$output .= "<input type='hidden' name='show_excerpt' class='show_excerpt' value='{$show_excerpt}'>";
							$output .= "<input type='hidden' name='show_author' class='show_author' value='{$show_author}'>";
							$output .= "<input type='hidden' name='bootstrap_class' class='bootstrap_class' value='{$class}'>";
							$output .= "<input type='hidden' name='post_class' class='post_class' value='{$post_class}'>";
							$output .= "<input type='hidden' name='thumb_size' class='thumb_size' value='{$thumb_size}'>";
						$output .= '</article>';
					$output .= "</div>";


					// Show advertisement on every 5 posts
					if( $counter == 5  ) {
						if( $ad_id ) {
							$output .= '<div class="col-md-12">';
							ob_start();
							dynamic_sidebar( $ad_id );
							$output .= ob_get_contents();
							ob_end_clean();
							$output .= '</div>';
						}
					}
					$counter++;

					// Show advertisement on every 5 posts end here
				} // Foreach end here

			// Read more stories
			if( $read_more ) {
				$output .= '<div class="load-more-stories"></div>';
				$label = __( 'More Stories', 'everstrap' );

				$output .= '<div class="col-md-12">';
					$output .= "<button type='button' class='button_two load-more-btn'>{$label}</button>";
				$output .= '</div>';
			}

			//$output .= '</div>'; // article wrapper class
			wp_reset_postdata();
			return $output;
		}
	}
}


/**
* Everstrap read more function
*/
if( !function_exists( 'everstrap_load_more_stories' ) ) {
	function everstrap_load_more_stories( $args ) {

		global $post;

		$default = [
			'post_type' => 'post',
			'post_per_page' => 5
		];

		$args = wp_parse_args( $args, $defaults );


		$get_posts = get_posts( $args );

		if( $get_posts ) {
			foreach ( $get_posts as $post ) {
				setup_postdata( $post );
				the_title();
				echo '<br>';
			}
			wp_reset_postdata();
		}
	}
}


/**
 * Save Event meta field
 *
 * @param $post_id
 * @param $posted
 */
function berkshire_save_event_meta( $post_id, $posted ) {
	$eevorg_event_venue = ! empty( $posted[ 'eevorg_event_venue' ] ) ? sanitize_text_field( $posted[ 'eevorg_event_venue' ] ) : '';
	update_post_meta( $post_id, 'eevorg_event_venue', $eevorg_event_venue );

	$eevorg_event_twitter = ! empty( $posted[ 'eevorg_event_twitter' ] ) ? sanitize_text_field( $posted[ 'eevorg_event_twitter' ] ) : '';
	update_post_meta( $post_id, 'eevorg_event_twitter', $eevorg_event_twitter );

	$eevorg_event_facebook = ! empty( $posted[ 'eevorg_event_facebook' ] ) ? sanitize_text_field( $posted[ 'eevorg_event_facebook' ] ) : '';
	update_post_meta( $post_id, 'eevorg_event_facebook', $eevorg_event_facebook );

	$eevorg_event_instragram = ! empty( $posted[ 'eevorg_event_instragram' ] ) ? sanitize_text_field( $posted[ 'eevorg_event_instragram' ] ) : '';
	update_post_meta( $post_id, 'eevorg_event_instragram', $eevorg_event_instragram );

	$eevorg_event_youtube = ! empty( $posted[ 'eevorg_event_youtube' ] ) ? sanitize_text_field( $posted[ 'eevorg_event_youtube' ] ) : '';
	update_post_meta( $post_id, 'eevorg_event_youtube', $eevorg_event_youtube );

	$eevorg_event_ticket_link = ! empty( $posted[ 'eevorg_event_ticket_link' ] ) ? sanitize_text_field( $posted[ 'eevorg_event_ticket_link' ] ) : '';
	update_post_meta( $post_id, 'eevorg_event_ticket_link', $eevorg_event_ticket_link );

	$eevorg_event_group = ! empty( $posted[ 'eevorg_event_group' ] ) ? sanitize_text_field( $posted[ 'eevorg_event_group' ] ) : '';
	update_post_meta( $post_id, 'eevorg_event_group', $eevorg_event_group );


}
add_action( 'event_calendar_pro_event_saved', 'berkshire_save_event_meta', 10, 2 );


function get_membership_roles(){ 
  $url = $_SERVER['REQUEST_URI'];
  if($url == "/berkshire-edge-membership/"){

  ?>
<script>
  jQuery( document ).ready(function() {
var nextPage = true;
var page = "";
var members = [];
var leaders = [];
var advisors = [];
  while (nextPage) {
    var settings = {
      "async": true,
      "crossDomain": true,
      "async": false,
      "ajaxI": nextPage,
      error: function(xhr) {
            console.log('End of Memberful Retrieval');
      },
      "url": "https://cors-anywhere.herokuapp.com/https://theberkshireedge.memberful.com/api/graphql",
      "method": "POST",
      "dataType": 'json',
      "headers": {
        "Authorization": "Bearer cwcXfbWFZGdwwxLzgw4yJQuP",
        "Content-Type": "application/json",
        "cache-control": "no-cache",
        "Postman-Token": "27653152-40ba-4eab-acf8-9392d1a10978"
      },
      "processData": false,
      "data": "{\"query\":\"{ members(after:" + page + ") { edges { node { id fullName subscriptions {id plan { id }}}}pageInfo {endCursor hasNextPage}}  }\"}"   }
    jQuery.ajax(settings).done(function (response) {
      page = response['data']['members']['pageInfo']['endCursor'];
      if( (page == null)){
        nextPage = false;
        return
      }

      for(var i = 0; i < response['data']['members']['edges'].length; i++){

          if(response['data']['members']['edges'][i]['node']['subscriptions'][0]){
            if( response['data']['members']['edges'][i]['node']['subscriptions'][0]['plan']['id'] == 36343 ) {
            members.push(response.data.members.edges[i].node.fullName);
            } else if (response['data']['members']['edges'][i]['node']['subscriptions'][0]['plan']['id'] == 36344){
            members.push(response.data.members.edges[i].node.fullName);
            } else if (response['data']['members']['edges'][i]['node']['subscriptions'][0]['plan']['id'] == 36346){
            leaders.push(response.data.members.edges[i].node.fullName);
            } else if (response['data']['members']['edges'][i]['node']['subscriptions'][0]['plan']['id'] == 36347){
            leaders.push(response.data.members.edges[i].node.fullName);
            } else if (response['data']['members']['edges'][i]['node']['subscriptions'][0]['plan']['id'] == 36348){
            advisors.push(response.data.members.edges[i].node.fullName);
            } else if (response['data']['members']['edges'][i]['node']['subscriptions'][0]['plan']['id'] == 36349){
            advisors.push(response.data.members.edges[i].node.fullName);
            }
          }
      }

    });
    
  }

//Members
var membersList = "<div class='support-main edge-advisor'><h3>Members</h3></div><p>";
members.sort();
members.forEach(function(member) {
  member = member.toLowerCase();
  membersList += member + ', ';
});
membersList = membersList.slice(0, -2);
membersList += '</p>';
 
document.getElementById('members').innerHTML = membersList;

//Leaders
var leadersList = "<div class='support-main edge-advisor'><h3>Leaders</h3></div><p>";
leaders.sort();
leaders.forEach(function(leader) {
  leader = leader.toLowerCase();
  leadersList += leader + ', ';
});
leadersList = leadersList.slice(0, -2);
leadersList += '</p>';

document.getElementById('leaders').innerHTML = leadersList;

//Advisors

var advisorsList = "<div class='support-main edge-advisor'><h3>Advisors</h3></div><p>";
advisors.sort();
advisors.forEach(function(advisor) {
  advisor = advisor.toLowerCase();
  advisorsList += advisor + ', ';
});
advisorsList = advisorsList.slice(0, -2);
advisorsList += '</p>';

document.getElementById('advisors').innerHTML = advisorsList;
});
  </script>
  <?php
  return '';
  }
}
add_action( 'wp_footer', 'get_membership_roles' );

function everstrap_homepage_content_section_ad() { ?>
    <broadstreet-zone zone-id="66453"></broadstreet-zone>
<?php }