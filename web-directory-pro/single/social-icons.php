<?php
$social_icons = array();
$facebook = get_post_meta(get_the_ID(), '_facebook', true );
$twitter = get_post_meta(get_the_ID(), '_twitter', true );
$youtube = get_post_meta(get_the_ID(), '_youtube', true );
$instagram = get_post_meta(get_the_ID(), '_instagram', true );
if(!empty($facebook)){
    $social_icons['facebook'] = $facebook;
}
if(!empty($twitter)){
	$social_icons['twitter'] = $twitter;
}

if(!empty($youtube)){
	$social_icons['youtube'] = $youtube;
}
if(!empty($instagram)){
	$social_icons['instagram'] = $instagram;
}
if ( ! empty( $social_icons ) ):
	?>
    <div class="directory-social">
		<?php foreach ( $social_icons as $site => $url ): ?>
            <a href="<?php echo esc_url( $url ); ?>"><i class="fa fa-<?php echo sanitize_key( $site ); ?>"></i></a>
		<?php endforeach; ?>
    </div>
<?php endif;
