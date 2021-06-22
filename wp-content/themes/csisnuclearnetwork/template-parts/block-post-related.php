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
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" class="post-block-related__img" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'large' ); ?>
			</a>
		<?php endif; ?>

	<?php
		nuclearnetwork_posted_on('M j, Y');
		the_title( '<h3 class="post-block-related__title"><a class="post-block-related__title" href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
	?>
</article><!-- .post-block-related -->
