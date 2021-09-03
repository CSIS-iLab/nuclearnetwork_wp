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
		?>
	</div><!-- .post-inner -->

	<?php if ( is_single() ) { ?>
	<footer class="single__footer">
		<?php

		    echo '<div class="post__authors"><hr>';
			echo '<h2 class="section__heading post__authors-heading">Authors</h2><p class="text--italic text--short post__authors-disclaimer">The views expressed above are the author’s and do not necessarily reflect those of the Center for Strategic and International Studies or the Project on Nuclear Issues.</p><div class="post__authors-group">';
			nuclearnetwork_authors_list_extended(); 
			echo '</div><div class="single__footer__write-for-us">';
			dynamic_sidebar('write-for-us'); 
			echo '</div></div>';
			nuclearnetwork_citation();
			// echo do_shortcode( '[jprel]' );
			// if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); }
			// get_template_part( 'template-parts/featured-image-caption' );
		?>
	</footer>
	<?php } ?>

</article><!-- .post -->
