<?php
/**
 * Reconnecting Asia Custom Shortcodes
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

function nuclearnetwork_shortcode_share_button( $atts, $content = null ) {

	// If there is an anchor link, direct the user's here instead of the top of the page.
	$atts = shortcode_atts(
		array(
				'anchor' => null,
				'image' => null,
		), $atts, 'share' );

	$anchor = null;

	if ( $atts['anchor'] != '' ) {
		$anchor = '#' . $atts['anchor'];
	}

	// If there is an image associated with this block, share it.
	$img = null;

	if ( $atts['image'] ) {
		$image_data = json_decode( html_entity_decode($atts['image'] ), true);
		$img = ' ' . $image_data['url'];
	}

	$shareArgs = array(
		'linkname' => get_the_title() . $img,
		'linkurl' => get_permalink() . $anchor
	);

	$output = '<div class="csis-block__share">';

	ob_start();
	if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) {
    ADDTOANY_SHARE_SAVE_KIT( $shareArgs );
	}
	$output .= ob_get_contents();
	ob_end_clean();

	$output .= '
		<button class="csis-block__share-btn btn btn--circle" aria-expanded="false" aria-label="Share on social media">' . nuclearnetwork_get_svg( 'share' ) . nuclearnetwork_get_svg( 'close' ) . '</button>
	</div>';

	return $output;
}

add_shortcode( 'share', 'nuclearnetwork_shortcode_share_button' );

/**
 * Return Related Posts in custom layout with a  shortcode
 */
function jetpackme_custom_related( $atts ) {

	if ( class_exists( 'Jetpack_RelatedPosts' ) && method_exists( 'Jetpack_RelatedPosts', 'init_raw' ) ) {
			$related = Jetpack_RelatedPosts::init_raw()
					->set_query_name( 'jetpackme-shortcode' ) // Optional, name can be anything
					->get_for_post_id(
							get_the_ID(),
							array( 'size' => 4 )
					);

		if ( $related || has_tag() ) {
			echo '<h2 class="single__footer-heading">';
			echo nuclearnetwork_get_svg( "3-arrows" );
			_e( 'Related Content', 'nuclearnetwork' );
			echo '</h2>';
			nuclearnetwork_display_tags();

			if ( $related ) {
				wp_reset_postdata();
				echo '<ul class="related-posts" role="list">';
				foreach ( $related as $result) {
					global $post;
					$post = get_post($result['id']);
					
					setup_postdata($post);
					
					echo '<li>';
					get_template_part( 'template-parts/block-post-related', get_post_format() );
					echo '</li>';
				}
				echo '</ul>';
			}
		}
	}

}
// Create a [jprel] shortcode
add_shortcode( 'jprel', 'jetpackme_custom_related' );
