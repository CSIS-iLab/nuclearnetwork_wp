<?php
/**
 * The Search template.
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

get_header();
?>

<main id="site-content" role="main">

	<?php

		get_template_part( 'template-parts/entry-header' );

	?>

	<div class='archive__content'>

	<?php
		if ( have_posts() ) {

			// Pagination Results & Filters
			if ( class_exists( 'FacetWP') ) {
				echo "<aside class='archive__sidebar'>";
				nuclearnetwork_archive_filters( array(
					'show_content_types' => !$is_analysis_archive,
					'show_analysis_subtypes' => $is_analysis_archive,
					'show_author' => $show_author_filter
				));
				echo "</aside>";

				echo facetwp_display( 'facet', 'pagination_results' );

			} else {
				nuclearnetwork_pagination_number_of_posts();
			}

		} ?>

		<?php

		if ( have_posts() ) {

			echo '<section class="archive__postlist">';
			while ( have_posts() ) {
				the_post();

				get_template_part( 'template-parts/block-post', get_post_type() );

			}
			wp_reset_postdata();
			echo '</section>';

		} elseif ( is_search() ) {
			?>

			<div class="no-search-results-form section-inner thin">

			<h2 class="search-form__title"><?php esc_html_e( 'No Results', 'nuclearnetwork' ); ?></h2>

			<p class="search-form__desc text--long"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'nuclearnetwork' ); ?></p>

				<?php
				get_search_form(
					array(
						'label' => __( 'search again', 'nuclearnetwork' ),
					)
				);

				?>

			</div><!-- .no-search-results -->

			<?php
		}

		// Pagination
		if ( class_exists( 'FacetWP') ) {
			echo facetwp_display( 'facet', 'pagination_navigation' );
		} else {
			get_template_part( 'template-parts/pagination' );
		}
	?>

	</div>

</main><!-- #site-content -->

<?php
get_footer();
