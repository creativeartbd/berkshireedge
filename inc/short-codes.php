<?php
/**
 * EverStrap short codes scripts
 *
 * @package everstrap
 */


/*
 * Everstrap eevorg event short code
 *
 */

add_shortcode( 'everstrap_media_kit', 'everstrap_media_kit_func' );
if( !function_exists( 'everstrap_media_kit_func' ) ) {
	function everstrap_media_kit_func( $atts ) {
		$media_kits = everstrap_get_field( 'file_upload', get_the_ID() );
		$data = '';
		foreach( $media_kits as $media_kit ) {
			if( !empty( $media_kit['media_kit_file'] ) ) {
				$media_kit_label = $media_kit['media_kit_label'];
				$data .= '<a href="'.$media_kit['media_kit_file'].'" class="media_kit" target="_blank">'.$media_kit_label.'</a>';	
			}
			
		}

		return $data;
	}
}

/*
 * Everstrap eevorg event short code
 *
 */
add_shortcode( 'everstrap_eevorg_event', 'everstrap_eevorg_event_func' );
if( !function_exists( 'everstrap_eevorg_event_func' ) ) {
	function everstrap_eevorg_event_func( $atts ) {

		global $wpdb;
		
		$atts = shortcode_atts( 
			array (
            	'title' => 'Calendar',
            	'limit' => 6,
        	), $atts 
		);

		$data = '';

		$data .= '<div class="eevorg-widget-event-container">';

		if( $atts['title'] ) {
			$data .= '<h2>' . $atts['title']  . '</h2>';
		}

		if( $atts['limit'] ) {
			$limit = $atts['limit'];
		}
		
		$events = $wpdb->get_results( "SELECT event_id, event_name, event_start_time, event_end_time, event_image, event_date_type, event_date FROM {$wpdb->prefix}eevorg_event WHERE publish != 0 ORDER BY event_id DESC LIMIT {$limit}", OBJECT );

		if ( ! empty( $events ) ) {
			foreach ( $events as $event ) {

				$event_id         = $event->event_id;
				$event_name       = $event->event_name;
				$event_name       = stripslashes( $event_name );
				$event_start_time = $event->event_start_time;
				if ( 12 >= $event_start_time ) {
					$event_start_am_pm = 'AM';
				} else {
					$event_start_am_pm = 'PM';
				}

				$event_end_time = $event->event_end_time;
				if ( 12 >= $event_end_time ) {
					$event_end_am_pm = 'AM';
				} else {
					$event_end_am_pm = 'PM';
				}

				$event_image    = $event->event_image;
				$image_location = 'https://theberkshireedge.com/wp-content/uploads/eevorg/uploads/event_img/';
				$event_image    = '<img src="' . $image_location . $event_image . '" width="80">';

				$event_date_type = $event->event_date_type;

				if ( 'single' == $event_date_type ) {

					$event_dates      = $event->event_date;
					$event_dates      = explode( ',', $event_dates );
					$event_date       = strtotime( $event_dates[ 0 ] );
					$event_full_month = date( 'F', $event_date );
					$event_date_no    = date( 'd', $event_date );

				} elseif ( 'multiple' == $event_date_type ) {

					$event_dates      = $event->event_date;
					$event_dates      = explode( ',', $event_dates );
					$event_date       = strtotime( $event_dates[ 0 ] );
					$event_full_month = date( 'F', $event_date );
					$event_date_no    = date( 'd', $event_date );

					//$event_dates = $event_date;
				} elseif ( 'range' == $event_date_type ) {

					$event_dates      = $event->event_date;
					$event_dates      = explode( '|', $event_dates );
					$event_date       = strtotime( $event_dates[ 0 ] );
					$event_full_month = date( 'F', $event_date );
					$event_date_no    = date( 'd', $event_date );
				}

				$event_link = site_url( '/' ) . 'event/?event_id=' . base64_encode( $event_id );

				$data .= '<div class="eevorg-widget-event-wrapper">';
				$data .= '<div class="event-widget-thumb">';
				$data .= $event_image;
				$data .= '</div>';
				$data .= '<div class="event-widget-description">';
				$data .= '<p><a href="' . $event_link . '">' . $event_name . '</a></p>';
				$data .= '<p>' . $event_full_month . ' ' . $event_date_no . '</p>';
				$data .= '<p>' . '@ ' . $event_start_time . ' ' . $event_start_am_pm . ' - ' . $event_end_time . ' ' . $event_end_am_pm . '</p>';
				$data .= '</div>';
				$data .= '</div>';

			}
			$data .= '<div class="event-buttons">';
			$data .= '<a href="/event-account/?create=events" class="button_two pull-left">';
			$data .= esc_html( 'Post event' );
			$data .= '</a>';
			$data .= '<a href="/event/" class="button_two pull-right">';
			$data .= esc_html( 'see all' );
			$data .= '</a>';
			$data .= '</div>';
		}

			$data .= '</div>';
		
		return $data;

	}
}

/*
 * Everstrap become a member short code
 *
 */
add_shortcode( 'become_a_member', 'become_a_member_func' );
if( !function_exists( 'become_a_member_func' ) ) {
	function become_a_member_func() {

		$become_a_member_page = everstrap_get_field( 'become_a_member_page', 'option' );
		if( $become_a_member_page ) {
			$become_a_member_page = $become_a_member_page;
		} else {
			$become_a_member_page = '';
		}

		$html = '';
		$label = __( 'Become a Member', 'everstrap' );
		$html .= '<a href="' . $become_a_member_page . '" target="_blank">';
			$html .= "<button class='button_two'>{$label}</button>";
		$html .= '</a>';
		return $html;
	}
}


/*
 * Everstrap social short code
 *
 */
add_shortcode( 'everstrap_social', 'everstrap_social_func' );
if( !function_exists( 'everstrap_social_func' ) ) {
	function everstrap_social_func( ) {
		$added_socials = get_field( 'social_media_name', 'option' );
		if( $added_socials ) {
			$html = '';
			$html .= '<div class="social-wrapper">';

			foreach ( $added_socials as $socials ) {
				$html .= "<a href='{$socials['social_media_url']}' target='_blank'>";
				$html .= "<i class='{$socials['font_awesome_icon_class']}' aria-hidden='true'></i>";
				$html .= '</a>';
			}
			$html .= '</div>';
			return $html;
		}
	}
}


/**
 * Subscribe Now Short Code
 */
add_shortcode( 'everstrap_subscribe_now', 'everstrap_subscribe_now_func' );
if( !function_exists( 'everstrap_subscribe_now_func' ) ) {
	function everstrap_subscribe_now_func( $atts ) {
		
		$atts = shortcode_atts( [
			'location' => '',			
		], $atts );


		if( isset( $atts['location'] ) && 'sidebar' == $atts['location'] ) {
			$sidebar_class = 'sidebar-subscribe-now';
		} else {
			$sidebar_class = 'input-group';
		}

		
		
		$html = '';
		// $html .= '<div class="input-group">';
		// $html .= '<input type="email" class="form-control subscribe-input" placeholder="Email Address...">';
		// $html .= '<span class="input-group-btn">';
		// $html .= '<button class="" type="button">Subscribe Now</button>';
		// $html .= '</span>';
		// $html .= '</div>';		
		$acf_field = everstrap_get_field( 'subscribe_now', 'option' );
		$form = $acf_field['subscribe_shortcode'];
		$title = $acf_field['subscribe_title'];
		$sub_title = $acf_field['subscribe_sub_title'];

		$html .= '<div class="subscribe-now-container">';
			$html .= '<h2>' . $title . '</h2>';
			$html .= '<p>' . $sub_title . '</p>';
			$html .= '<div class="'. $sidebar_class .'">';
				$html .= do_shortcode( $form );
			$html .= '</div>';
		$html .= '</div>';		
		return $html;
	}
}

/**
 * Featured Article Sidebar Shortcode
 */
if( !function_exists('everstrap_featured_articles') ) {
	function everstrap_featured_articles() {
		ob_start();
		?>
			<div class="bk_featured_article">
				<?php
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 6,
						'meta_query' => array(
							array(
								'key' => 'featured_post',
								'value' => '1',
								'compare' => '=',
							)
						)
					);

					$featured_posts = get_posts($args);

					if( !empty($featured_posts) ) {
						if( count($featured_posts) > 0 ) {

							foreach( $featured_posts as $post ) {
								setup_postdata( $post );
								$id = $post->ID;
								$thumbnail = get_the_post_thumbnail( $id, 'small-post-thumb' );

								$category = get_the_category($id);
								$cat_name = $category[0]->name;
								$cat_id = $category[0]->term_id;
								
								?>
								<div class="bk_featured_item">
									<div class="bk-featured-article-img">
										<?php echo $thumbnail; ?>
									</div>
									<div class="bk-featured-article-content">
										<a href="<?php echo get_category_link($cat_id); ?>" target="_blank"><span class="bk-featured-article-category"><?php echo $cat_name; ?></span></a>
										<?php
											$content = $post->post_content ;
											echo wpautop( wp_trim_words( $content, 20, null ) ); 
										?>
									</div>
								</div>
								<?php
								}
								wp_reset_postdata();
							}
						}
					?>

			</div>
		<?php
		$html = ob_get_clean();

		return $html;

	}
}

add_shortcode( 'everstrap_featured_articles', 'everstrap_featured_articles' );


/**
 * RealState Article Sidebar Shortcode
 */
if( !function_exists('everstrap_realstate_articles') ) {
	function everstrap_realstate_articles() {
		ob_start();
		?>
			<div class="bk_featured_article">
				<?php
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 5,
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
								'field' => 'slug',
								'terms' => 'real-estate'
							)
						 )
					);

					$featured_posts = get_posts($args);

					if( !empty($featured_posts) ) {
						if( count($featured_posts) > 0 ) {

							foreach( $featured_posts as $post ) {
								setup_postdata( $post );
								$id = $post->ID;
								$thumbnail = get_the_post_thumbnail( $id, 'small-post-thumb' );

								if( function_exists('get_field') ) {
									$prop_desc = get_field('property_description', $id);
									$prop_val = get_field('property_value', $id);
									$offer_by = get_field('offered_by', $id);
								}
								
								?>
								<div class="bk_featured_item">
									<div class="bk-featured-article-img">
										<?php echo $thumbnail; ?>
									</div>
									<div class="bk-featured-article-content">
										<a href="<?php echo get_the_permalink($id); ?>" target="_blank"><span class="bk-featured-article-category"><?php echo get_the_title($id); ?></span></a>
										<p><?php echo $prop_desc; ?></p>
										<p><?php echo $prop_val; ?></p>
										<?php
											if( !empty($offer_by) ) {
												?>
												<p class="offered_by">Offered by: <?php echo $offer_by; ?></p>
												<?php
											}
										?>
									</div>
								</div>
								<?php
								}

								wp_reset_postdata();
							}
						}
					?>

			</div>
		<?php
		$html = ob_get_clean();

		return $html;

	}
}

add_shortcode( 'everstrap_realstate_articles', 'everstrap_realstate_articles' );
