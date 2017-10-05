<?php
/**
 * Custom Post Type: Alumni
 *
 * CPT for the daily alumni posts.
 *
 * @package Nuclear_Network
 */
function nuclearnetwork_cpt_alumni() {

	$labels = array(
		'name'                  => _x( 'Next Generation', 'Post Type General Name', 'nuclearnetwork' ),
		'singular_name'         => _x( 'Alumni Post', 'Post Type Singular Name', 'nuclearnetwork' ),
		'menu_name'             => __( 'Alumni', 'nuclearnetwork' ),
		'name_admin_bar'        => __( 'Alumni', 'nuclearnetwork' ),
		'archives'              => __( 'Alumni Archives', 'nuclearnetwork' ),
		'attributes'            => __( 'Alumni Attributes', 'nuclearnetwork' ),
		'parent_item_colon'     => __( 'Parent Alumni:', 'nuclearnetwork' ),
		'all_items'             => __( 'All Alumni', 'nuclearnetwork' ),
		'add_new_item'          => __( 'Add New Alumni Post', 'nuclearnetwork' ),
		'add_new'               => __( 'Add Alumni Post', 'nuclearnetwork' ),
		'new_item'              => __( 'New Alumni Post', 'nuclearnetwork' ),
		'edit_item'             => __( 'Edit Alumni Post', 'nuclearnetwork' ),
		'update_item'           => __( 'Update Alumni Post', 'nuclearnetwork' ),
		'view_item'             => __( 'View Alumni Post', 'nuclearnetwork' ),
		'view_items'            => __( 'View Alumni Posts', 'nuclearnetwork' ),
		'search_items'          => __( 'Search Alumni', 'nuclearnetwork' ),
		'not_found'             => __( 'Not found', 'nuclearnetwork' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'nuclearnetwork' ),
		'featured_image'        => __( 'Featured Image', 'nuclearnetwork' ),
		'set_featured_image'    => __( 'Set featured image', 'nuclearnetwork' ),
		'remove_featured_image' => __( 'Remove featured image', 'nuclearnetwork' ),
		'use_featured_image'    => __( 'Use as featured image', 'nuclearnetwork' ),
		'insert_into_item'      => __( 'Insert into alumni', 'nuclearnetwork' ),
		'uploaded_to_this_item' => __( 'Uploaded to this alumni', 'nuclearnetwork' ),
		'items_list'            => __( 'Alumni list', 'nuclearnetwork' ),
		'items_list_navigation' => __( 'Alumni list navigation', 'nuclearnetwork' ),
		'filter_items_list'     => __( 'Filter alumni list', 'nuclearnetwork' ),
	);
	$rewrite = array(
		'slug'                  => 'next-generation',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Next Generation', 'nuclearnetwork' ),
		'description'           => __( 'Next Gen Scholar alumni profiles', 'nuclearnetwork' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-id',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'next-generation',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'alumni', $args );

}
add_action( 'init', 'nuclearnetwork_cpt_alumni', 0 );
