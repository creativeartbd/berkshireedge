<?php
$website = get_post_meta(get_the_ID(), '_website', true );
if(!empty($website)):?>
<p><a href="<?php echo esc_url( $website );?>" target="_blank">Official Website</a></p>
<?php
endif;
