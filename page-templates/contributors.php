<?php
/**
 * Template Name: Contributors
 * The template for displaying all authors
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
                    <main class="site-main" id="main">
                        <div class="row">
                            <?php 

                            // Pagination vars
                            $current_page = get_query_var('paged') ? (int) get_query_var('paged') : 1;
                            $users_per_page = 12; // RAISE THIS AFTER TESTING ;)

                            $args = array(
                                'number' => $users_per_page,
                                'paged' => $current_page,
                                'role' => 'contributor',
                            );

                            $users = new WP_User_Query( $args );

                            $total_users = $users->get_total(); // How many users we have in total (beyond the current page)
                            $num_pages = ceil($total_users / $users_per_page); // How many pages of users we will need
                         
                            if ( $users->get_results() ) {

                                foreach( $users->get_results() as $user )  {
                                    $author_thumb_url = get_avatar_url( $user->ID, [ 'size' => 97 ] );
                                    $author_description = get_the_author_meta( 'description', $user->ID );
                                    $first_author_description = substr( $author_description, 0, 185 );
                                    $more_author_description = substr( $author_description, 185 );

                                    echo '<div class="col-md-6">';
                                        echo '<div class="author-wrapper">';
                                            echo '<div class="author-thumb">';
                                                everstrap_author_image( $user->ID );
                                            echo '</div>';
                                            echo '<div class="author-description">';
                                                echo '<h2>'. $user->first_name . ' ' .  $user->last_name . '</h2>';
                                                 ?>
                                                    <span class="teaser"><?php echo $first_author_description; ?></span><span class="complete"><?php echo $more_author_description; ?></span><span class="more">+</span>
                                                 <?php    
                                                 echo '<br/>';
                                                echo '<a href="'.get_author_posts_url($user->ID).'" class="button_two">See Articles</a>';
                                            echo '</div>';    
                                        echo '</div>';
                                    echo '</div>';
                                }  
                            } 
                            ?>

                            
                            <!--<p>Displaying <?php echo $users_per_page; ?> of <?php echo $total_users; ?> users</p> -->
                           
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p>
                                <?php  
                                if ( $current_page > 1 ) {
                                    echo '<a href="'. add_query_arg(array('paged' => $current_page-1)) .'">Previous Page</a>';
                                }
                                ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <?php
                                if ( $current_page < $num_pages ) {
                                    echo '<a href="'. add_query_arg(array('paged' => $current_page+1)) .'">Next Page</a>';
                                }  
                                ?>
                                <p>Page <?php echo $current_page; ?> of <?php echo $num_pages; ?></p>
                            </div>    
                        </div>                        
                    </main><!-- #main -->
                </div>                
            </div><!-- .row -->
        </div><!-- #content -->
    </div><!-- #single-wrapper -->
<?php
get_footer();
