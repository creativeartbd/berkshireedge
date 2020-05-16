<?php
/**
 * The template for displaying the real estate post loop
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
					$exclude_to_load_more = [];
                    $no_of_post = wp_count_posts( 'real-estate' );                    
                    
                    get_template_part( 'template-parts/real-estate-full-post' );

                    get_template_part( 'template-parts/real-estate-short-post' );                               
                    ?>
                    <div class="author-load-more-post"></div>
                    <?php
                    // Load more posts of that user
                    if( isset( $GLOBALS['exclude_to_load_more'] ) ) {
                        $exclude_to_load_more = $GLOBALS['exclude_to_load_more'];
                    }                 

                    $title = 'More Stories';
                    $class = 'button_two';
                    $args = array(
                        'posts_per_page' => 10,
                        'post_type' => 'real-estate',
                        'order' => 'DESC',
                        'post_status' => 'publish',                                
                        'exclude' => $exclude_to_load_more,                        
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
                    unset( $GLOBALS['exclude_to_load_more'] );

                    echo '<div class="author-load-more-post-btn-wrapper">';
                        apply_filters( 'everstrap_load_more_button', $args, $title, $class );
                    echo '</div>';                        
                    ?>                    
                </main>
            </div> <!-- col-md end -->
            <?php get_sidebar( 'real-estate' ); ?>
        </div> <!-- wrapper end -->
    </div> <!-- container end -->

    <?php
    // ===================================
    // Footer Advertisement
    // ===================================
    if( is_active_sidebar('footer-ad') ) {
        echo '<div class="container" id="content" tabindex="-1">';
            echo '<div class="row">';
                dynamic_sidebar( 'footer-ad' );
            echo '</div>';
        echo '</div>';
    }
    ?>
</div> <!-- wrapper end -->

<?php
get_footer();
