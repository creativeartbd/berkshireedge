<?php
/**
 * Template Name: Current Members
 *
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
                        echo '<div class="edge-members">';
                            if( have_posts() ) {
                                while ( have_posts() ) {
                                    the_post();
                                    the_content();
                                }
                                // echo '<div class="edge-members">';
                                //     if( everstrap_get_member_by_role( 'community_advisor' ) ) {
                                //         echo '<h2>Advisors</h2>';
                                //         echo everstrap_get_member_by_role( 'community_advisor' );
                                //     }

                                //     if( everstrap_get_member_by_role( 'community_leader' ) ) {
                                //         echo '<h2>Leaders</h2>';
                                //         echo everstrap_get_member_by_role( 'community_leader' );
                                //     }

                                //     if( everstrap_get_member_by_role( 'community_member' ) ) {
                                //         echo '<p>Members</p>';
                                //         echo everstrap_get_member_by_role( 'community_member' );
                                //     }                                
                                // echo '</div>';
                            }
                        echo '</div>';

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
