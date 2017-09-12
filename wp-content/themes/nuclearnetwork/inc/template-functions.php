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

function jetpackme_custom_related( $atts ) {
    $posts_titles = array();
 
    if ( class_exists( 'Jetpack_RelatedPosts' ) && method_exists( 'Jetpack_RelatedPosts', 'init_raw' ) ) {
        $related = Jetpack_RelatedPosts::init_raw()
            ->set_query_name( 'jetpackme-shortcode' ) // Optional, name can be anything
            ->get_for_post_id(
                get_the_ID(),
                array( 'size' => 2 )
            );
 
        if ( $related ) {
            foreach ( $related as $result ) {
                // Get the related post IDs
                $related_post = get_post( $result[ 'id' ] );
                // From there you can do just about anything. Here we get the post titles
                $posts_titles[] = $related_post->post_title;
            }
        }
    }
 
    // Return a list of post titles separated by commas
    return implode( ', ', $posts_titles );
}
// Create a [jprel] shortcode
add_shortcode( 'jprel', 'jetpackme_custom_related' );
