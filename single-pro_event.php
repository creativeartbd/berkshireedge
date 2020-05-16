<?php
/**
 * The template for displaying the events posts
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();


$startdate = get_post_meta( get_the_ID(), 'startdate' );
$startdate = $startdate[0];

$enddate = get_post_meta( get_the_ID(), 'enddate' );
$enddate = $enddate[0];

$starttime = get_post_meta( get_the_ID(), 'starttime' );
$starttime = $starttime[0];

$endtime = get_post_meta( get_the_ID(), 'endtime' );
$endtime = $endtime[0];

$location = get_post_meta( get_the_ID(), 'location' );
$location = $location[0];

$url = get_post_meta( get_the_ID(), 'url' );
$url = $url[0];

$cost = get_post_meta( get_the_ID(), 'cost' );
$cost = $cost[0];

?>

<div class="wrapper bk-event-single-wrapper" id="index-wrapper">
    <div class="container" id="content" tabindex="-1">
        <div class="row">
            <div class="col-md-8">
                <?php
                    if ( have_posts() ) : 
                        while ( have_posts() ) : the_post();
                ?>
                <div class="bk-event-right-top">
                    <div class="bk-event-details-box">
                        <?php
                            if( !empty($startdate) && !empty($enddate) && !empty($starttime) && !empty($endtime) ) {
                        ?>
                            <h3><?php echo date( 'F d, Y', strtotime($startdate) ); ?> - <?php echo date( 'F d, Y', strtotime($enddate) ); ?> <span class="wpEve-pipeseparator">|</span> <?php echo $starttime; ?> - <?php echo $endtime; ?></h3>
                        <?php } ?>
                        <h1><?php echo get_the_title(); ?></h1>
                    </div>
                    
                    <?php
                        if( !empty($location) ) {
                    ?>
                    <div class="bk-event-details-address">
                        <h4><?php echo esc_html($location); ?></h4>
                    </div>
                    <?php } ?>

                    <div class="bk-event-featured-img">
                        <?php
                            $featured_img = get_the_post_thumbnail( get_the_ID(), 'event-featured-image' ); 
                        ?>
                        <?php echo !empty($featured_img) ? $featured_img : ''; ?>
                    </div>
                    
                    <div class="bik-event-content-wrapper">
                        <div class="bk-event-content">
                            <?php echo get_the_content( get_the_ID() ); ?>
                        </div>

                        <div class="bk-event-direction">
                            <h2><a href="javascript:void(0)" id="eevorg_show_map-6004" data-lat="42.2128544" data-lng="-73.34099179999998">DIRECTIONS &amp; MAP</a></h2>
                            <div class="bk-event-ticket">
                                <h3><?php echo esc_html('TICKETS:'); ?></h3>
                                <?php if ( $cost ) { ?>
                                    <p>$<?php echo $cost; ?> suggested donation</p>
                                <?php } ?>
                                <a href="<?php echo !empty($url) ? esc_url($url) : ''; ?>" class="wpEve-buy" target="_blank"><?php echo esc_html('Buy Tickets'); ?></a> 
                            </div>
                            <p><a href="<?php echo !empty($url) ? esc_url($url) : ''; ?>" target="_blank"><?php echo esc_html( 'Go to event website &gt;' ); ?></a></p>
                        </div>
                    </div>
                </div>
                <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                ?>

                <div class="bk-event-right-bottom">
                    <div class="bk-event-container">
                        <h1><?php echo esc_html('Upcoming Events'); ?></h1>
                        <?php
                            $today = getdate();
                            $args = array(
                              'posts_per_page' => 5,
                              'post_type' => 'pro_event',
                              'orderby' => 'date',
                              'date_query' => array(
                                  array(
                                    'year'  => $today['year'],
                                    'month' => $today['mon'],
                                    'day'   => $today['mday'],
                                  ),
                                ),
                              'post_status' => 'publish',
                              );

                            $upcoming_posts =  get_posts($args);

                            if( count($upcoming_posts) > 0 ) {
                                foreach( $upcoming_posts as $post ) {
                                    setup_postdata( $post );
                                    $id = $post->ID;

                                    $up_startdate = get_post_meta( $id, 'startdate' );
                                    $up_startdate = $up_startdate[0];

                                    $up_enddate = get_post_meta( $id, 'enddate' );
                                    $up_enddate = $up_enddate[0];

                                    $up_starttime = get_post_meta( $id, 'starttime' );
                                    $up_starttime = $up_starttime[0];

                                    $up_endtime = get_post_meta( $id, 'endtime' );
                                    $up_endtime = $up_endtime[0];

                                    $up_location = get_post_meta( $id, 'location' );
                                    $up_location = $up_location[0];
                        ?>
                        <div class="bk-upcoming-event-item">
                            <?php
                                $featured_img = get_the_post_thumbnail( $id, 'event-small' );
                                if( !empty($featured_img) )  {
                                ?>
                                <div class="bk-upcoming-event-img">
                                    <a href="#"><?php echo $featured_img; ?></a>
                                </div>
                                <?php 
                            } 
                            ?>
                            <div class="bk-upcoming-event-text">
                                <h2><a href="<?php echo get_the_permalink( $id ); ?>"><?php echo get_the_title($id); ?></a></h2>
                                <?php
                                    if( !empty($up_startdate) && !empty($up_enddate) && !empty($up_starttime) && !empty($up_endtime) ) {
                                    ?>
                                    <h3><?php echo date( 'F d, Y', strtotime($up_startdate) ); ?> - <?php echo date( 'F d, Y', strtotime($up_enddate) ); ?> <span class="wpEve-pipeseparator">|</span> <?php echo $up_starttime; ?> - <?php echo $up_endtime; ?></h3>
                                    <?php 
                                    } 
                                ?>
                                <h4>Berkshire South Regional Community Center</h4>
                                <?php $more_link = '<a href="'.get_the_permalink( $id).'"> More</a>'; ?>
                                <?php echo wpautop( wp_trim_words( get_the_content($id), 25, $more_link ) ); ?>
                            </div>
                        </div>
                        <?php
                                }
                                wp_reset_postdata();
                            }
                        ?>
                    </div>
                </div>
            </div>
            

            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php
get_footer();