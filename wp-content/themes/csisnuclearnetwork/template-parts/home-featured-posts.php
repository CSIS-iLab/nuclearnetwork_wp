<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

?>

<?php
	$featured_posts = $args;

	if ( $featured_posts ) :

		echo '<section class="home__featured-posts">';
        
        wp_reset_postdata();
        $counter = 0;
		foreach ( $featured_posts as $post ) :
		    if ($counter == 0) {
                    setup_postdata( $post );
                    echo get_post_type();
                    get_template_part( 'template-parts/block-featured-post', null, ["true"] );
            } else {
                setup_postdata( $post );
                echo get_post_type();
			    get_template_part( 'template-parts/block-featured-post' );
            }
            $counter++;
		endforeach;

		wp_reset_postdata();

		echo '</section>';

	endif;
?>