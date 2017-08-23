<?php
/**
 * Custom Post Type: Opportunities
 *
 * CPT for the job/opportunity posts
 *
 * @package Nuclear_Network
 */
function nuclearnetwork_cpt_opportunities() {

	$labels = array(
		'name'                  => _x( 'Opportunities', 'Post Type General Name', 'nuclearnetwork' ),
		'singular_name'         => _x( 'Opportunity', 'Post Type Singular Name', 'nuclearnetwork' ),
		'menu_name'             => __( 'Opportunities', 'nuclearnetwork' ),
		'name_admin_bar'        => __( 'Opportunities', 'nuclearnetwork' ),
		'archives'              => __( 'Opportunity Archives', 'nuclearnetwork' ),
		'attributes'            => __( 'Opportunity Attributes', 'nuclearnetwork' ),
		'parent_item_colon'     => __( 'Parent Opportunity:', 'nuclearnetwork' ),
		'all_items'             => __( 'All Opportunities', 'nuclearnetwork' ),
		'add_new_item'          => __( 'Add New Opportunity', 'nuclearnetwork' ),
		'add_new'               => __( 'Add New', 'nuclearnetwork' ),
		'new_item'              => __( 'New Opportunity', 'nuclearnetwork' ),
		'edit_item'             => __( 'Edit Opportunity', 'nuclearnetwork' ),
		'update_item'           => __( 'Update Opportunity', 'nuclearnetwork' ),
		'view_item'             => __( 'View Opportunity', 'nuclearnetwork' ),
		'view_items'            => __( 'View Opportunities', 'nuclearnetwork' ),
		'search_items'          => __( 'Search Opportunity', 'nuclearnetwork' ),
		'not_found'             => __( 'Not found', 'nuclearnetwork' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'nuclearnetwork' ),
		'featured_image'        => __( 'Featured Image', 'nuclearnetwork' ),
		'set_featured_image'    => __( 'Set featured image', 'nuclearnetwork' ),
		'remove_featured_image' => __( 'Remove featured image', 'nuclearnetwork' ),
		'use_featured_image'    => __( 'Use as featured image', 'nuclearnetwork' ),
		'insert_into_item'      => __( 'Insert into Opportunity', 'nuclearnetwork' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Opportunity', 'nuclearnetwork' ),
		'items_list'            => __( 'Opportunities list', 'nuclearnetwork' ),
		'items_list_navigation' => __( 'Opportunities list navigation', 'nuclearnetwork' ),
		'filter_items_list'     => __( 'Filter opportunities list', 'nuclearnetwork' ),
	);
	$args = array(
		'label'                 => __( 'Opportunity', 'nuclearnetwork' ),
		'description'           => __( 'Jobs and opportunities for PONI members.', 'nuclearnetwork' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'taxonomies'            => array( 'category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'opportunities', $args );

}
add_action( 'init', 'nuclearnetwork_cpt_opportunities', 0 );

/**
 * Register custom taxonomy for the different types of opportunities
 */
function nuclearnetwork_opportunity_types() {

	$labels = array(
		'name'                       => _x( 'Opportunity Type', 'Taxonomy General Name', 'nuclearnetwork' ),
		'singular_name'              => _x( 'Opportunity Type', 'Taxonomy Singular Name', 'nuclearnetwork' ),
		'menu_name'                  => __( 'Opportunity Types', 'nuclearnetwork' ),
		'all_items'                  => __( 'All Opportunity Types', 'nuclearnetwork' ),
		'parent_item'                => __( 'Parent Opportunity Type', 'nuclearnetwork' ),
		'parent_item_colon'          => __( 'Parent Opportunity Type:', 'nuclearnetwork' ),
		'new_item_name'              => __( 'New Opportunity Type', 'nuclearnetwork' ),
		'add_new_item'               => __( 'Add Opportunity Type', 'nuclearnetwork' ),
		'edit_item'                  => __( 'Edit Opportunity Type', 'nuclearnetwork' ),
		'update_item'                => __( 'Update Opportunity Type', 'nuclearnetwork' ),
		'view_item'                  => __( 'View Opportunity Type', 'nuclearnetwork' ),
		'separate_items_with_commas' => __( 'Separate opportunity types with commas', 'nuclearnetwork' ),
		'add_or_remove_items'        => __( 'Add or remove opportunity types', 'nuclearnetwork' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'nuclearnetwork' ),
		'popular_items'              => __( 'Popular Opportunity Types', 'nuclearnetwork' ),
		'search_items'               => __( 'Search Opportunity Types', 'nuclearnetwork' ),
		'not_found'                  => __( 'Not Found', 'nuclearnetwork' ),
		'no_terms'                   => __( 'No opportunity types', 'nuclearnetwork' ),
		'items_list'                 => __( 'Opportunity Types list', 'nuclearnetwork' ),
		'items_list_navigation'      => __( 'Opportunity Types list navigation', 'nuclearnetwork' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'opportunity_types', array( 'opportunities' ), $args );

}
add_action( 'init', 'nuclearnetwork_opportunity_types', 0 );
