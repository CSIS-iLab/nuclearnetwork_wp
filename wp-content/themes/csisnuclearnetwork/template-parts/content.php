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

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php

	get_template_part( 'template-parts/entry-header' );

	?>

	<div class="single__content">
		<?php
      the_content( __( 'Continue reading', 'nuclearnetwork' ) );
      nuclearnetwork_display_footnotes();
			get_template_part( 'template-parts/featured-image-caption' );
			nuclearnetwork_citation();
    ?>
	</div><!-- .post-inner -->

	<?php if ( is_single() ) { ?>
	<footer class="single__footer">
		<?php
			echo do_shortcode( '[jprel]' );
			if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); }
		?>
	</footer>
	<?php } ?>

</article><!-- .post -->
