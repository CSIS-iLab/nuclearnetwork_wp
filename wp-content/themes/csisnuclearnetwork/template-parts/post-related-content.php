<?php
/**
 * The default template for displaying related content
 *
 * Used for singular.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

?>
<?php

	$term = get_queried_object();
	// vars
	$related_posts = get_field( 'related_posts', $term );

	// if related content we show them
	if ( $related_posts || has_tag() ) {
		echo '<h2 class="single__footer-heading">';
			echo nuclearnetwork_get_svg( "3-arrows" );
			_e( 'Related Content', 'nuclearnetwork' );
		echo '</h2>';
		nuclearnetwork_display_tags();

		if ( $related_posts ) {
			echo '<ul class="related-posts" role="list">';
				foreach( $related_posts as $post ):
					setup_postdata($post);
					echo '<li>';
					get_template_part( 'template-parts/block-post-related' );
					echo '</li>';
				endforeach;
			echo '</ul>';
			wp_reset_postdata();
		}
	}
?>
