<?php
/**
 * The template for displaying all single posts
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
get_header();
?>
    <div class="wrapper" id="single-wrapper">
        <div class="container" id="content" tabindex="-1">
            <div class="row">
                <div class="col-md-8 content-area mobile-padding" id="primary">
                    <main class="site-main" id="main">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part( 'loop-templates/content', 'single' ); ?>
                        <?php endwhile; // end of the loop. ?>                                                
                        <?php apply_filters( 'everstrap_infinite_scroll_nav', get_the_ID() ); ?>
                    </main><!-- #main -->
                </div>
                <?php get_sidebar( 'right-top' ); ?>
            </div><!-- .row -->
        </div><!-- #content -->
    </div><!-- #single-wrapper -->
<?php
get_footer();
