<?php
/**
 * The template for displaying the real estate full article post
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
		<?php  
		$terms = get_the_terms( get_the_ID(), 're-category' );
		$category_name .= ''; 
		foreach ( $terms as $term ) {						
			$category_id = get_term_link( $term->term_id );						
			$category_name .= '<a href="'.$category_id.'">';
				$category_name .= $term->name;
			$category_name .= '</a>';
			break;
		}
		// echo '<div class="post-category">';
		// 	echo $category_name;
		// echo '</div>';
		?>
	</div>
	<?php  
	$is_sponsored_post = everstrap_get_field( 'is_sponsored_post', get_the_ID() );
	if( $is_sponsored_post ) {
		echo '<div class="sponsored">sponsored content</div>';
	}
	?>
	
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-thumb">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'full-article' ); ?>
			</a>
			<?php 			
			if( ! is_front_page() && get_the_post_thumbnail_caption() ) {
				echo '<div class="thumb-caption">';
					echo get_the_post_thumbnail_caption();
				echo '</div>';
			}
			?>			
		</div> 
	<?php } ?>
	
	<header class="post-meta">
		<?php
		echo '<span>';
			echo $category_name;
		echo '</span>';		
		
		the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );

		$excerpt = get_the_excerpt();
		echo '<p>' . substr( $excerpt, 0, 100 ) . '</p>';
		?>
		
		<div class="post-author">
			<?php echo get_the_date(); ?>
		</div>

	</header><!-- .entry-header -->
</article><!-- #post-## -->
