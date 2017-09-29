<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Nuclear_Network
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function nuclearnetwork_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'nuclearnetwork_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function nuclearnetwork_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'nuclearnetwork_pingback_header' );

add_filter( 'the_content', 'insert_content_discuss_message' );
/**
 * Insert "Discuss this post" message after single posts unless it's turned off at the post level.
 *
 * @param  string $content Post content.
 * @return string          HTML of call out box
 */
function insert_content_discuss_message( $content ) {
	if ( is_single() && 'post' === get_post_type() ) {
		global $post;
		$disable_linkedin = get_post_meta( $post->ID, '_post_disable_linkedin', true );
		if ( ! $disable_linkedin ) {
			$callout_title = 'Discuss this Post';
			$callout_message = get_option( 'nuclearnetwork_post_discuss' );
			$callout_url = get_post_meta( $id, '_post_linkedin_url', true );
			if ( ! $callout_url ) {
				$callout_url = get_option( 'nuclearnetwork_linkedin' );
			}
			$callout_icon = 'icon-linkedin-discuss';
			$content .= nuclearnetwork_post_callout( $callout_title, $callout_message, $callout_url, $callout_icon );
		}
	}
	return $content;
}

/**
 * Removes JetPack related posts after posts.
 */
function jetpackme_remove_rp() {
	if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
		 $jprp = Jetpack_RelatedPosts::init();
		$callback = array( $jprp, 'filter_add_target_to_dom' );
		remove_filter( 'the_content', $callback, 40 );
	}
}
add_filter( 'wp', 'jetpackme_remove_rp', 20 );

/**
 * Create custom shortcode for Jetpack related posts.
 *
 * @param  array $atts Shortcode attributes.
 * @return string       HTML of related posts.
 */
function jetpackme_custom_related( $atts ) {
	$related_html = '';

	if ( class_exists( 'Jetpack_RelatedPosts' ) && method_exists( 'Jetpack_RelatedPosts', 'init_raw' ) ) {
		$related = Jetpack_RelatedPosts::init_raw()
			->set_query_name( 'jetpackme-shortcode' ) // Optional, name can be anything
			->get_for_post_id(
				get_the_ID(),
				array( 'size' => 2 )
			);

		if ( $related ) {
			foreach ( $related as $result ) {
				// Get the related post IDs.
				$related_post = get_post( $result[ 'id' ] );
				$thumbnail = get_the_post_thumbnail_url( $related_post, 'medium_large' );
				$related_html .= '<div class="related-post col-xs-12 col-md-4">
				<div class="related-post-img" style="background-image:url(\'' . $thumbnail . '\');"></div>
				<a href="' . esc_url( get_permalink( $related_post ) ) . '">
				<h4>' . $related_post->post_title . '</h4>
				<span class="post-date">' . get_the_date( '', $result['id'] ) . '</span>
				</a></div>';
			}
		}
	}

	// Return a list of post titles separated by commas.
	return $related_html;
}
// Create a [jprel] shortcode.
add_shortcode( 'jprel', 'jetpackme_custom_related' );

/**
 * Renders content blocks for the homepage.
 *
 * @return array Array of menu items HTML to return.
 */
function nuclearnetwork_homepage_blocks() {
	$menu_locations = get_nav_menu_locations();
	$menu_id = $menu_locations['menu-1'];
	$homepage_menu = wp_get_nav_menu_items( $menu_id );
	$homepage_menu_items = array();
	$current_parent = 0;
	foreach ( $homepage_menu as $item ) {
		if ( strpos( $item->classes[0], 'homepage' ) !== false ) {
			$item->menu_post_type = get_post_meta( $item->ID, 'menu-item-menu_post_type', true );
			$item->menu_featured_img = get_post_meta( $item->ID, 'menu-item-menu_featured_img', true );

			if ( $item->menu_post_type ) {
				$item->featured_post = nuclearnetwork_blocks_featured_post( $item->menu_post_type );
			}

			if ( ! $item->post_title ) {
				$item->post_title = $item->title;
			}

			$homepage_menu_items[ $item->ID ] = $item;

			if ( 0 == $item->menu_item_parent ) {
				$current_parent = $item->ID;

				if ( ! isset( $homepage_menu_items[ $current_parent ]->children ) ) {
					$homepage_menu_items[ $current_parent ]->children = array();
				}
			}
		}

		if ( $current_parent == $item->menu_item_parent && 0 != $current_parent ) {
			if ( ! $item->post_title ) {
				$item->post_title = $item->title;
			}
			$homepage_menu_items[ $current_parent ]->children[] = $item;
		}
	}

	// Sort Array.
	usort( $homepage_menu_items, 'nuclearnetwork_blocks_cmp' );

	return $homepage_menu_items;
}

/**
 * Compare objects for homepage blocks to get them in the right order.
 *
 * @param  object $a First object to compare.
 * @param  object $b Second object to compare.
 * @return array    Sorted array.
 */
function nuclearnetwork_blocks_cmp( $a, $b ) {
	return strcmp( $a->classes[0], $b->classes[0] );
}

/**
 * Gets the featured post for the homepage block based on a specified post type.
 *
 * @param  string $post_type Post type to get post from.
 * @return array            Post object.
 */
function nuclearnetwork_blocks_featured_post( $post_type = 'post' ) {
	$args = array(
		'post_type'  => array( $post_type ),
		'posts_per_page' => 1,
		'cache_results' => true,
		'update_post_meta_cache' => false,
		'meta_query' => array(
			array(
				'key' => '_post_is_featured',
				'value' => 1,
				'compare' => '=',
			),
		),
	);

	$query = new WP_Query( $args );
	return $query->post;
}

add_action( 'pre_get_posts', 'nuclearnetwork_custom_sort_posts' );
/**
 * Change the default post query to show featured posts first.
 *
 * @param  array $query Query object.
 */
function nuclearnetwork_custom_sort_posts( $query ) {
	if ( ( ( is_home() && get_option( 'page_for_posts' ) ) || is_category() || is_archive()) && $query->is_main_query() ) {
		$query->set( 'meta_key', '_post_is_featured' );
		$query->set( 'orderby', array(
			'meta_value_num' => 'DESC',
			'post_date' => 'DESC',
		) );
	}
}
