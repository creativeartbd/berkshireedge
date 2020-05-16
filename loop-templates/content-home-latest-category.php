<?php
/**
 * This template is for display home page latest cotegories posts
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$category_counter = '';
$post_class = 'thumb-post';
$thumb_size =  'thumb-article';
$col = 6;
$post_excerpt = '';
$author_post_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
$post_by = 'by ' . get_the_author_meta( 'nickname' );

// We need grab the first post to make it full width
if( isset( $GLOBALS['category_counter'] ) && $GLOBALS['category_counter'] == 1 ) {
	$category_counter = $GLOBALS['category_counter'];
	$post_excerpt = wp_trim_words( get_the_excerpt(), 16 );
	$thumb_size =  'full-article';
	$post_class = 'full-post';
	$col = 12;

}

// Get the post categories
$post_category = get_the_category();
if( $post_category ) {
	$post_category = get_the_category();
	$post_category_link =  get_term_link( $post_category[0]->term_id );
	$post_category = $post_category[0]->name;
} else {
	$post_category = '';
}
?>


<div class="<?php echo 'col-'.$col . ' ' . 'col-sm-'.$col. ' ' . 'col-md-'.$col; ?> ">
	<article <?php echo post_class( $post_class ); ?> >
		<div class="post-thumb">
			<a href="<?php echo get_the_permalink(); ?>">
				<?php echo get_the_post_thumbnail( get_the_ID(), $thumb_size ); ?>
			</a>
		</div>
		<div class="post-meta">
			<!--  post category-->
			<?php
			if( $post_category ) {
				echo '<span>';
					echo "<a href='{$post_category_link}'>";
						echo $post_category;
					echo '</a>';
				echo '</span>';
			}
			?>

			<!--  post title -->
			<a href="<?php echo get_the_permalink(); ?>">
				<h1><?php echo get_the_title(); ?></h1>
			</a>

			<!--  post excerpt only for the first post -->
			<?php
			if( $post_excerpt ) {
				echo '<p>';
					echo $post_excerpt;
				echo '<p>';
			}
			?>

			<!--  post author -->
			<div class="post-author">
				<a href="<?php echo $author_post_url; ?>">
					<?php echo $post_by; ?>
				</a>
			</div>


		</div>
	</article>
</div>

