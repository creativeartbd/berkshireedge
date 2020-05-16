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
	<?php  
	$is_sponsored_post = everstrap_get_field( 'is_sponsored_post', get_the_ID() );
	if( $is_sponsored_post ) {
		echo '<div class="sponsored">sponsored content</div>';
	}	
	
	// if( isset( $GLOBALS['post_counter'] ) && 2 == $GLOBALS['post_counter'] ) {
	// 	echo '<div class="more-in-real-estate">';
	// 		echo '<h2>';
	// 			_e( 'More In Real Estate');
	// 		echo '</h2>';
	// 	echo '</div>';
	// }
	?>
	
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="post-thumb">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'latest-thumb' ); ?>
			</a>
			<?php 			
			if( get_the_post_thumbnail_caption() ) {				
				echo '<div class="thumb-caption">';
					echo get_the_post_thumbnail_caption();
				echo '</div>';
			}
			?>			
		</div> 
	<?php } ?>	
	
	<header class="post-meta">
		<?php
		$terms = get_the_terms( get_the_ID(), 're-category' );
		if( $terms ) {
			foreach ( $terms as $term ) {
				// if( 'property-of-the-week' == $term->slug ) {
					// echo '<div class="property-of-the-week">';
					// 	echo '<h3>Propery Of The Week</h3>';
					// echo '</div>';
					// break;
				//}			
				echo '<div class="post-category">';
					echo '<a href="'. get_term_link( $term->term_id ).'">';
						echo $term->name;
					echo '</a>';
				echo '</div>';
				break;
			}		
		}

		// $category = get_the_category();
		// if( $category ) {
		// 	if( isset($category[1]) ) {
		// 		$category = $category[1];
		// 	} else {
		// 		$category = $category[0];
		// 	}
			
		// 	$category_name = $category->name;
		// 	$category_slug = $category->slug;		
		// 	$category_id = $category->term_id;		
		// 	echo '<div class="post-category">';
		// 		echo '<a href="'. get_term_link( $category_id ).'">';
		// 			echo $category_name;
		// 		echo '</a>';
		// 	echo '</div>';	
		// }		

		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		?>

		<div class="entry-content">
			<p>
				<?php echo substr( get_the_excerpt(), 0, 100 ); ?>
			</p>
		</div>

		<div class="post-author">
			<?php echo get_the_date(); ?>
		</div>	

	</header><!-- .entry-header -->

</article><!-- #post-## -->
