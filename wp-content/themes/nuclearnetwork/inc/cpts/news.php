<?php
/**
 * Custom Post Type: News
 *
 * CPT for the daily news posts.
 *
 * @package Nuclear_Network
 */
function nuclearnetwork_cpt_news() {

	$labels = array(
		'name'                  => _x( 'News', 'Post Type General Name', 'nuclearnetwork' ),
		'singular_name'         => _x( 'News Post', 'Post Type Singular Name', 'nuclearnetwork' ),
		'menu_name'             => __( 'News', 'nuclearnetwork' ),
		'name_admin_bar'        => __( 'News', 'nuclearnetwork' ),
		'archives'              => __( 'News Archives', 'nuclearnetwork' ),
		'attributes'            => __( 'News Attributes', 'nuclearnetwork' ),
		'parent_item_colon'     => __( 'Parent News:', 'nuclearnetwork' ),
		'all_items'             => __( 'All News', 'nuclearnetwork' ),
		'add_new_item'          => __( 'Add New News Post', 'nuclearnetwork' ),
		'add_new'               => __( 'Add News Post', 'nuclearnetwork' ),
		'new_item'              => __( 'New News Post', 'nuclearnetwork' ),
		'edit_item'             => __( 'Edit News Post', 'nuclearnetwork' ),
		'update_item'           => __( 'Update News Post', 'nuclearnetwork' ),
		'view_item'             => __( 'View News Post', 'nuclearnetwork' ),
		'view_items'            => __( 'View News Posts', 'nuclearnetwork' ),
		'search_items'          => __( 'Search News', 'nuclearnetwork' ),
		'not_found'             => __( 'Not found', 'nuclearnetwork' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'nuclearnetwork' ),
		'featured_image'        => __( 'Featured Image', 'nuclearnetwork' ),
		'set_featured_image'    => __( 'Set featured image', 'nuclearnetwork' ),
		'remove_featured_image' => __( 'Remove featured image', 'nuclearnetwork' ),
		'use_featured_image'    => __( 'Use as featured image', 'nuclearnetwork' ),
		'insert_into_item'      => __( 'Insert into news', 'nuclearnetwork' ),
		'uploaded_to_this_item' => __( 'Uploaded to this news', 'nuclearnetwork' ),
		'items_list'            => __( 'News list', 'nuclearnetwork' ),
		'items_list_navigation' => __( 'News list navigation', 'nuclearnetwork' ),
		'filter_items_list'     => __( 'Filter news list', 'nuclearnetwork' ),
	);
	$args = array(
		'label'                 => __( 'News', 'nuclearnetwork' ),
		'description'           => __( 'Daily news posts', 'nuclearnetwork' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-welcome-widgets-menus',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'news', $args );

}
add_action( 'init', 'nuclearnetwork_cpt_news', 0 );
