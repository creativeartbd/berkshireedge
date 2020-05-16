<?php
/**
 * The template for displaying search results pages
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="wrapper" id="search-wrapper">
	<div class="container" id="content" tabindex="-1">
		<div class="row">
            <div class="col-md content-area mobile-padding" id="primary">
                <main class="site-main" id="main">
                    <div class="row">
                    <?php if ( have_posts() ) : ?>
                        <div class="col-md-12">
                            <header class="page-header">
                                <h1 class="page-title">
                                    <?php
                                    printf(
                                        /* translators: %s: query term */
                                        esc_html__( 'Search Results for: %s', 'everstrap' ),
                                        '<span>' . get_search_query() . '</span>'
                                    );
                                    ?>
                                </h1>
                                <hr>
                            </header><!-- .page-header -->
                        </div>
                        <?php /* Start the Loop */ ?>
                        
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <?php
                            /**
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part( 'loop-templates/content', 'search' );
                            ?>
                        <?php endwhile; ?>

                        <?php else : ?>
                            <?php get_template_part( 'loop-templates/content', 'none' ); ?>
                        <?php endif; ?>
                    </div>
                </main><!-- #main -->
                <!-- The pagination component -->
                <?php everstrap_pagination(); ?>
            </div>
            <?php get_sidebar( 'right-top' ); ?>
		</div><!-- .row -->
	</div><!-- #content -->
</div><!-- #search-wrapper -->

<?php
get_footer();
