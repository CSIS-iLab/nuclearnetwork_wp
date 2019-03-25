<?php
/**
 * Custom Post Type: Events
 *
 * CPT for the event posts
 *
 * @package Nuclear_Network
 */
function nuclearnetwork_cpt_events() {

	$labels = array(
		'name'                  => _x( 'Events', 'Post Type General Name', 'nuclearnetwork' ),
		'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'nuclearnetwork' ),
		'menu_name'             => __( 'Events', 'nuclearnetwork' ),
		'name_admin_bar'        => __( 'Events', 'nuclearnetwork' ),
		'archives'              => __( 'Event Archives', 'nuclearnetwork' ),
		'attributes'            => __( 'Event Attributes', 'nuclearnetwork' ),
		'parent_item_colon'     => __( 'Parent Event:', 'nuclearnetwork' ),
		'all_items'             => __( 'All Events', 'nuclearnetwork' ),
		'add_new_item'          => __( 'Add New Event', 'nuclearnetwork' ),
		'add_new'               => __( 'Add New', 'nuclearnetwork' ),
		'new_item'              => __( 'New Event', 'nuclearnetwork' ),
		'edit_item'             => __( 'Edit Event', 'nuclearnetwork' ),
		'update_item'           => __( 'Update Event', 'nuclearnetwork' ),
		'view_item'             => __( 'View Event', 'nuclearnetwork' ),
		'view_items'            => __( 'View Events', 'nuclearnetwork' ),
		'search_items'          => __( 'Search Event', 'nuclearnetwork' ),
		'not_found'             => __( 'Not found', 'nuclearnetwork' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'nuclearnetwork' ),
		'featured_image'        => __( 'Featured Image', 'nuclearnetwork' ),
		'set_featured_image'    => __( 'Set featured image', 'nuclearnetwork' ),
		'remove_featured_image' => __( 'Remove featured image', 'nuclearnetwork' ),
		'use_featured_image'    => __( 'Use as featured image', 'nuclearnetwork' ),
		'insert_into_item'      => __( 'Insert into Event', 'nuclearnetwork' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Event', 'nuclearnetwork' ),
		'items_list'            => __( 'Events list', 'nuclearnetwork' ),
		'items_list_navigation' => __( 'Events list navigation', 'nuclearnetwork' ),
		'filter_items_list'     => __( 'Filter events list', 'nuclearnetwork' ),
	);
	$args = array(
		'label'                 => __( 'Event', 'nuclearnetwork' ),
		'description'           => __( 'Events for PONI members to attend.', 'nuclearnetwork' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'events', $args );

}
add_action( 'init', 'nuclearnetwork_cpt_events', 0 );

/**
 * Register custom taxonomy for the different types of events
 */
function nuclearnetwork_event_types() {

	$labels = array(
		'name'                       => _x( 'Event Type', 'Taxonomy General Name', 'nuclearnetwork' ),
		'singular_name'              => _x( 'Event Type', 'Taxonomy Singular Name', 'nuclearnetwork' ),
		'menu_name'                  => __( 'Event Types', 'nuclearnetwork' ),
		'all_items'                  => __( 'All Event Types', 'nuclearnetwork' ),
		'parent_item'                => __( 'Parent Event Type', 'nuclearnetwork' ),
		'parent_item_colon'          => __( 'Parent Event Type:', 'nuclearnetwork' ),
		'new_item_name'              => __( 'New Event Type', 'nuclearnetwork' ),
		'add_new_item'               => __( 'Add Event Type', 'nuclearnetwork' ),
		'edit_item'                  => __( 'Edit Event Type', 'nuclearnetwork' ),
		'update_item'                => __( 'Update Event Type', 'nuclearnetwork' ),
		'view_item'                  => __( 'View Event Type', 'nuclearnetwork' ),
		'separate_items_with_commas' => __( 'Separate event types with commas', 'nuclearnetwork' ),
		'add_or_remove_items'        => __( 'Add or remove event types', 'nuclearnetwork' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'nuclearnetwork' ),
		'popular_items'              => __( 'Popular Event Types', 'nuclearnetwork' ),
		'search_items'               => __( 'Search Event Types', 'nuclearnetwork' ),
		'not_found'                  => __( 'Not Found', 'nuclearnetwork' ),
		'no_terms'                   => __( 'No event types', 'nuclearnetwork' ),
		'items_list'                 => __( 'Event Types list', 'nuclearnetwork' ),
		'items_list_navigation'      => __( 'Event Types list navigation', 'nuclearnetwork' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'							 => true
	);
	register_taxonomy( 'event_types', array( 'events' ), $args );

}
add_action( 'init', 'nuclearnetwork_event_types', 0 );
