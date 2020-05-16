<?php
    $id = $post->ID;
    $post_author_id = get_post_field( 'post_author', $id );

    $author_name = get_author_name( $post_author_id );

    $author_posts_url = get_author_posts_url($post_author_id);
?>
<div class="bk-directory-byline">
    <span>By <a href="<?php echo $author_posts_url; ?>" target="_blank"><?php echo $author_name; ?></a></span>
    <span><?php echo get_the_date('l, M y'); ?></span>
</div>