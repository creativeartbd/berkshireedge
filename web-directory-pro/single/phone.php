<?php
global $post;

$post_id = !empty($_REQUEST['child_id']) ? intval($_REQUEST['child_id']) : $post->ID;

$phone = get_post_meta( $post_id, '_phone', true );
$fax   = get_post_meta( $post_id, '_fax', true );

if ( ! empty( $phone ) ) { ?>
    <span>P:</span> <?php echo $phone ?>
<?php }

if ( ! empty( $phone ) && ! empty( $fax ) ) { ?>
    <br>
<?php }

if ( ! empty( $fax ) ) { ?>
    <span>F:</span> <?php echo $fax ?>
<?php }
