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
	if ( is_single() ) {
		global $post;
		$disable_linkedin = get_post_meta( $post->ID, '_post_disable_linkedin', true );
		if ( ! $disable_linkedin ) {
			$content .= nuclearnetwork_post_discuss( $post->ID );
		}
	}
	return $content;
}

function jetpackme_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_filter( 'wp', 'jetpackme_remove_rp', 20 );

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
