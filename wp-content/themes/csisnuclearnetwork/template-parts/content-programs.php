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

get_template_part( 'template-parts/entry-header' );
?>

<article <?php post_class( 'single__post' ); ?> id="post-<?php the_ID(); ?>">
	<div class="single__content">
		<?php
            the_content( __( 'Continue reading', 'nuclearnetwork' ) );
		?>
	</div>
</article><!-- .post -->