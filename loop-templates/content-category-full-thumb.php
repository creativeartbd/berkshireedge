<?php
/**
 * The template for displaying the category full thumb post
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package everstrap
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class( 'full-post' ); ?> id="post-<?php the_ID(); ?>">		
	<div class="category-top-title">
		<h2>
			<?php  
			$term  = get_queried_object(); 
			echo '<a href="' . get_term_link( $term->term_id ) . '"> ' . $term->name . '</a>';			
			?>			
		</h2>
	</div>
	<?php if ( $thumb = everstrap_post_main_photo( get_the_ID(), 'full-category' ) ) {
		echo $thumb;
		if ( get_field( 'caption' ) ) { ?>
            <span class="thumb-caption"><?php the_field( 'caption' ); ?></span>
		<?php }
	} elseif ( has_post_thumbnail() ) { ?>
        <div class="post-thumb">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'full-category' ); ?>
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

	<header class="post-meta">
		<?php
		the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
		?>		

		<div class="entry-content">
			<p>
				<?php echo get_the_excerpt(); ?>
			</p>
		</div>		

		<div class="post-author">
			<?php  
			$first_name = get_the_author_meta('first_name');
			$last_name = get_the_author_meta('last_name');
			$author_post_url = get_author_posts_url( get_the_author_meta( 'ID' ) );

			if( $first_name || $last_name ) {
				echo 'By ' . '<a href="'.$author_post_url.'">';
				echo $first_name;
				echo ' ';
				echo $last_name;
				echo '</a>';
			}
			?>			
		</div>
	</header><!-- .entry-header -->
</article><!-- #post-## -->
