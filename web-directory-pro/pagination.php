<?php
$paged = get_query_var( 'paged', 1 );
if ( $max_page > 1 ) {
	if ( ! $paged ) {
		$paged = 1;
	}

	// To the previous page
	previous_posts_link( '<span class="next-prev">< Prev</span>' );

//	if ( $max_page > $range + 1 ) :
//		if ( $paged >= $range ) {
//			echo '<a class="page-numbers" href="' . get_pagenum_link( 1 ) . '">1</a>';
//		}
//		if ( $paged >= ( $range + 1 ) ) {
//			echo '<span class="page-numbers">&hellip;</span>';
//		}
//	endif;

	// We need the sliding effect only if there are more pages than is the sliding range
	if ( $max_page > $range ) {
		// When closer to the beginning
		if ( $paged < $range ) {
			for ( $i = 1; $i <= ( $range + 1 ); $i ++ ) {
				echo ( $i != $paged ) ? '<a class="page-numbers" href="' . get_pagenum_link( $i ) . '">' . $i . '</a>' : '<span aria-current="page" class="page-numbers current">' . $i . '</span>';
			}
			// When closer to the end
		} elseif ( $paged >= ( $max_page - ceil( ( $range / 2 ) ) ) ) {
			for ( $i = $max_page - $range; $i <= $max_page; $i ++ ) {
				echo ( $i != $paged ) ? '<a class="page-numbers" href="' . get_pagenum_link( $i ) . '">' . $i . '</a>' : '<span aria-current="page" class="page-numbers current">' . $i . '</span>';
			}
			// Somewhere in the middle
		} elseif ( $paged >= $range && $paged < ( $max_page - ceil( ( $range / 2 ) ) ) ) {
			for ( $i = ( $paged - ceil( $range / 2 ) ); $i <= ( $paged + ceil( ( $range / 2 ) ) ); $i ++ ) {
				echo ( $i != $paged ) ? '<a class="page-numbers" href="' . get_pagenum_link( $i ) . '">' . $i . '</a>' : '<span aria-current="page" class="page-numbers current">' . $i . '</span>';
			}
		}
		// Less pages than the range, no sliding effect needed
	} else {
		for ( $i = 1; $i <= $max_page; $i ++ ) {
			echo ( $i != $paged ) ? '<a class="page-numbers" href="' . get_pagenum_link( $i ) . '">' . $i . '</a>' : '<span aria-current="page" class="page-numbers current">' . $i . '</span>';
		}
	}
	if ( $max_page > $range + 1 ) :
		// On the last page, don't put the Last page link
		if ( $paged <= $max_page - ( $range - 1 ) ) {
			echo '<span aria-current="page" class="page-numbers">&hellip;</span><a class="page-numbers" href="' . get_pagenum_link( $max_page ) . '">' . $max_page . '</a>';
		}
	endif;

	// Next page
	next_posts_link( '<span class="next-prev">Next ></span>', $max_page );
}