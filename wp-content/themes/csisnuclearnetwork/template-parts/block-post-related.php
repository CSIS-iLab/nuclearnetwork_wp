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
	<?php nuclearnetwork_display_subtypes(); ?>
	<?php
		the_title( '<h3 class="post-block-related__title"><a class="post-block-related__title" href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
	?>
	<div class='post-block-related__byline'>
		<?php nuclearnetwork_posted_on('M j, Y') ?> 
		<?php 
		if (!is_front_page()){
			nuclearnetwork_authors();
		}
		?>
	</div>

</article><!-- .post-block-related -->
