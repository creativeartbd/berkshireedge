<?php
/**
 * Template Name: Blank Page Template
 *
 * Template for displaying a blank page.
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body>
	<?php
	$all_categories = get_categories();
	$category_needed = [];
	$counter = 1; // Because we want to show latest POST of 5 categories

	foreach ( $all_categories as $key => $category ) {
		$category_needed[] = $category->name;
		$counter++;
		if( 6 == $counter ) {
			break;
		}
	}

	//echo $category_needed = implode( ', ', $category_needed );

	$latest_posts = array();
	$exclude_post_ids = array(); // Added
	foreach ( $category_needed as $cat_id ){  // $category_ids is array of category ids
		$post_args = array(
			'post_type' => 'post',
			'numberposts' => 1,
			'category' => $cat_id,
			'exclude' => $exclude_post_ids, // Added
		);
		$latest_post_of_category = get_posts( $post_args );
		$latest_posts[] = $latest_post_of_category[0];
		$exclude_post_ids[] = $latest_post_of_category[0]->ID; // Added

		echo '<pre>';
		print_r( get_cat_name( $cat_id ) . $latest_post_of_category[0]->post_title );
		echo '</pre>';
	}
	?>
</body>
</html>
