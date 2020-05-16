<?php
/**
 * The template for displaying archive pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$exclude = [];
?>

<div class="wrapper" id="archive-wrapper">

	<div class="container" id="content" tabindex="-1">

		<div class="row">

            <div class="col-md content-area mobile-padding" id="primary">

                <main class="site-main" id="main">

                    <?php if ( have_posts() ) : ?>

                        <header class="page-header">
                            <?php
                            the_archive_title( '<h1 class="page-title">', '</h1>' );
                            the_archive_description( '<div class="taxonomy-description">', '</div>' );
                            ?>
                        </header><!-- .page-header -->

                        <?php /* Start the Loop */ ?>
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>

                            <?php

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'loop-templates/content', get_post_format() );

                            array_push( $exclude, get_the_ID() );
                            ?>

                        <?php endwhile; ?>

                        <?php

                        if ( is_category() ) {

                            $term  = get_queried_object();
                            $title = 'Load More Posts';
                            $class = 'load-more-custom-class';

                            $args = array(
                                'posts_per_page' => 5,
                                'order'          => 'DESC',
                                'post_type'      => 'post',
                                'category_name'  => $term->slug,
                                'exclude'        => $exclude,
                                'post_status'    => 'publish',
                            );

                            apply_filters( 'everstrap_load_more_button', $args, $title );
                        }

                        ?>

                    <?php else : ?>

                        <?php get_template_part( 'loop-templates/content', 'none' ); ?>

                    <?php endif; ?>

                </main><!-- #main -->

                <!-- The pagination component -->
                <?php everstrap_pagination(); ?>

            </div>

            <?php get_sidebar(); ?>

		</div> <!-- .row -->

	</div><!-- #content -->

	</div><!-- #archive-wrapper -->

<?php
get_footer();
