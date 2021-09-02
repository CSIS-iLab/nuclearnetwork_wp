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

	// if no related content we bail
	if ( !($related_posts || has_tag() || has_category()) ) {
      return;
    }

    echo '<hr />';
    echo '<h2 class="single__footer-heading">';
        _e( 'Related', 'nuclearnetwork' );
    echo '</h2>';
    echo '<div class="single__footer-related-posts">';

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
    echo '</div>';

    echo '<div class="single__footer-related-terms">';
    if (has_category()) {
      echo '<h3 class="single__footer-label">Topics</h3>';
      nuclearnetwork_display_categories();
    }

    if ( has_tag()) {
      echo '<h3 class="single__footer-label">Keywords</h3>';
      nuclearnetwork_display_tags();
    }
    echo '</div>';

?>
