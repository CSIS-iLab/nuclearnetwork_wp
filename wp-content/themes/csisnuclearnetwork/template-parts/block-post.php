<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

$post_type = get_post_type();

if ( $post_type === 'events' ) {
	$tax_name = 'event_type';
}

?>
<article <?php post_class('post-block post-block--post'); ?> id="post-<?php the_ID(); ?>">	
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" class="post-block__img" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'large' ); ?>
			</a>
		<?php endif; ?>

	<?php
		nuclearnetwork_display_subtypes();
		the_title( '<h3 class="post-block__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		the_excerpt();			
		nuclearnetwork_authors();
		nuclearnetwork_posted_on('M j, Y');
		nuclearnetwork_display_series();
	?>
</article><!-- .post -->
