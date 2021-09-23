<?php
/**
 * Display Program content, specifically for Class Bio pages. Used by `templates/class-bio.php`.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */
$post_parent_id = wp_get_post_parent_id(get_the_ID());
get_template_part( 'template-parts/entry-header' );
?>

<article <?php post_class( 'single__post' ); ?> id="post-<?php the_ID(); ?>">
	<div class="single__content">
		<?php
            the_content( __( 'Continue reading', 'nuclearnetwork' ) );

						if ( $post_parent_id ) {
							get_template_part( 'template-parts/featured-image-caption' );
						}
		?>
	</div>
</article><!-- .post -->