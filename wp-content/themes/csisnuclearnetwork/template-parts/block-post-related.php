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
	<h4 class='post-block-related__subtitle'><a>ANALYSIS/</a><span><?php nuclearnetwork_display_categories() ?></span></h4>
	<?php
		the_title( '<h3 class="post-block-related__title"><a class="post-block-related__title" href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		nuclearnetwork_posted_on('M j, Y');
	?>
	<div class='post-block-related__byline'><span class="post-block-related__byline-divider">|</span>By. 
		<span class="post-block-related__byline-authors">
		<?php 
			$authors = coauthors(); 
			print_r($authors)
		?>
		</span>
	</div>

</article><!-- .post-block-related -->
