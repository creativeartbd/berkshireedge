<?php
/**
 * The template for displaying the real estate full article post
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package everstrap
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class( 'single-post' ); ?> id="post-<?php the_ID(); ?>">

	<div class="category-top-title">
		<?php  
		$terms = get_the_terms( get_the_ID(), 're-category' );
		$category_name .= ''; 
		foreach ( $terms as $term ) {						
			$category_id = get_term_link( $term->term_id );						
			$category_name .= '<a href="'.$category_id.'">';
				$category_name .= $term->name;
			$category_name .= '</a>';
			break;
		}
		// echo '<div class="post-category">';
		// 	echo $category_name;
		// echo '</div>';
		?>
	</div>
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
		echo '<div class="post-category">';
			echo $category_name;
		echo '</div>';

		the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
		?>
		<div class="entry-meta">
			<?php everstrap_posted_on();?>
		</div>

		<div class="social-share">
			<?php everstrap_post_social_share( get_the_ID(), [ 'twitter', 'facebook', 'print', 'envelope', 'link' ] ); ?>
		</div>

		<div class="entry-content">
			<?php the_content(); ?>
		</div>

		<div class="re-meta-field">
			<?php 
			if( everstrap_get_field( 'whats_the_most', get_the_ID() ) ) {
				echo '<h2>';
					echo everstrap_get_field( 'whats_the_most', get_the_ID() );
				echo '</h2>';

				if( everstrap_get_field( 'pw_content1', get_the_ID() ) ) {
					echo '<p>';
						echo everstrap_get_field( 'pw_content1', get_the_ID() );
					echo '</p>';
				}				
			}

			if( everstrap_get_field( 'who_is_this', get_the_ID() ) ) {
				echo '<h2>';
					echo everstrap_get_field( 'who_is_this', get_the_ID() );
				echo '</h2>';

				if( everstrap_get_field( 'pw_content2', get_the_ID() ) ) {
					echo '<p>';
						echo everstrap_get_field( 'pw_content2', get_the_ID() );
					echo '</p>';
				}				
			}

			if( everstrap_get_field( 'whats_the_fun', get_the_ID() ) ) {
				echo '<h2>';
					echo everstrap_get_field( 'whats_the_fun', get_the_ID() );
				echo '</h2>';

				if( everstrap_get_field( 'pw_content3', get_the_ID() ) ) {
					echo '<p>';
						echo everstrap_get_field( 'pw_content3', get_the_ID() );
					echo '</p>';
				}				
			}

			if( everstrap_get_field( 'if_this_house', get_the_ID() ) ) {
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
			?>

			<div class="learn-more">
				<a href="<?php echo get_the_permalink() ?>" class="button_two">
					<?php 
						_e( 'Click To Learn More', 'everstrap' );
					?>
				</a>
			</div>

			<div class="social-share">
				<?php everstrap_post_social_share( get_the_ID(), [ 'twitter', 'facebook', 'print', 'envelope', 'link' ] ); ?>
			</div>

			<div class="re-owner-details">
				<?php 
				$realtor_photo = everstrap_get_field( 'realtor_photo', get_the_ID() );
				$realtor_name = everstrap_get_field( 'realtor_name', get_the_ID() );
				$company_name = everstrap_get_field( 'company_name', get_the_ID() );
				$realtor_email = everstrap_get_field( 'realtor_email', get_the_ID() );
				$realtor_phone = everstrap_get_field( 'realtor_phone', get_the_ID() );
				$realtor_mobile = everstrap_get_field( 'realtor_mobile', get_the_ID() );
				$address_1 = everstrap_get_field( 'address_1', get_the_ID() );
				$address_2 = everstrap_get_field( 'address_2', get_the_ID() );				
				
				
				if( $realtor_photo ) {
					$realtor_photo = $realtor_photo['sizes']['owner-thumb'];
					echo '<div class="re-owner-thumb">';
						echo '<img src="' .  $realtor_photo. '"/>';
					echo '</div>';
				}
				?>
				
				<div class="re-owner-meta">
					<?php  
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
					?> 
					
				</div>
			</div>

            <?php if ( is_active_sidebar( 'real-estate-archive-ad' ) ) {
                dynamic_sidebar( 'real-estate-archive-ad' );
            } ?>

		</div>
		

	</header><!-- .entry-header -->

</article><!-- #post-## -->
