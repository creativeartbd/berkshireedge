<?php if ( has_post_thumbnail( $post ) ): ?>
	<?php echo get_the_post_thumbnail( $post, 'full-article' ); ?>
	<br>
	<div class="bk-directory-thumb-caption">
		<p><?php echo get_the_post_thumbnail_caption($post->ID); ?></p>
	</div>
<?php endif; ?>