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

get_template_part( 'template-parts/entry-header' );
?>

<article <?php post_class( 'single__post' ); ?> id="post-<?php the_ID(); ?>">

	<?php


	?>

	<div class="single__content">
		<?php
      		the_content( __( 'Continue reading', 'nuclearnetwork' ) );
			nuclearnetwork_display_footnotes();
			if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); }
		?>
	</div><!-- .post-inner -->
	
	<?php if ( is_single() && get_post_type() === 'post' ) { ?>
	<footer class="single__footer">
		<?php

			get_template_part( 'template-parts/post-resources' );
		  echo '<div class="post__authors">';
			echo '<h2 class="section__heading post__authors-heading single__section-heading">Authors</h2><p class="text--italic text--short post__authors-disclaimer">The views expressed above are the author’s and do not necessarily reflect those of the Center for Strategic and International Studies or the Project on Nuclear Issues.</p><div class="post__authors-content"><div class="post__authors-group">';
			nuclearnetwork_authors_list_extended(); 
			echo '</div><div class="single__footer-write-for-us">';
			dynamic_sidebar('write-for-us'); 
			echo '</div>';
			nuclearnetwork_citation();
			echo '</div></div>';
			echo do_shortcode( '[jprel]' );
		?>
	</footer>
	<?php } ?>

</article><!-- .post -->
