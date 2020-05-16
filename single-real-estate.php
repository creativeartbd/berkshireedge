<?php
/**
 * The template for displaying the real estate posts
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="wrapper" id="index-wrapper">
    <div class="container" id="content" tabindex="-1">
        <div class="row">
            <div class="col-md-8 content-area mobile-padding" id="primary">
                <main class="site-main" id="main">                    
                   <?php 
                   $exclude_to_load_more = '';
                   while ( have_posts() ) : the_post(); ?>
                        <?php $exclude_to_load_more .= get_the_ID(); ?>
                        <?php get_template_part( 'loop-templates/content', 'single-real-estate' ); ?>
                    <?php endwhile; // end of the loop. ?>       

                    <div class="author-load-more-post"></div>
                    <?php
                    // Load more posts of that user
                    $title = 'More In Real Estate';
                    $class = 'button_two';
                   
                    $args = array(
                        'posts_per_page' => 5,
                        'post_type' => 'real-estate',
                        'order' => 'DESC',
                        'post_status' => 'publish',                            
                        'exclude' => [ $exclude_to_load_more ],
                        'template_name' => 'real-estate-thumb-post',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 're-category',
                                'field' => 'slug',
                                'terms' => [ 'property-of-the-week' ],
                                'operator' => 'NOT IN',
                            )
                        )  
                    );

                    echo '<div class="author-load-more-post-btn-wrapper">';
                        apply_filters( 'everstrap_load_more_button', $args, $title, $class );
                    echo '</div>'; 
                    ?>  
                </main>
            </div>
            <?php get_sidebar( 'real-estate' );  ?>
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

    <?php
    // ===================================
    // Footer Advertisement
    // ===================================
    if( is_active_sidebar('footer-ad') ) {
        echo '<div class="container" id="content" tabindex="-1">';            
            dynamic_sidebar( 'footer-ad' );            
        echo '</div>';
    }
    ?>

</div>

<?php
get_footer();
