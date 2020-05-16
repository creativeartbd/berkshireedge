<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>

<div class="wrapper" id="page-wrapper">
	<div class="container" id="content" tabindex="-1">
		<div class="row">
            <div class="col-md content-area mobile-padding" id="primary">
                <main class="site-main" id="main">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        ?>

                        <?php get_template_part( 'loop-templates/content', 'page' ); ?>

                        <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        //if ( comments_open() || get_comments_number() ) :
                           // comments_template();
                        //endif;
                        ?>
                    <?php endwhile; // end of the loop. ?>
                </main><!-- #main -->
            </div>
            <?php get_sidebar( 'right-top' ); ?>
		</div><!-- .row -->
	</div><!-- #content -->
</div><!-- #page-wrapper -->

<?php
get_footer();
