<?php
/**
 * Custom Post Type: Announcements
 *
 * CPT for posts by the PONI program director.
 *
 * @package Nuclear_Network
 */
function nuclearnetwork_cpt_announcements() {

	$labels = array(
		'name'                  => _x( 'Announcements', 'Post Type General Name', 'nuclearnetwork' ),
		'singular_name'         => _x( 'Announcement', 'Post Type Singular Name', 'nuclearnetwork' ),
		'menu_name'             => __( 'Announcements', 'nuclearnetwork' ),
		'name_admin_bar'        => __( 'Announcements', 'nuclearnetwork' ),
		'archives'              => __( 'Announcements', 'nuclearnetwork' ),
		'attributes'            => __( 'Announcements Attributes', 'nuclearnetwork' ),
		'parent_item_colon'     => __( 'Parent Announcements:', 'nuclearnetwork' ),
		'all_items'             => __( 'All Announcements', 'nuclearnetwork' ),
		'add_new_item'          => __( 'Add New Announcement', 'nuclearnetwork' ),
		'add_new'               => __( 'Add Announcement', 'nuclearnetwork' ),
		'new_item'              => __( 'New Announcement', 'nuclearnetwork' ),
		'edit_item'             => __( 'Edit Announcement', 'nuclearnetwork' ),
		'update_item'           => __( 'Update Announcement', 'nuclearnetwork' ),
		'view_item'             => __( 'View Announcement', 'nuclearnetwork' ),
		'view_items'            => __( 'View Announcements', 'nuclearnetwork' ),
		'search_items'          => __( 'Search Announcements', 'nuclearnetwork' ),
		'not_found'             => __( 'Not found', 'nuclearnetwork' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'nuclearnetwork' ),
		'featured_image'        => __( 'Featured Image', 'nuclearnetwork' ),
		'set_featured_image'    => __( 'Set featured image', 'nuclearnetwork' ),
		'remove_featured_image' => __( 'Remove featured image', 'nuclearnetwork' ),
		'use_featured_image'    => __( 'Use as featured image', 'nuclearnetwork' ),
		'insert_into_item'      => __( 'Insert into post', 'nuclearnetwork' ),
		'uploaded_to_this_item' => __( 'Uploaded to this post', 'nuclearnetwork' ),
		'items_list'            => __( 'Announcements list', 'nuclearnetwork' ),
		'items_list_navigation' => __( 'Announcements list navigation', 'nuclearnetwork' ),
		'filter_items_list'     => __( 'Filter Announcements post list', 'nuclearnetwork' ),
	);
	$args = array(
		'label'                 => __( 'Announcements', 'nuclearnetwork' ),
		'description'           => __( 'Posts by the PONI program director', 'nuclearnetwork' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author' ),
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
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'announcements', $args );

}
add_action( 'init', 'nuclearnetwork_cpt_announcements', 0 );
