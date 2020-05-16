<?php $paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;?>
<div class="moffly-pageof">
    <span><?php echo sprintf( 'Page <strong>%d</strong> of <strong>%d</strong>', $paged, $listing_query->max_num_pages ); ?></span>
</div>

<div class="moffly-page-counter pagination">
    <?php wdp_get_template( 'pagination.php', array( 'max_page' => $listing_query->max_num_pages, 'range' => 2 ) ); ?>
</div>