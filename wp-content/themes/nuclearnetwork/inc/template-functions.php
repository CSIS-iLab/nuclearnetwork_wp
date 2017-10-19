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
 * Allow related posts for custom post types.
 *
 * @param  array $allowed_post_types Array of allowed post types.
 * @return array                     Updated allowed post types array.
 */
function jetpackme_allow_my_post_types( $allowed_post_types ) {
	$allowed_post_types[] = 'events';
	$allowed_post_types[] = 'announcements';
	$allowed_post_types[] = 'resources';
	return $allowed_post_types;
}
add_filter( 'rest_api_allowed_post_types', 'jetpackme_allow_my_post_types' );

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

add_action( 'pre_get_posts', 'nuclearnetwork_events_archive' );
/**
 * Modify events archive to only show current & future events unless we've filtered.
 *
 * @param  array $query Query object.
 */
function nuclearnetwork_events_archive( $query ) {
	if ( ! is_admin() && is_post_type_archive( 'events' ) && $query->is_main_query() ) {

		// If we're searching, show all results.
		$url = parse_url( $_SERVER['REQUEST_URI'] );
		if ( false === strpos( $url['query'], 'sft' ) && false === strpos( $url['query'], 'sfm' ) ) {

			// If we're viewing non-PONI events, filter appropriately.
			if ( isset( $query->query_vars['other'] ) ) {
				$meta_query[] = array(
					'key' => '_post_poni_sponsored',
					'value' => '1',
					'compare' => '!=',
					'type' => 'INT',
				);
				$query->set( 'meta_query', $meta_query );
			} else {
				$meta_query[] = array(
					'key' => '_post_poni_sponsored',
					'value' => '1',
					'compare' => '=',
					'type' => 'INT',
				);
				$query->set( 'meta_query', $meta_query );
			}

			// if this is a past events view
			// set compare to before today,
			// otherwise set to today or later.
			$compare = isset( $query->query_vars['is_past'] ) ? '<' : '>=';

			// add the meta query and use the $compare var.
			$today = date( 'Y-m-d' );
			$meta_query['_post_start_date'] = array(
				'key' => '_post_start_date',
				'value' => $today,
				'compare' => $compare,
				'type' => 'DATE',
			);
			$query->set( 'meta_query', $meta_query );
		}

		if ( isset( $query->query_vars['is_past'] ) ) {
			$past_events_order_dir = 'DESC';
		} else {
			$past_events_order_dir = 'ASC';
		}

		$query->set( 'orderby', array(
			'meta_value' => 'DESC',
			'_post_start_date' => $past_events_order_dir,
		) );
	}
}

/**
 * Rewrite events URL to account for past events & non-PONI events.
 */
function nuclearnetwork_event_archive_rewrites() {
	add_rewrite_tag( '%is_past%','([^&]+)' );
	add_rewrite_rule(
		'events/past/page/([0-9]+)/?$',
		'index.php?post_type=events&paged=$matches[1]&is_past=true',
		'top'
	);
	add_rewrite_rule(
		'events/past/?$',
		'index.php?post_type=events&is_past=true',
		'top'
	);
	add_rewrite_tag( '%other%','([^&]+)' );
	add_rewrite_rule(
		'events/other/page/([0-9]+)/?$',
		'index.php?post_type=events&paged=$matches[1]&other=true',
		'top'
	);
	add_rewrite_rule(
		'events/other/?$',
		'index.php?post_type=events&other=true',
		'top'
	);
	add_rewrite_rule(
		'events/other/past/page/([0-9]+)/?$',
		'index.php?post_type=events&paged=$matches[1]&is_past=true&other=true',
		'top'
	);
	add_rewrite_rule(
		'events/other/past/?$',
		'index.php?post_type=events&is_past=true&other=true',
		'top'
	);
}
add_action( 'init', 'nuclearnetwork_event_archive_rewrites' );

/**
 * Custom page titles for Guest Authors with WordPress SEO
 * Returns "[author name]&#39;s articles on [site name]".
 *
 * @param  string $title Author's name.
 */
function nuclearnetwork_co_author_wseo_title( $title ) {
	// Only filter title output for author pages.
	if ( is_author() && function_exists( 'get_coauthors' ) ) {
		$qo = get_queried_object();
		$author_name = $qo->display_name;
		return $author_name . '&#39;s articles on ' . get_bloginfo( 'name' );
	}
	return $title;
}
add_filter( 'wpseo_title', 'nuclearnetwork_co_author_wseo_title' );

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function nuclearnetwork_excerpt_more( $more ) {
	return sprintf( ' <a class="read-more" href="%1$s">%2$s<i class="icon-arrow-right"></i></a>',
		get_permalink( get_the_ID() ),
		__( 'Read More', 'textdomain' )
	);
}
add_filter( 'excerpt_more', 'nuclearnetwork_excerpt_more' );

add_action( 'pre_get_posts', 'nuclearnetwork_resources_archive' );
/**
 * Modify resources archive to group posts by category.
 *
 * @param  array $query Query object.
 */
function nuclearnetwork_resources_archive( $query ) {
	if ( ! is_admin() && is_post_type_archive( 'resources' ) && $query->is_main_query() ) {
		$post_ids = array();

		$terms = get_terms( 'resource_types' );

		foreach ( $terms as $term ) {
			$filtered_posts = new WP_Query( array(
				'post_type' => 'resources',
				'fields' => 'ids',
				'orderby' => 'title',
				'order' => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => $term->taxonomy,
						'field' => 'term_id',
						'terms' => $term->term_id,
					),
				),
			));
			$post_ids = array_merge( $post_ids, $filtered_posts->posts );
		}

		$query->query_vars['post__in'] = $post_ids;
		$query->query_vars['orderby'] = 'post__in';
	}
}

/**
 * Append /other & /past to URL for events to keep proper pagination.
 *
 * @param  string $url  URL.
 * @param  int    $sfid Search form ID.
 * @return string       Updated URL.
 */
function nuclearnetwork_events_archive_search_rewrites( $url, $sfid ) {
	$other = get_query_var( 'other', false );
	if ( 'true' === $other ) {
		$url = $url . 'other/';
	}
	$is_past = get_query_var( 'is_past', false );
	if ( 'true' === $is_past ) {
		$url = $url . 'past/';
	}
	return $url;
}
add_filter( 'sf_results_url', 'nuclearnetwork_events_archive_search_rewrites', 10, 2 );
