<?php
/**
 * The template for displaying the single post
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package everstrap
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class( 'single-post' ); ?> id="post-<?php the_ID(); ?>">

	<?php
	if ( $thumb = everstrap_post_main_photo( get_the_ID(), 'full-article' ) ) {
		echo $thumb;
		if ( get_field( 'caption' ) ) { ?>
            <span class="thumb-caption"><?php the_field( 'caption' ); ?></span>
		<?php }
	} elseif ( has_post_thumbnail() ) { ?>
        <div class="post-thumbnail">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'full-article' ); ?>
            </a>
			<?php
			if ( get_the_post_thumbnail_caption() ) {
				echo '<div class="thumb-caption">';
				echo get_the_post_thumbnail_caption();
				echo '</div>';
			}
			?>
        </div>
	<?php } ?>

    <header class="entry-header">
		<?php
		everstrap_post_categories();

		the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );

		if ( has_excerpt() ) {
		    echo sprintf( '<p class="post-subtitle">%s</p>', esc_html( get_the_excerpt() ) );
        }
		?>

        <div class="entry-meta">
			<?php everstrap_posted_on(); ?>
        </div>

		<?php everstrap_post_social_share( get_the_ID(), [ 'twitter', 'facebook', 'print', 'envelope', 'link' ] ); ?>

    </header><!-- .entry-header -->

    <div class="entry-content">
		<?php the_content(); ?>
    </div>

    <div class="single-post-subscribe-now">
		<?php
		if ( is_active_sidebar( 'home-page-subscribe-now' ) ) {
			dynamic_sidebar( 'home-page-subscribe-now' );
		}
		?>
    </div>

    <div class="mt-1">
		<?php everstrap_post_social_share( get_the_ID(), [ 'twitter', 'facebook', 'print', 'envelope', 'link' ] ); ?>
    </div>

    <?php $author_id = get_the_author_meta( 'ID' ); ?>

    <div class="post-author-wrapper">
        <div class="post-author-thumb">
			<?php everstrap_author_image( $author_id ); ?>
        </div>
        <div class="post-author-content">
            <h2><a href="<?php echo get_author_posts_url( $author_id ); ?>"><?php echo get_the_author(); ?></a>
            </h2>
            <p><?php echo get_the_author_meta( 'description' ); ?></p>
        </div>
    </div>

    <div class="post-comment-wrapper">
        <div class="post-comment-btn">
			<?php echo do_shortcode( '[disqus_comment post_id="' . get_the_ID() . '"]' ) ?>
        </div>
    </div>

	<?php
	if ( is_active_sidebar( 'single-post-ad' ) ) {
		dynamic_sidebar( 'single-post-ad' );
	}
	?>
</article><!-- #post-## -->
