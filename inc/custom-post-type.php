<?php
/**
 * Theme functions and definitions
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function cptui_register_my_cpts() {

	/**
	 * Post Type: Real Estate.
	 */

	$labels = [
		"name" => __( "Real Estate", "everstrap" ),
		"singular_name" => __( "Real Estate", "everstrap" ),
	];

	$args = [
		"label"                 => __( "Real Estate", "everstrap" ),
		"labels"                => $labels,
		"description"           => "Add Reat Estate Items",
		"public"                => true,
		"publicly_queryable"    => true,
		"show_ui"               => true,
		"show_in_rest"          => true,
		"rest_base"             => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive"           => true,
		"show_in_menu"          => true,
		"show_in_nav_menus"     => true,
		"delete_with_user"      => false,
		"exclude_from_search"   => false,
		"capability_type"       => "post",
		"map_meta_cap"          => true,
		"hierarchical"          => false,
		"rewrite"               => [ "slug" => "real-estate", "with_front" => true ],
		"query_var"             => true,
		"supports"              => [
			"title",
			"editor",
			"thumbnail",
			"excerpt",
			"custom-fields",
			"comments",
			"page-attributes",
			"author"
		],
		"taxonomies"            => [ 're-category', 'category', 'post_tag' ]
	];

	register_post_type( "real-estate", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );


function cptui_register_my_taxes_real_estate_category() {

	/**
	 * Taxonomy: Real Estate Categories.
	 */

	$labels = [
		"name" => __( "Real Estate Categories", "everstrap" ),
		"singular_name" => __( "Real Estate Category", "everstrap" ),
	];

	$args = [
		"label" => __( "Real Estate Categories", "everstrap" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 're-category', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "real_estate_category",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		];
	register_taxonomy( "re-category", [ "real-estate" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_real_estate_category' );

