<?php
/**
 * Custom Post Type: Essentials
 *
 * CPT for the PONI Essentials posts.
 *
 * @package Nuclear_Network
 */
function nuclearnetwork_cpt_essentials() {

	$labels = array(
		'name'                  => _x( 'Essentials', 'Post Type General Name', 'nuclearnetwork' ),
		'singular_name'         => _x( 'Essential Post', 'Post Type Singular Name', 'nuclearnetwork' ),
		'menu_name'             => __( 'Essentials', 'nuclearnetwork' ),
		'name_admin_bar'        => __( 'Essentials', 'nuclearnetwork' ),
		'archives'              => __( 'Essentials Archives', 'nuclearnetwork' ),
		'attributes'            => __( 'Essentials Post Attributes', 'nuclearnetwork' ),
		'parent_item_colon'     => __( 'Parent Essentials Post:', 'nuclearnetwork' ),
		'all_items'             => __( 'All Essentials', 'nuclearnetwork' ),
		'add_new_item'          => __( 'Add New Essentials Post', 'nuclearnetwork' ),
		'add_new'               => __( 'Add New', 'nuclearnetwork' ),
		'new_item'              => __( 'New Essentials Post', 'nuclearnetwork' ),
		'edit_item'             => __( 'Edit Essentials Post', 'nuclearnetwork' ),
		'update_item'           => __( 'Update Essentials Post', 'nuclearnetwork' ),
		'view_item'             => __( 'View Essentials Post', 'nuclearnetwork' ),
		'view_items'            => __( 'View Essentials', 'nuclearnetwork' ),
		'search_items'          => __( 'Search Essentials Post', 'nuclearnetwork' ),
		'not_found'             => __( 'Not found', 'nuclearnetwork' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'nuclearnetwork' ),
		'featured_image'        => __( 'Featured Image', 'nuclearnetwork' ),
		'set_featured_image'    => __( 'Set featured image', 'nuclearnetwork' ),
		'remove_featured_image' => __( 'Remove featured image', 'nuclearnetwork' ),
		'use_featured_image'    => __( 'Use as featured image', 'nuclearnetwork' ),
		'insert_into_item'      => __( 'Insert into Essentials Post', 'nuclearnetwork' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Essentials Post', 'nuclearnetwork' ),
		'items_list'            => __( 'Essentials list', 'nuclearnetwork' ),
		'items_list_navigation' => __( 'Essentials list navigation', 'nuclearnetwork' ),
		'filter_items_list'     => __( 'Filter essentials list', 'nuclearnetwork' ),
	);
	$args = array(
		'label'                 => __( 'Essential Post', 'nuclearnetwork' ),
		'description'           => __( 'Essential, need to know informative articles.', 'nuclearnetwork' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-list-view',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'essentials', $args );

}
add_action( 'init', 'nuclearnetwork_cpt_essentials', 0 );
