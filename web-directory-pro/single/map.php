<?php

$post_id = ! empty( $_REQUEST['child_id'] ) ? intval( $_REQUEST['child_id'] ) : get_the_ID();

$lat = get_post_meta( $post_id, '_latitude', true );
$lon = get_post_meta( $post_id, '_longitude', true );

if ( ! empty( $lat ) ) { ?>

	<div class="moffly-single-map">
		<div id="gmap" style="height: 400px;width: 100%;"></div>
		<?php
		$locations = array();

		if ( empty( $lat ) || ! stristr( $lat, '.' ) || empty( $lon ) || ! stristr( $lat, '.' ) ) {
		} else {
			$html  = '<div class="wdp-map-marker-content">';
			$html  .= '<a class="wdp-marker-title" href="' . get_the_permalink( get_the_ID() ) . '"><strong>';
			$html  .= get_the_title( get_the_ID() );
			$html  .= '</strong></a>';
			$html  .= sprintf('<p>%s</p>', wdp_get_address( $post_id ));
			$phone = get_post_meta( $post_id, '_phone', true );
			if ( ! empty( $phone ) ) {
				$html .= '<p><a href="tel:' . $phone . '">' . $phone . '</a></p>';
			}
			$html        .= '</div>';
			$locations[] = array(
				'lat'        => $lat,
				'lon'        => $lon,
				'title'      => get_the_title( $post_id ),
				'html'       => $html,
				'zIndex'     => 1,
				'listing_id' => $post_id,
				'icon'       => array(
					'url' => apply_filters( 'wdp_map_marker_url', WPWDP_ASSETS_URL . '/images/icons/marker.svg' ),
				),
				'label'      => array(
					'text'     => "1",
					'color'    => "white",
					'fontSize' => "10px"
				)
			);
		}

		?>
		<?php $map_zoom = wdp_get_settings( 'zoom' ); ?>
		<script>
			window.mapZoom = <?php echo( ! empty( $map_zoom ) ? $map_zoom : 10 ); ?>;
			window.wdp_locations = <?php echo json_encode( $locations );?>;
		</script>
	</div>
<?php } ?>
