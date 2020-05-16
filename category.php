<?php
/**
 * The template for displaying the author pages
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

    <div class="wrapper" id="index-wrapper">
        <div class="container" id="content" tabindex="-1">
            <div class="row">
                <div class="col-md content-area mobile-padding" id="primary">
                    <main class="site-main" id="main">
                        <!-- <div class="article-wrapper"> -->
						<?php
						$term = get_queried_object();
						if ( have_posts() ) {
							$GLOBALS[ 'category_counter' ] = 0;
							while ( have_posts() ) {
								the_post();
								if ( 0 == $GLOBALS[ 'category_counter' ] ) {
									get_template_part( 'loop-templates/content', 'category-full-thumb' );
									// category frist ad
									get_template_part( 'loop-templates/content', 'category-ad' );
								} else {
									get_template_part( 'loop-templates/content', 'category-short-thumb' );
									// Show ad after 2 posts
									if ( is_active_sidebar( 'category-archive-ad' ) ) {
										if ( $GLOBALS[ 'category_counter' ] % 2 == 0 && 8 !== $GLOBALS[ 'category_counter' ] ) {
											get_template_part( 'loop-templates/content', 'category-ad' );
										}
									}
									if ( 8 == $GLOBALS[ 'category_counter' ] ) {
										break;
									}
								}
								$GLOBALS[ 'category_counter' ] ++;
							}
							?>


                            <div class="author-load-more-post"></div>

							<?php
							// Load more posts of that user
							$title = 'More Stories';
							$class = 'button_two';
							$args  = array(
								'posts_per_page' => 10,
								'order'          => 'DESC',
								'post_status'    => 'publish',
								'offset'         => 8,
								'category_name'  => $term->slug,
								'template_name'  => 'category-short-thumb'
							);

							echo '<div class="author-load-more-post-btn-wrapper">';
							apply_filters( 'everstrap_load_more_button', $args, $title, $class );
							echo '</div>';
						}
						?>

                        <!-- </div> -->
                    </main>
                </div>
				<?php get_sidebar( 'right-top' ); ?>
            </div>
        </div>

		<?php
		// Subscribe Now Section
		if ( class_exists( 'acf' ) ) {
			$subcribe_now = get_field( 'subscribe_now', 'option' );
			if ( $subcribe_now ) {
				echo '<div class="subscribe-now-wrapper text-center">';
				echo '<div class="col-md-12">';
				if ( is_active_sidebar( 'home-page-subscribe-now' ) ) {
					dynamic_sidebar( 'home-page-subscribe-now' );
				}
				echo '</div>';
				echo '</div>';
			}
		}
		?>

		<?php
		// ===================================
		// Footer Advertisement
		// ===================================
		if ( is_active_sidebar( 'footer-ad' ) ) {
			echo '<div class="container" id="content" tabindex="-1">';
			echo '<div class="row">';
			dynamic_sidebar( 'footer-ad' );
			echo '</div>';
			echo '</div>';
		}
		?>

    </div>

<?php
get_footer();
