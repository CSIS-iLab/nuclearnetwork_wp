<?php
/**
 * Custom Post Type: Director's Corner
 *
 * CPT for posts by the PONI program director.
 *
 * @package Nuclear_Network
 */
function nuclearnetwork_cpt_directors_corner() {

	$labels = array(
		'name'                  => _x( 'Director\'s Corner', 'Post Type General Name', 'nuclearnetwork' ),
		'singular_name'         => _x( 'Director\'s Corner Post', 'Post Type Singular Name', 'nuclearnetwork' ),
		'menu_name'             => __( 'Director\'s Corner', 'nuclearnetwork' ),
		'name_admin_bar'        => __( 'Director\'s Corner', 'nuclearnetwork' ),
		'archives'              => __( 'Director\'s Corner', 'nuclearnetwork' ),
		'attributes'            => __( 'Director\'s Corner Attributes', 'nuclearnetwork' ),
		'parent_item_colon'     => __( 'Parent Director\'s Corner:', 'nuclearnetwork' ),
		'all_items'             => __( 'All Director\'s Corner', 'nuclearnetwork' ),
		'add_new_item'          => __( 'Add New Director\'s Corner Post', 'nuclearnetwork' ),
		'add_new'               => __( 'Add Director\'s Corner Post', 'nuclearnetwork' ),
		'new_item'              => __( 'New Director\'s Corner Post', 'nuclearnetwork' ),
		'edit_item'             => __( 'Edit Director\'s Corner Post', 'nuclearnetwork' ),
		'update_item'           => __( 'Update Director\'s Corner Post', 'nuclearnetwork' ),
		'view_item'             => __( 'View Director\'s Corner Post', 'nuclearnetwork' ),
		'view_items'            => __( 'View Director\'s Corner Posts', 'nuclearnetwork' ),
		'search_items'          => __( 'Search Director\'s Corner', 'nuclearnetwork' ),
		'not_found'             => __( 'Not found', 'nuclearnetwork' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'nuclearnetwork' ),
		'featured_image'        => __( 'Featured Image', 'nuclearnetwork' ),
		'set_featured_image'    => __( 'Set featured image', 'nuclearnetwork' ),
		'remove_featured_image' => __( 'Remove featured image', 'nuclearnetwork' ),
		'use_featured_image'    => __( 'Use as featured image', 'nuclearnetwork' ),
		'insert_into_item'      => __( 'Insert into post', 'nuclearnetwork' ),
		'uploaded_to_this_item' => __( 'Uploaded to this post', 'nuclearnetwork' ),
		'items_list'            => __( 'Director\'s Corner list', 'nuclearnetwork' ),
		'items_list_navigation' => __( 'Director\'s Corner list navigation', 'nuclearnetwork' ),
		'filter_items_list'     => __( 'Filter Director\'s Corner post list', 'nuclearnetwork' ),
	);
	$rewrite = array(
		'slug'                  => 'directors-corner',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Director\'s Corner', 'nuclearnetwork' ),
		'description'           => __( 'Posts by the PONI program director', 'nuclearnetwork' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-awards',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'directors-corner',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'directors_corner', $args );

}
add_action( 'init', 'nuclearnetwork_cpt_directors_corner', 0 );
