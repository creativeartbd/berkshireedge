<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'everstrap_posted_on' ) ) {
	function everstrap_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
		$posted_on   = apply_filters(
			'everstrap_posted_on',
			sprintf(
				'<span class="posted-on">%1$s <a href="%2$s" rel="bookmark">%3$s</a></span>',
				esc_html_x( 'Posted on', 'post date', 'everstrap' ),
				esc_url( get_permalink() ),
				apply_filters( 'everstrap_posted_on_time', $time_string )
			)
		);
		$byline      = apply_filters(
			'everstrap_posted_by',
			sprintf(
				'<span class="byline"> %1$s<span class="author vcard"><a class="url fn n" href="%2$s"> %3$s</a></span></span>',
				$posted_on ? esc_html_x( 'by', 'post author', 'everstrap' ) : esc_html_x( 'Posted by', 'post author', 'everstrap' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() )
			)
		);

		if( strtolower(  get_the_author() ) != 'webpublisherpro' ) {
			echo $byline . ' <br/> ' . $posted_on;
		}
	}
}


/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
if ( ! function_exists( 'everstrap_entry_footer' ) ) {
	function everstrap_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'everstrap' ) );
			if ( $categories_list && everstrap_categorized_blog() ) {
				/* translators: %s: Categories of current post */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %s', 'everstrap' ) . '</span>', $categories_list );
			}
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'everstrap' ) );
			if ( $tags_list ) {
				/* translators: %s: Tags of current post */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %s', 'everstrap' ) . '</span>', $tags_list );
			}
		}
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'everstrap' ), esc_html__( '1 Comment', 'everstrap' ), esc_html__( '% Comments', 'everstrap' ) );
			echo '</span>';
		}
		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'everstrap' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
}


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
if ( ! function_exists( 'everstrap_categorized_blog' ) ) {
	function everstrap_categorized_blog() {
		//phpcs:ignore WordPress.CodeAnalysis.AssignmentInCondition.Found
		if ( false === ( $all_the_cool_cats = get_transient( 'everstrap_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(
				array(
					'fields'     => 'ids',
					'hide_empty' => 1,
					// We only need to know if there is more than one category.
					'number'     => 2,
				)
			);
			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );
			set_transient( 'everstrap_categories', $all_the_cool_cats );
		}
		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so components_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so components_categorized_blog should return false.
			return false;
		}
	}
}


/**
 * Flush out the transients used in everstrap_categorized_blog.
 */
add_action( 'edit_category', 'everstrap_category_transient_flusher' );
add_action( 'save_post', 'everstrap_category_transient_flusher' );

if ( ! function_exists( 'everstrap_category_transient_flusher' ) ) {
	function everstrap_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'everstrap_categories' );
	}
}


/**
 * Post Category Function
 */
if ( ! function_exists( 'everstrap_post_categories' ) ) {
	function everstrap_post_categories() {
		if ( 'post' === get_post_type() ) {

			$term = everstrap_get_primary_term( get_the_ID() );

			if ( ! empty( $term ) ) { ?>
				<div class="post-category">
					<a href="<?php echo esc_url( get_term_link( $term->term_id ) ); ?>">
						<?php echo esc_html__( $term->name, 'everstrap' ); ?>
					</a>
				</div>
				<?php
			}
		}
	}
}

/**
 * Post ByLine Function
 */
if ( ! function_exists( 'everstrap_post_byline' ) ) {
	function everstrap_post_byline() {
		if ( 'post' === get_post_type() ) {
			$posted_by = sprintf(
				'<span class="byline"> %1$s<a class="url fn n" href="%2$s"> %3$s</a></span>',
				esc_html_x( 'by', 'post author', 'everstrap' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_html( get_the_author() )
			);
			echo $posted_by;
		}
	}
}

/**
 * Everstrap social share
 */

if ( ! function_exists( 'everstrap_post_social_share' ) ) {
	function everstrap_post_social_share( $post_id, array $socials, $title = null ) {
		$html  = '';
		$html .= '<div class="social-share">';

		if ( $title ) {
			$html .= '<p>' . $title . '</p>';
		}

		$html .= '<ul>';
		foreach ( $socials as $social ) {
			$html .= '<li>';
			if ( 'envelope' === $social ) {
				$html .= "<a class='send-message' target='_blank' data-title='" . get_the_title() . "'><i class='fa fa-envelope'></i></a>";
			} elseif ( 'link' === $social ) {
				$html .= "<a class='click-to-copy' data-link='" . get_the_permalink() . "'><i class='fa fa-link'></i></a>";				
			} elseif ( 'print' === $social ) {
				$html .= "<a href='#' class='print-page'><i class='fa fa-{$social}'></i></a>";				
			} else {
				$html .= "<a href='" . everstrap_get_share_link( $post_id, $social ) . "' target='_blank'><i class='fa fa-{$social}'></i></a>";
			}

			$html .= '</li>';
		}
		$html .= '</ul>';
		$html .= '</div>';
		echo $html;
	}
}

/**
* EVerstrap get member by role
*/
if( !function_exists( 'everstrap_get_member_by_role' ) )  {
	function everstrap_get_member_by_role( $role_name ) {
		if( !$role_name )
			return;

		$args = array(
		    'role'    => $role_name,
		    'orderby' => 'user_nicename',
		    'order'   => 'ASC'
		);

		$users = get_users( $args );
		
		if( $users ) {
			$all_users = [];
			foreach ( $users as $user ) {
				$all_users[] = '<span>' . ucfirst( $user->display_name ) . '</span>';				
			}	
			return implode( ', ', $all_users );
		}	

	}
}

/**
* Edge  have any ploan
*/

if( !function_exists( 'edge_have_any_plan') ) {
	function edge_have_any_plan() {
		if ( function_exists( 'memberful_wp_user_plans_subscribed_to' ) ) {
			$plans = memberful_wp_user_plans_subscribed_to( wp_get_current_user()->ID );
			return !empty( $plans );
		}
		return false;
	}	
}

/**
 * Show author image.
 */
if ( ! function_exists( 'everstrap_author_image' ) ) {
	function everstrap_author_image( $author_id ) {
		if ( function_exists( 'get_author_image' ) ) {
			echo get_author_image( $author_id );
		} else {
			$author_thumb_url = get_avatar_url( $author_id, [ 'size' => 97 ] );
			echo "<img src='{$author_thumb_url}'/>";
		}
	}
}

if ( ! function_exists( 'everstrap_post_main_photo' ) ) {
	function everstrap_post_main_photo( $post_id, $thumb_size ) {
		if ( get_field( 'photo' ) && $photo_id = get_field( 'photo', $post_id ) ) {
			$photo = wp_get_attachment_image( $photo_id, $thumb_size );
			if ( empty( $photo ) ) {
				return false;
			} else {
				return sprintf( '<a href="%s">%s</a>', get_the_permalink( $post_id ), $photo );
			}
		}

		return false;
	}
}

