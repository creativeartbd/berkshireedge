<?php global $post; ?>
<?php $post_type_object = get_post_type_object( $post->post_type ); ?>

	<?php wdp_get_template( 'listing-filter.php', [ 'post' => $post, 'listing_type' => $post->post_type ] ); ?>

	<?php
	$show_on_mobile = apply_filters( 'wdp_single_listing_map_on_mobile', ( ! wp_is_mobile() ) );
	if ( $show_on_mobile ) {
		wdp_get_template( 'single/map.php' );
	}
	?>


    <div class="bk-directories-single-content-wrapper">
        <div class="container">
            <div class="row">
                <div class="bk-directory-single-left col-md-8 col-sm-12">
					<?php wdp_get_template( 'single/thumbnail.php', [ 'post' => $post ] ); ?>

					<?php if ( moffly_is_top_listing( $post ) ) { ?>
                        <br>
                        <div class="directory-btn text-uppercase">Top <?php echo $post_type_object->labels->singular_name; ?></div>
					<?php } ?>
					<?php wdp_get_template( 'single/taxonomy-section.php', [ 'post' => $post ] ); ?>
					<?php wdp_get_template( 'single/title.php', [ 'post' => $post ] ); ?>
                    <?php wdp_get_template( 'single/byline.php', [ 'post' => $post ] ); ?>
					<?php wdp_get_template( 'single/social-icons.php', [ 'post' => $post ] ); ?>
					<?php //wdp_get_template( 'single/website.php', [ 'post' => $post ] ); ?>
					<?php wdp_get_template( 'single/content-content.php', [ 'post' => $post ] ); ?>
					<?php wdp_get_template( 'single/social-icons.php', [ 'post' => $post ] ); ?>
					<?php do_action( 'wdp_singling_listing_after_content', $post ); ?>

				</div>

                <div class="moffly-directory-single-right col-md-4 col-sm-12">
                    <div class="directory-locations">
						<?php wdp_get_template( 'single/aside.php', [ 'post' => $post ] ); ?>
						<?php 
						if( is_active_sidebar( 'wedding-sidebar' ) ) {
        					dynamic_sidebar( 'wedding-sidebar' );
    					}; 
    					?>
                    </div>
                </div>
			</div>
		</div>
	</div>

    

<?php do_action( 'wdp_single_listing_end', $post ); ?>
