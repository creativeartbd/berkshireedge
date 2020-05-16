<?php
/**
 * The template for displaying the real estate thumb article post
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package everstrap
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class( 'horizental-post' ); ?> id="post-<?php the_ID(); ?>">

	<?php if ( $thumb = everstrap_post_main_photo( get_the_ID(), 'latest-thumb' ) ) {
		echo $thumb;
	} elseif ( has_post_thumbnail() ) { ?>
		<div class="post-thumb">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'latest-thumb' ); ?>
			</a>
		</div> 
	<?php } ?>	
	
	<header class="post-meta">

		<div class="post-category">
			<?php  
			$term  = get_queried_object(); 
			if( $term ) {
				echo '<a href="' . get_term_link( $term->term_id ) . '"> ' . $term->name . '</a>';	
			}

			// Because on load more the variable called $term is not return anything :(			
			$requested_category_name = isset( $_REQUEST['category_name'] ) ? $_REQUEST['category_name'] : '';
			if( $requested_category_name ) {
				$requested_category_name = get_category_by_slug( $requested_category_name );
				echo '<a href="' . get_term_link( $requested_category_name->term_id ) . '"> ' . $requested_category_name->name . '</a>';	
			}
			?>	
		</div>

		<?php
		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
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
