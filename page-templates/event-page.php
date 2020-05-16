<?php
/**
 * Template Name: Events Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published
 *
 * @package themeplate
 */

get_header(); ?>

<div class="wrapper" id="page-wrapper">

    <div  id="content" class="container">

        <div class="row row-flex">

			<div id="primary" class="<?php if ( is_active_sidebar( 'right-top-sidebar' ) ) : ?>col-md-8<?php else : ?>col-md-12<?php endif; ?> content-area">

                <main id="main" class="site-main" role="main">

                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php the_content(); ?>

                    <?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

    	    </div><!-- #primary -->

			<?php get_sidebar( 'right-top' ); ?>

        </div><!-- .row -->

    </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
