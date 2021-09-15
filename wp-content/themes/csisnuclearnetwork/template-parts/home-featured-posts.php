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
        $counter = 0;
        echo "<div class='home__featured-posts-primary'>";
        wp_reset_postdata();
        $post = $featured_posts[0];
        setup_postdata( $post );
        get_template_part( 'template-parts/block-featured-post', null, ["true"] );
        echo "</div>";

        echo "<div class='home__featured-posts-secondary'>";
		foreach ( $featured_posts as $post ) :
            // echo $post->ID;
		    if ($counter != 0) {
                if ($counter == 2){
                    echo "<hr>";
                }
                setup_postdata( $post );
			    get_template_part( 'template-parts/block-featured-post' );
            }
            $counter++;
		endforeach;
        echo '</div>';

		wp_reset_postdata();

		echo '</section>';

	endif;
?>