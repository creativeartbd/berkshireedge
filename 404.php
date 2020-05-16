<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="wrapper" id="error-404-wrapper">
	<div class="container" id="content" tabindex="-1">
		<div class="row">
			<div class="col-md-12 content-area" id="primary">
				<main class="site-main" id="main">
					<section class="error-404 not-found text-center h-100">

						<?php  
						$not_found_img = get_template_directory_uri() . '/assets/images/404.jpg';						
						?>
						
						<img src="<?php echo $not_found_img; ?>">
						<header class="page-header">
							<!--<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'everstrap' ); ?></h1>-->
						</header><!-- .page-header -->

						<div class="page-content pb-5">
							<h3 class="mb-4"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'everstrap' ); ?></h3>
							<div class="row">
								<div class="col-md-6 offset-md-3">
									<?php get_search_form(); ?>
								</div>
							</div>
						</div><!-- .page-content -->
					</section><!-- .error-404 -->
				</main><!-- #main -->
			</div><!-- #primary -->

			
		</div><!-- .row -->
	</div><!-- #content -->
</div><!-- #error-404-wrapper -->

<?php
get_footer();
