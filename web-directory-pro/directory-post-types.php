<?php
function wdp_moffly_register_post_types() {
	$args = array(
		'labels'             => moffly_get_post_labels( 'Top Doctors', 'Doctor', 'Doctors' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-category',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'top-doctors' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'top_doctor', $args );

	$args = array(
		'labels'             => moffly_get_post_labels( 'Weddings', 'Wedding', 'Weddings' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-category',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'wedding-directories' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'wedding_directory', $args );

	$args = array(
		'labels'             => moffly_get_post_labels( 'Top Lawyers', 'Lawyer', 'Lawyers' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-category',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'top-lawyers' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'top_lawyer', $args );

	$args = array(
		'labels'             => moffly_get_post_labels( 'Top Dentists', 'Dentist', 'Dentists' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-category',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'top-dentists' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'top_dentist', $args );

	$args = array(
		'labels'             => moffly_get_post_labels( 'Education Guides', 'Education Guide', 'Education Guides' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-category',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'education-guides' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'education_guide', $args );

	$args = array(
		'labels'             => moffly_get_post_labels( 'Restaurants', 'Restaurant', 'Restaurants' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-category',
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'restaurants' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'restaurant', $args );

}

add_action( 'init', 'wdp_moffly_register_post_types' );

function wdp_moffly_register_taxonomies() {

	/* doctor speciality */
	register_taxonomy( 'doctor_speciality', array( 'top_doctor' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Medical Specialities', 'Speciality', 'Medical Specialities' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'doctor-speciality',
		'query_var'         => true,
	) );

	/* doctor category */
	register_taxonomy( 'doctor_category', array( 'top_doctor' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Categories', 'Category', 'Categories' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'doctor-category',
		'query_var'         => true,
		'primary'           => true,
	) );

	/* doctor hospitals */
	register_taxonomy( 'doctor_hospital', array( 'top_doctor' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Hospitals', 'Hospital', 'Hospitals' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'doctor-hospitals',
		'query_var'         => true,
	) );

	/* doctor practice names */
	register_taxonomy( 'doctor_practice_name', array( 'top_doctor' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Practice Names', 'Practice Name', 'Practice Names' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'doctor-practice-names',
		'query_var'         => true,
	) );

	/* doctor expertise */
	register_taxonomy( 'doctor_expertise', array( 'top_doctor' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Expertise', 'Expertise', 'Expertise' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'doctor-expertise',
		'query_var'         => true,
	) );

	/* wedding categories */
	register_taxonomy( 'wedding_category', array( 'wedding_directory' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Categories', 'Category', 'Categories' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'wedding-category',
		'query_var'         => true,
	) );

	/* lawyer categories */
	register_taxonomy( 'lawyer_category', array( 'top_lawyer' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Categories', 'Category', 'Categories' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'lawyer-category',
		'query_var'         => true,
	) );

	/* lawyer practice area */
	register_taxonomy( 'lawyer_practice_area', array( 'top_lawyer' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Practice Areas', 'Practice Area', 'Practice Areas' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'lawyer-practice-area',
		'query_var'         => true,
	) );

	/* lawyer firm */
	register_taxonomy( 'lawyer_firm', array( 'top_lawyer' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Firms', 'Firm', 'Firms' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'lawyer-firm',
		'query_var'         => true,
	) );

	/* dentist category */
	register_taxonomy( 'dentist_category', array( 'top_dentist' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Categories', 'Category', 'Categories' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'dentist-category',
		'query_var'         => true,
		'primary'           => true,
	) );

	/* dentist speciality */
	register_taxonomy( 'dentist_speciality', array( 'top_dentist' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Specialities', 'Speciality', 'Specialities' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'dentist-speciality',
		'query_var'         => true,
	) );

	/* education grade */
	register_taxonomy( 'education_grade', array( 'education_guide' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Grades', 'Grade', 'Grades' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'education-grade',
		'query_var'         => true,
	) );

	/* restaurant category */
	register_taxonomy( 'restaurant_category', array( 'restaurant' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Categories', 'Category', 'Categories' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'restaurant-category',
		'query_var'         => true,
	) );

	/* restaurant cuisine */
	register_taxonomy( 'restaurant_cuisine', array( 'restaurant' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Cuisines', 'Cuisine', 'Cuisines' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'restaurant-cuisine',
		'query_var'         => true,
	) );

	/* restaurant features */
	register_taxonomy( 'restaurant_features', array( 'restaurant' ), array(
		'hierarchical'      => true,
		'labels'            => moffly_get_taxonomy_label( 'Features', 'Feature', 'Features' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => 'restaurant-features',
		'query_var'         => true,
	) );
}

add_action( 'init', 'wdp_moffly_register_taxonomies' );

function moffly_get_post_labels( $menu_name, $singular, $plural, $type = 'plural' ) {
	$labels = array(
		'name'               => 'plural' == $type ? $plural : $singular,
		'all_items'          => sprintf( __( "All %s", 'wp-radio' ), $plural ),
		'singular_name'      => $singular,
		'add_new'            => sprintf( __( 'Add New %s', 'wp-radio' ), $singular ),
		'add_new_item'       => sprintf( __( 'Add New %s', 'wp-radio' ), $singular ),
		'edit_item'          => sprintf( __( 'Edit %s', 'wp-radio' ), $singular ),
		'new_item'           => sprintf( __( 'New %s', 'wp-radio' ), $singular ),
		'view_item'          => sprintf( __( 'View %s', 'wp-radio' ), $singular ),
		'search_items'       => sprintf( __( 'Search %s', 'wp-radio' ), $plural ),
		'not_found'          => sprintf( __( 'No %s found', 'wp-radio' ), $plural ),
		'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'wp-radio' ), $plural ),
		'parent_item_colon'  => sprintf( __( 'Parent %s:', 'wp-radio' ), $singular ),
		'menu_name'          => $menu_name,
	);

	return $labels;
}

function moffly_get_taxonomy_label( $menu_name, $singular, $plural ) {
	$labels = array(
		'name'              => sprintf( _x( '%s', 'taxonomy general name', 'wp-radio' ), $plural ),
		'singular_name'     => sprintf( _x( '%s', 'taxonomy singular name', 'wp-radio' ), $singular ),
		'search_items'      => sprintf( __( 'Search %', 'wp-radio' ), $plural ),
		'all_items'         => sprintf( __( 'All %s', 'wp-radio' ), $plural ),
		'parent_item'       => sprintf( __( 'Parent %s', 'wp-radio' ), $singular ),
		'parent_item_colon' => sprintf( __( 'Parent %s:', 'wp-radio' ), $singular ),
		'edit_item'         => sprintf( __( 'Edit %s', 'wp-radio' ), $singular ),
		'update_item'       => sprintf( __( 'Update %s', 'wp-radio' ), $singular ),
		'add_new_item'      => sprintf( __( 'Add New %s', 'wp-radio' ), $singular ),
		'new_item_name'     => sprintf( __( 'New % Name', 'wp-radio' ), $singular ),
		'menu_name'         => __( $menu_name, 'wp-radio' ),
	);

	return $labels;
}

//directory post type listing
function add_moffly_directory_listing_post_type( $listings ) {
	$listings = array_merge( $listings, array(
		'top_doctor',
		'wedding_directory',
		'top_lawyer',
		'top_dentist',
		'education_guide',
		'restaurant'
	) );

	return $listings;
}

add_filter( 'wdp_listing_post_types', 'add_moffly_directory_listing_post_type' );
