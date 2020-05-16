<?php
/**
 * The main template file
 * Template Name: Home Page
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
// get header
get_header();
?>

<div class="wrapper" id="index-wrapper">

	<div class="container" id="content" tabindex="-1">
		<div class="row">
			<div class="col-md content-area mobile-padding" id="primary">
				<main class="site-main" id="main">
					<?php echo evertstrap_multiple_category_posts(); ?>
				</main>
			</div>
			<?php get_sidebar( 'home-right-top' ); ?>
		</div>
	</div>


	<?php
	// Subscribe Now Section
	if( class_exists( 'acf' ) ) {
		$subcribe_now = get_field( 'subscribe_now', 'option' );
		if( $subcribe_now ) {
			echo '<div class="subscribe-now-wrapper text-center">';				
				echo '<div class="col-md-12">';
					if( is_active_sidebar( 'home-page-subscribe-now' ) ) {
						dynamic_sidebar( 'home-page-subscribe-now' );
					}						
				echo '</div>';			
			echo '</div>';
		}
	}
	?>

	<div class="container" id="content" tabindex="-1">
		<div class="row">
			<div class="col-md content-area mobile-padding" id="primary">
				<main class="site-main" id="main">
					<?php
					// ===================================
					// Top latest stories advertisement
					// ===================================
					everstrap_homepage_content_section_ad();

					// ===================================
					// Latest stories posts
					// ===================================
					$no_of_latest_stories = everstrap_get_field( 'no_of_latest_stories', 'option' );
					if( $no_of_latest_stories ) {

						$ad_id = '';
						if( is_active_sidebar( 'loop-latest-stories-advertisement' ) ) {
							$ad_id = 'loop-latest-stories-advertisement';
						}

						echo '<div class="row article-wrapper">';
							echo evertstrap_conditional_posts( [
								'title_text' => 'Latest Stories',
								'thumb_size' => 'latest-thumb',
								'post_class' => 'latest-stories',
								'numberposts' => $no_of_latest_stories,
								'bootstrap_class' => 'col-6 col-sm-6 col-md-12',
								'read_more' => true,
								'ad_id' => $ad_id,
								'ad_loop_offset' => 5
							] );
						echo '</div>';
					}


					// ===================================
					// Bottom latest stories advertisement
					// ===================================
					everstrap_homepage_content_section_ad();

					// ===================================
					// Viewpoints Posts
					// ===================================
					$home_page_category_post_one = everstrap_get_field( 'home_page_category_post_one', 'option' );

					if( $home_page_category_post_one ) {
						$home_page_category_post_one_id = $home_page_category_post_one[ 'select_category' ];
						$home_page_category_post_one_no = $home_page_category_post_one[ 'no_of_category_posts' ];

						echo '<div class="row article-wrapper">';
							echo evertstrap_conditional_posts(
								[
									'numberposts' => $home_page_category_post_one_no,
									'category' => $home_page_category_post_one_id,
									'title_text' => 'Viewpoints',
									'bootstrap_class' => 'col-sm-6 col-md-6',
									'post_class' => 'view-point',
									'thumb_size' => 'thumb-article',
									'show_excerpt' => false,
									'show_author' => false,
									'read_more' => true,
								]
							);
						echo '</div>';
					}


					// ===================================
					// Viewpoints bottom advertisement
					// ===================================
					everstrap_homepage_content_section_ad();

					// ===================================
					// Arts & Entertainment posts
					// ===================================
					$home_page_category_post_two = everstrap_get_field( 'home_page_category_post_two', 'option' );
					if( $home_page_category_post_two ) {

						$home_page_category_post_two_id = $home_page_category_post_two[ 'select_category' ];
						$home_page_category_post_two_no = $home_page_category_post_two[ 'no_of_category_posts' ];

						echo '<div class="row article-wrapper">';
							echo evertstrap_conditional_posts(
								[
									'numberposts' => $home_page_category_post_two_no,
									'category' => $home_page_category_post_two_id,
									'title_text' => 'Arts & Entertainment',
									'bootstrap_class' => 'col-sm-6 col-md-6',
									'post_class' => 'view-point',
									'thumb_size' => 'thumb-article',
									'show_excerpt' => false,
									'show_author' => false,
									'read_more' => true,
								]
							);
						echo '</div>';
					}

					// ===================================
					// Arts & Entertainment bottom advertisement
					// ===================================
					everstrap_homepage_content_section_ad();

					// ===================================
					// Real Estate post
					// ===================================					

                    $exclude = [];                 
                    $no_of_post = wp_count_posts( 'real-estate' ); ?>
                    <div class="home-real-state">
						<?php get_template_part( 'template-parts/real-estate-full-post' );
						get_template_part( 'template-parts/real-estate-short-post' ); ?>
                    </div>
                    <div class="author-load-more-post"></div>
                    <?php
                    // Load more posts of that user
                    $title = 'More Stories';
                    $class = 'button_two';
                    $args = array(
                        'posts_per_page' => 10,
                        'post_type' => 'real-estate',
                        'order' => 'DESC',
                        'post_status' => 'publish',                                
                        'offset' => 10,
                        'category' => 'real-estate',      
                        'category_name' => 'real-estate',
                        'template_name' => 'real-estate-thumb-post'
                    );
                    echo '<div class="author-load-more-post-btn-wrapper">';
                        apply_filters( 'everstrap_load_more_button', $args, $title, $class );
                    echo '</div>';                        
                    ?> 
				</main>
			</div>
			<?php get_sidebar( 'home-right-bottom' ); ?>
		</div><!-- .row -->

	</div><!-- #content -->
</div><!-- #index-wrapper -->
<?php
get_footer();
