<?php
$sponsored = wdp_is_sponsored( $post->ID ) ? 'sponsored' : ''; ?>
<?php $pinned = isset( $post->pinned ) && $post->pinned; ?>
<?php $post_type_object = get_post_type_object( $post->post_type ); ?>

<?php global $counter, $listing_taxonomies ?>

<?php $primary_taxonomy = wp_list_filter( $listing_taxonomies, [ 'primary' => true ] ); ?>
<div class="bk-sponsor-content<?php echo $pinned ? ' bk-directory-sponsored' : ' moffly-sponsor-white-bg'; ?>" data-postid="<?php echo $post->ID; ?>">
    
    <?php if ( has_post_thumbnail( $post ) ): ?>
        <a href="<?php echo get_the_permalink( $post ); ?>" class="bk-listing-image"><?php echo get_the_post_thumbnail( $post, 'directory-search-result-thumb' ); ?></a>
    <?php endif; ?>

    <div class="bk-sponsor-right">
        <div class="bk-directory-category">
            <?php
                $category = '';
                $post_terms = get_the_terms( $post->ID, 'wedding_category' );
                $category = $post_terms[0]->name;

                $term_id = $post_terms[0]->term_id;
                
            ?>
            <a href="<?php echo esc_url( get_term_link($term_id, 'wedding_category') ); ?>"><span><?php echo $category; ?></span></a>
            <?php if ( $pinned ) { ?>
            <span class="sponsored-dir">Sponsored Content</span>
            <?php } ?>
        </div>

        <div class="bk-sponsor-name">
            <a href="<?php echo get_the_permalink( $post ); ?>">
                <?php echo get_the_title( $post ); ?>
            </a>
        </div>
        <?php
            if( has_excerpt( $post->ID ) ) {
                $content = get_the_excerpt( $post );
            }else {
                $content = get_the_content( $post );
            }
            echo wpautop( wp_trim_words( $content, 30, null) );
            
        ?>
    </div>
</div>

<?php if ( $counter > 1 && $counter % 7 == 0 && is_active_sidebar( 'directory-listings-ponsored' ) ) {
	?>
    <div class="bk-sponsor-content moffly-sponsor-white-bg text-center">
        <div class="home-bottom-ponsored-module">
			<?php dynamic_sidebar( 'directory-listings-ponsored' ); ?>
        </div>
    </div>
	<?php
} ?>
