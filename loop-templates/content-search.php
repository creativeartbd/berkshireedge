<?php
/**
 * Search results partial template
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<div class="col-6 col-sm-6 col-md-12">
	<article <?php post_class( 'horizental-post' ); ?> id="post-<?php the_ID(); ?>">
		<div class="post-thumb">
			<a href="<?php echo get_the_permalink(); ?>">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'latest-thumb'); ?>
			</a>
		</div>
		<div class="post-meta">
			<?php everstrap_post_categories(); ?>
			<a href="<?php echo get_the_permalink(); ?>">
				<h2><?php echo get_the_title(); ?></h2>
			</a>
			<p>
				<?php echo substr( get_the_excerpt(), 0, 200 ); ?>
			</p>
			<div class="post-author">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php echo get_the_author_meta('nickname'); ?>
				</a>
			</div>
		</div>

		<?php
		if( isset( $GLOBALS['author_post_counter'] ) && $GLOBALS['author_post_counter'] % 5 == 0 ) {
			// Advertisement
			if( is_active_sidebar( 'author-page-ad' ) ) {
				dynamic_sidebar( 'author-page-ad' );
			}
		}
		?>

	</article><!-- #post-## -->
</div>