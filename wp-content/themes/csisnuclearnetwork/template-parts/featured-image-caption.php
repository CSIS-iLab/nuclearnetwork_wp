<?php
/**
 * Displays the featured image caption
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

if ( has_post_thumbnail() && ! post_password_required() && !is_page_template( 'templates/template-no-image.php' ) ) {

	$caption = get_the_post_thumbnail_caption();

	if ( $caption ) {
		echo '<div class="featured-media__caption"><span class="featured-media__caption-label">Header Image: </span> ' . esc_html( $caption ) . '</div>';
	}
}
