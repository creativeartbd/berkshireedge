<div class="wrapper individual-directory-wrapper" id="individual-directory-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?php if ( is_single() ) {
					global $post;
					echo wdp_get_listing_page_url( $post->post_type );
				} else {
					echo get_the_permalink();
				} ?>" method="get" class="wdp-listing-form" id="wdp-listing-form">
					<?php

					if ( ! empty( get_query_var( 'post_type', '' ) ) ) {
						$post_type_object = get_post_type_object( get_query_var( 'post_type' ) );

						$title = $post_type_object->labels->name;
					} else {
						$title = get_the_title();
					} ?>
                    <div class="wdp-filter bk-indi-form-wrapper" style="visibility: visible;">

                        <div class="bk-indi-form" tabindex="0" role="button" aria-expanded="false"
                             style="visibility: visible;">
                            <div class="header-dropdown-wrap">
                                <div class="directory-search-bar">
                                    <h3 id="header-dropdown-opener"
                                        class="header-dropdown-title"><span><?php echo ucfirst( $title ); ?>
                                            <i class="fa fa-angle-down"></i></span></h3>
                                    <div class="header-dropdown">
                                        <h4 class="header-dropdown-subtitle">Search Our Directories:</h4>
										<?php
										wp_nav_menu( array(
											'theme_location' => 'directories-dropdown',
										) );
										?>
                                    </div>
                                </div>
                            </div>
							<?php
							$taxonomies = array();
							global $wp_taxonomies;

							foreach ( $wp_taxonomies as $taxonomy ) {
								if ( ! in_array( $listing_type, $taxonomy->object_type ) || 'yst_prominent_words' == $taxonomy->name ) {
									continue;
								}

								$taxonomies[ $taxonomy->name ] = $taxonomy;
							}


							$taxonomies = apply_filters( 'wdp_listing_filters', $taxonomies, $listing_type );
							$taxonomies = array_slice( $taxonomies, 0, 1 );

							foreach ( $taxonomies as $key => $taxonomy ) {

								$terms = get_terms( $taxonomy->name, apply_filters( 'wdp_listing_taxonomy_terms', array(
									'hide_empty' => true,
								), $taxonomy->name, $listing_type ) );

								if ( empty( $terms ) ) {
									continue;
								}
								?>
                                <select name="<?php echo sanitize_key( $taxonomy->name ); ?>[]"
                                        id="<?php echo sanitize_key( $taxonomy->name ); ?>" class=""
                                        multiple="multiple" data-label="<?php echo esc_html( $taxonomy->label ); ?>">
									<?php foreach ( $terms as $term ) {

										if ( in_array( $key, array(
											'medical_award',
											'dental_award',
											'lawyer_award'
										) ) ) {
											if ( ! preg_match( apply_filters( 'wdp_award_taxonomy_term_filter_regex', '/^(\d{4}) top (.*)/i' ), $term->name ) ) {
												continue;
											}

											$term->name = apply_filters( 'wdp_award_taxonomy_term', $term->name );

										}

										?>
                                        <option value="<?php echo $term->slug; ?>" <?php echo ! empty( $_GET[ $taxonomy->name ] ) && is_array( $_GET[ $taxonomy->name ] ) && in_array( $term->slug, $_GET[ $taxonomy->name ] ) ? ' selected="selected" ' : ''; ?>><?php echo esc_html( $term->name ); ?></option>
									<?php } ?>
                                </select>

							<?php } ?>
                            <input name="address" class="wdp-search wdp-address-search" type="text"
                                   placeholder="Address, City, Zip"
                                   value="<?php echo empty( $_GET[ 'address' ] ) ? '' : $_GET[ 'address' ]; ?>">
                            <input name="keyword" class="wdp-search" type="text" placeholder="Keyword Search"
                                   value="<?php echo empty( $_GET[ 'keyword' ] ) ? '' : $_GET[ 'keyword' ]; ?>">


							<?php //wp_nonce_field( 'wdp_list_listing' ); ?>
                            <input type="hidden" name="listing_type" value="<?php echo $listing_type; ?>">
                            <input type="hidden" name="paged" value="1"> <input type="submit" value="Filter">
							<?php if ( ! empty( $_GET ) & count( $_GET ) > 1 ): ?>
                                <a href="<?php echo get_the_permalink(); ?>" class="wdp-reset-filter">Reset</a>
							<?php endif; ?>

                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>