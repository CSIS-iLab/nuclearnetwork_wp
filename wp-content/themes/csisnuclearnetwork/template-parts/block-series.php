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

$classes = 'post-block series';
$seriesURL = get_term_link( $post->term_id );
$feature_img = get_field( 'featured_image', $post );

?>
<article <?php post_class( $classes ); ?> id="post-<?php echo $post->term_id; ?>">
	<?php if ( $feature_img ) : ?>
		<a href="<?php esc_url( $seriesURL ); ?>" class="post-block__img">
			<img src="<?php echo esc_url($feature_img['url']); ?>" alt="<?php echo esc_attr($feature_img['alt']); ?>" />
		</a>
	<?php endif;

	echo '<h2 class="post-block__title text--bold"><a href="' . esc_url( $seriesURL ) . '">' . $post->name . '</a></h2>';
	echo '<p class="post-block__excerpt">' . $post->description . '</p>';
	?>
</article><!-- .post -->
