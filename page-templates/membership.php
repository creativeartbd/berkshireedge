<?php
/**
 * Template Name: Membership
 * The template for displaying membership content
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
                <div class="col-md content-area mobile-padding" id="primary">
                    <main class="site-main membership" id="main">
                        <?php  
                        if( have_posts() ) {
                            while ( have_posts() ) {
                                the_post();
                                the_content();
                            }                           
                        }

                        if( is_active_sidebar( 'footer-ad') ) {
                            dynamic_sidebar( 'footer-ad' );
                        }
                        ?>
                    </main><!-- #main -->
                </div>                
            </div><!-- .row -->
        </div><!-- #content -->
    </div><!-- #single-wrapper -->
<?php
get_footer();
