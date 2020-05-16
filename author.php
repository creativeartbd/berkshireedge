<?php
/**
 * The template for displaying the real estate post loop
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$author_id = get_the_author_meta( 'ID' );
?>
    <div class="wrapper" id="index-wrapper">
        <div class="container" id="content" tabindex="-1">
            <div class="row">
                <div class="col-md-8 content-area mobile-padding" id="primary">
                    <main class="site-main" id="main">
                        <div class="row">
                            <div class="col-md-12">
                                <article <?php post_class( 'horizental-post' ); ?> id="post-<?php the_ID(); ?>">
                                    <div class="post-author-wrapper">
                                        <div class="post-author-thumb">
											<?php
											everstrap_author_image( $author_id );
											?>
                                        </div>
                                        <div class="post-author-content">
                                            <h2>
                                                <a href="<?php echo get_author_posts_url( $author_id ); ?>"><?php echo get_the_author(); ?></a>
                                            </h2>
                                            <p><?php echo get_the_author_meta( 'description' ); ?></p>
                                        </div>
                                    </div>

									<?php
									// Advertisement
									if ( is_active_sidebar( 'author-page-ad' ) ) {
										dynamic_sidebar( 'author-page-ad' );
									}
									?>

                                    <div class="author-page-title">
                                        <h2>
											<?php _e( 'Articles from ' . get_the_author(), 'everstrap' ); ?>
                                        </h2>
                                    </div>
                                </article>
                            </div>

							<?php
							$GLOBALS[ 'author_post_counter' ] = 1; // I need this in content-author.php page for ad
							$exclude                          = [];
							$term                             = get_queried_object();
							$no_of_author_post                = count_user_posts( $term->ID );

							if ( have_posts() ) {
								while ( have_posts() ) {
									the_post();

									get_template_part( 'loop-templates/content', 'author' );
									$GLOBALS[ 'author_post_counter' ] ++;
									array_push( $exclude, get_the_ID() );
									if ( 11 == $GLOBALS[ 'author_post_counter' ] ) {
										break;
									}
								}
								unset( $GLOBALS[ 'author_post_counter' ] );
							}
							?>

                            <div class="author-load-more-post"></div>
                            <div class="col-md-12">
								<?php
								// Load more posts of that user
								if ( $no_of_author_post > 1 ) {
									$title = 'Load More Posts';
									$class = 'button_two';
									$args  = array(
										'posts_per_page' => 10,
										'order'          => 'DESC',
										'post_status'    => 'publish',
										'author'         => $term->ID,
										'template_name'  => 'author',
										'exclude'        => $exclude
									);
									echo '<div class="author-load-more-post-btn-wrapper">';
									apply_filters( 'everstrap_load_more_button', $args, $title, $class );
									echo '</div>';
								}
								?>

                                <br>
								<?php
								// Advertisement
								if ( is_active_sidebar( 'author-page-ad' ) ) {
									dynamic_sidebar( 'author-page-ad' );
								}
								?>
                            </div>

                        </div>
                    </main>
                </div> <!-- col-md end -->
				<?php get_sidebar( 'right-top' ); ?>
            </div> <!-- wrapper end -->
        </div> <!-- container end -->
    </div> <!-- wrapper end -->


<?php
get_footer();
