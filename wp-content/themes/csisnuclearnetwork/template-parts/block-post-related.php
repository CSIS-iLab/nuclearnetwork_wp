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
<article <?php post_class('post-block-related'); ?> id="post-<?php the_ID(); ?>">	
	<?php
		print_r("<h4 class='post-block-related__subtitle'>ANALYSIS</h4>");
		nuclearnetwork_display_categories();
		the_title( '<h3 class="post-block-related__title"><a class="post-block-related__title" href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		nuclearnetwork_posted_on('M j, Y');
	?>
</article><!-- .post-block-related -->
