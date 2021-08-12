<?php
/**
 * The Archive template.
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

$term = get_queried_object();

get_header();
?>

<main id="site-content" role="main">

	<?php
		get_template_part( 'template-parts/entry-header' );
	?>

	<div class='archive__content'>

	<?php
		if ( have_posts() ) {
			echo '<h2 class="archive__section-title">Past Events</h2>';
			nuclearnetwork_pagination_number_of_posts();

			echo '<section class="archive__base">';
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/block-post', get_post_type() );
			}
			echo "</section>";
			wp_reset_postdata();

		  get_template_part( 'template-parts/pagination' );

    }

	?>
	</div>

</main><!-- #site-content -->

<?php
get_footer();
