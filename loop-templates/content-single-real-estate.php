<?php
/**
 * The template for displaying the single post
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package everstrap
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class( 'single-post' ); ?> id="post-<?php the_ID(); ?>">

	<?php  
	$is_sponsored_post = everstrap_get_field( 'is_sponsored_post', get_the_ID() );

	if( $is_sponsored_post ) {
		echo '<div class="sponsored">sponsored content</div>';
	}
	?>

	<?php
	$re_gallery = everstrap_get_field( 'pw_gallery', get_the_id() );
	//var_dump( $re_gallery );
	if ( $re_gallery ) { ?>
        <div class="re-slider">
            <div id="slider-thumb" class="owl-carousel owl-theme post-thumbnail">
				<?php
				foreach ( $re_gallery as $gallery ) {
					if ( $gallery[ 'sizes' ] ) {
						$gallery_img = $gallery[ 'sizes' ][ 'full-article' ]; ?>
                        <div class="item">
                            <img src="<?php echo $gallery_img; ?>"/>
							<?php if ( $gallery[ 'caption' ] ) { ?>
                                <div class="thumb-caption">
									<?php echo esc_html( $gallery[ 'caption' ] ); ?>
                                </div>
							<?php } ?>
                        </div>
					<?php }
				} ?>
            </div>
            <div id="preview-thumb" class="owl-carousel owl-theme">
				<?php
				foreach ( $re_gallery as $gallery ) {
					if ( $gallery[ 'sizes' ] ) {
						$gallery_img = $gallery[ 'sizes' ][ 'slider-thumb' ]; ?>
                        <div class="item">
                            <img src="<?php echo $gallery_img; ?>"/>
                        </div>
					<?php }
				} ?>
            </div>
        </div>
	<?php }  elseif ( has_post_thumbnail() ) { ?>
        <div class="post-thumbnail">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'full-article' ); ?>
            </a>
			<?php
			if( get_the_post_thumbnail_caption() ) {
				echo '<div class="thumb-caption">';
				echo get_the_post_thumbnail_caption();
				echo '</div>';
			}
			?>
        </div>
	<?php } ?>
	
	<header class="entry-header">
		<?php
		$re_category = get_the_terms( get_the_ID(), 're-category' );
		
		echo '<div class="post-category">';
			foreach ( $re_category as $category ) {
				$category_id = get_term_link( $category->term_id );	
				echo '<a href="'.$category_id.'">';
					echo $category->name;
				echo '</a>';
				break;
			}
		echo '</div>';
		
		the_title( sprintf( '<h1 class="entry-title">' ), '</a></h1>' );

		if ( has_excerpt() ) {
			echo sprintf( '<p class="post-subtitle">%s</p>', esc_html( get_the_excerpt() ) );
		}
		?>

		<div class="entry-meta">
			<?php everstrap_posted_on();?>
		</div>	
		
		<?php everstrap_post_social_share( get_the_ID(), [ 'twitter', 'facebook', 'print', 'envelope', 'link' ] ); ?>							

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php 
		$embed_code = everstrap_get_field( 'embed_code', get_the_ID() );
		if( $embed_code ) {
			echo $embed_code;
		}
		?>

		<?php the_content();

		
		if( everstrap_get_field( 'learn_more_link_for_the_main_content', get_the_ID() ) ) {

			$learn_more_link_ftc = everstrap_get_field( 'learn_more_link_for_the_main_content', get_the_ID() );
			$learn_more_label = $learn_more_link_ftc[ 'title' ]; 
			$learn_more_url = $learn_more_link_ftc[ 'url' ]; 
			$learn_more_target = $learn_more_link_ftc[ 'target' ]; 
			$learn_more_class = 'button_two';	

			echo sprintf( "<a href='%s' target='%s' class='%s'>%s</a>", $learn_more_url, $learn_more_target, $learn_more_class, $learn_more_label );			
			echo '<br/>';
		}

		$wy_houses = everstrap_get_field( 'wy_house', get_the_ID() );
		if( $wy_houses ) {
			foreach ( $wy_houses as $wy_house ) {
				$wy_image = $wy_house['wy_image'];
				$wy_details = $wy_house['wy_details'];
				$wy_link = $wy_house['wy_link'];
				
				if( $wy_link ) {
					echo '<img src="'. $wy_image .'"/>';	
					echo '<hr/>';
				}

				if( $wy_details ) {					
					echo $wy_details;	
				}

				if( $wy_link ) {
					echo '<a href="'.$wy_link.'" target="_blank"><strong>Click to learn more</strong></a>';
				}	 
			}
		}

		$rs_areas = everstrap_get_field( 'rs_area', get_the_ID() );
		if( $rs_areas ) {
			foreach ( $rs_areas as $rs_area ) {
				$rs_title = $rs_area['rs_title'];
				$rs_details = $rs_area['rs_details'];
				echo '<h1>' . $rs_title .  '</h1>';
				echo '<p>' . $rs_details .  '</p>';
			}
		}

		$rs_source = everstrap_get_field( 'rs_source', get_the_ID() );
		if( $rs_source ) {
			echo '<h1>Source</h1>';
			echo $rs_source;
		}

		if( everstrap_get_field( 'pw_content1', get_the_ID() ) ) {
			echo '<h2>';
				echo everstrap_get_field( 'whats_the_most', get_the_ID() );
			echo '</h2>';

			if( everstrap_get_field( 'pw_content1', get_the_ID() ) ) {
				echo '<p>';
					echo everstrap_get_field( 'pw_content1', get_the_ID() );
				echo '</p>';
			}				
		}

		if( everstrap_get_field( 'pw_content2', get_the_ID() ) ) {
			echo '<h2>';
				echo everstrap_get_field( 'who_is_this', get_the_ID() );
			echo '</h2>';

			if( everstrap_get_field( 'pw_content2', get_the_ID() ) ) {
				echo '<p>';
					echo everstrap_get_field( 'pw_content2', get_the_ID() );
				echo '</p>';
			}				
		}

		if( everstrap_get_field( 'pw_content3', get_the_ID() ) ) {
			echo '<h2>';
				echo everstrap_get_field( 'whats_the_fun', get_the_ID() );
			echo '</h2>';

			if( everstrap_get_field( 'pw_content3', get_the_ID() ) ) {
				echo '<p>';
					echo everstrap_get_field( 'pw_content3', get_the_ID() );
				echo '</p>';
			}				
		}

		if( everstrap_get_field( 'pw_content4', get_the_ID() ) ) {
			echo '<h2>';
				echo everstrap_get_field( 'if_this_house', get_the_ID() );
			echo '</h2>';

			if( everstrap_get_field( 'pw_content4', get_the_ID() ) ) {
				echo '<p>';
					echo everstrap_get_field( 'pw_content4', get_the_ID() );
				echo '</p>';
			}				
		}

		if( everstrap_get_field( 'optional_section', get_the_ID() ) ) {
			
			$optional_section = everstrap_get_field( 'optional_section', get_the_ID() );

			foreach ( $optional_section as $section ) {
			 	if( $section['title_optional'] ) {
					echo '<h2>';
						echo $section['title_optional'];
					echo '</h2>';			 		
			 	}

			 	if( $section['content_optional'] ) {
			 		echo '<p>';
						echo $section['content_optional'];
					echo '</p>';
			 	}
			}
			
		}

		if( everstrap_get_field( 'click_to_learn_more', get_the_ID() ) ) {

			$click_to_learn_more = everstrap_get_field( 'click_to_learn_more', get_the_ID() );
			$learn_more_label = $click_to_learn_more[ 'title' ]; 
			$learn_more_url = $click_to_learn_more[ 'url' ]; 
			$learn_more_target = $click_to_learn_more[ 'target' ]; 
			$learn_more_class = 'button_two';			
			echo sprintf( "<a href='%s' target='%s' class='%s'>%s</a>", $learn_more_url, $learn_more_target, $learn_more_class, $learn_more_label );			
			echo '<br/>';
		}
		?>
	</div>	
	
	<div class="mt-1">
		<?php everstrap_post_social_share( get_the_ID(), [ 'twitter', 'facebook', 'print', 'envelope', 'link' ] ); ?>
	</div>
	
	<div class="re-meta-field">
		<?php
		for ( $i = 1;  $i <= 2;  $i++) { 
			
			if( $i == 2 ) {
				$no_2 = $i;
			} else {
				$no_2 = '';	
			}

			$realtor_photo = everstrap_get_field( 'realtor_photo'.$no_2, get_the_ID() );
			$realtor_name = everstrap_get_field( 'realtor_name'.$no_2, get_the_ID() );
			$company_name = everstrap_get_field( 'company_name'.$no_2, get_the_ID() );
			$realtor_email = everstrap_get_field( 'realtor_email'.$no_2, get_the_ID() );
			$realtor_phone = everstrap_get_field( 'realtor_phone'.$no_2, get_the_ID() );
			$realtor_mobile = everstrap_get_field( 'realtor_mobile'.$no_2, get_the_ID() );
			$address_1 = everstrap_get_field( 'address_1'.$no_2, get_the_ID() );
			$address_2 = everstrap_get_field( 'address_2'.$no_2, get_the_ID() );
			
			if( !empty( $realtor_name ) ) {
				echo '<div class="re-owner-details">';
					// Photo of the owner
					if( $realtor_photo ) {
						$realtor_photo = $realtor_photo['sizes']['owner-thumb'];
						echo '<div class="re-owner-thumb">';
							echo '<img src="' .  $realtor_photo. '"/>';
						echo '</div>';
					}			

					echo '<div class="re-owner-meta">';

						if( $realtor_name ) {
							echo '<h3>';
								_e( 'Interested? Contact ' . $realtor_name, 'everstrap' );
							echo '</h3>';
						}
						
						if( $company_name ) {
							echo '<h3>';
								_e( $company_name, 'everstrap' );
							echo '</h3>';
						}

						if( $realtor_email ) {
							echo '<p>';
								_e( $realtor_email, 'everstrap' );
							echo '</p>';
						}

						if( $realtor_phone ) {
							echo '<p>';
								_e( $realtor_phone, 'everstrap' );
							echo '</p>';
						}

						// if( $realtor_mobile ) {
						// 	echo '<p>';
						// 		_e( $realtor_mobile, 'everstrap' );
						// 	echo '</p>';
						// }

						if( $address_1 ) {
							echo '<p>';
								_e( $address_1, 'everstrap' );
							echo '</p>';
						}

						if( $address_2 ) {
							echo '<p>';
								_e( $address_2, 'everstrap' );
							echo '</p>';
						}
					echo '</div>';
				echo '</div>';
			}			
		}			
		?>
	</div>
	

	<div class="post-comment-wrapper">
		<div class="post-comment-btn">
			<?php echo do_shortcode('[disqus_comment post_id="'.get_the_ID().'"]') ?>	
		</div>		
	</div>
	<?php  
    if( is_active_sidebar(  'single-post-ad' ) ) {
        dynamic_sidebar( 'single-post-ad');
    }
    ?>


</article><!-- #post-## -->
