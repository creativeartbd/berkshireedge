<article <?php post_class( 'single-post' ); ?> id="post-<?php the_ID(); ?>">
	<div class="category-top-title">
		<?php
		if( is_front_page() ) {
			echo '<div class="main-heading-title"><h2>Real Estate</h2></div>';
		} else {
			$terms = get_the_terms( get_the_ID(), 're-category' );
			$category_name .= ''; 
			foreach ( $terms as $term ) {						
				$category_id = get_term_link( $term->term_id );						
				$category_name .= '<a href="'.$category_id.'">';
					$category_name .= $term->name;
				$category_name .= '</a>';
				break;
			}
			echo '<div class="post-category">';
				echo $category_name;
			echo '</div>';	
		}
		
		?>
	</div>
</article>