<?php
$timing_disabled = wdp_get_settings( 'timing', 'on' );
$timings         = array(
	'Sunday'    => wdp_get_post_meta( $post->ID, '_sunday' ),
	'Monday'    => wdp_get_post_meta( $post->ID, '_monday' ),
	'Tuesday'   => wdp_get_post_meta( $post->ID, '_tuesday' ),
	'Wednesday' => wdp_get_post_meta( $post->ID, '_wednesday' ),
	'Thursday'  => wdp_get_post_meta( $post->ID, '_thursday' ),
	'Friday'    => wdp_get_post_meta( $post->ID, '_friday' ),
	'Saturday'  => wdp_get_post_meta( $post->ID, '_saturday' ),
);

if ( function_exists( 'get_field' ) ) {
	$insurances = get_field( 'insurance_accepted', $post->ID );
	$hospitals  = get_field( 'hospital_affiliation', $post->ID );
}
?>

<?php if ( ! empty( array_filter( $timings ) ) && $timing_disabled != 'on' ) { ?>
    <div class="directory-office-hour directory-right-down-item">
        <h5>Office Hours</h5>
		<?php foreach ( $timings as $day => $time ) {
			if ( empty( $time ) ) {
				$time = 'Closed';
			}
			echo sprintf( '<div class="directory-office-item"><h6>%s</h6><p>%s</p></div>', $day, $time );
		} ?>
    </div>
<?php } ?>

<?php if ( ! empty( $insurances ) ) { ?>
    <div class="directory-office-hour directory-right-down-item">
        <h5>Insurance Accepted</h5>
        <div class="directory-office-item">
			<?php foreach ( $insurances as $insurance ) {
				if ( isset( $insurance[ 'insurance_name' ] ) && $insurance[ 'insurance_name' ] ) {
					echo sprintf( '<p>%s</p>', $insurance[ 'insurance_name' ] );
				}
			} ?>
        </div>
    </div>
<?php } ?>

<?php if ( ! empty( $hospitals ) ) { ?>
    <div class="directory-office-hour directory-right-down-item">
        <h5>Hospital Affiliation</h5>
        <div class="directory-office-item">
			<?php foreach ( $hospitals as $hospital ) {
				if ( isset( $hospital[ 'hospital_name' ] ) && $hospital[ 'hospital_name' ] ) {
					echo sprintf( '<p>%s</p>', $hospital[ 'hospital_name' ] );
				}
			} ?>
        </div>
    </div>
<?php } ?>