<?php
/**
 * Template Name: Individual Directory
 */
get_header( 'directories' );

?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile;  ?>

<?php
get_footer();
?>
