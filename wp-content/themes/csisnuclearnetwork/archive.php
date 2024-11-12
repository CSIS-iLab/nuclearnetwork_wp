<?php
/**
 * The Archive template.
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

$term = get_queried_object();

$show_filters = false;

$is_analysis_archive = is_home() || 'post' === get_post_type();

$show_author_filter = !is_author();
$show_series_filter = !is_tax( 'series' );

if ( $is_analysis_archive ) {
	$show_filters = true;
}

get_header();
?>

<main id="site-content" role="main">

	<?php
		get_template_part( 'template-parts/entry-header' );
		
		if ( is_author() ) {
			get_template_part( 'template-parts/entry-author-bio');
		}
	?>

	<div class='archive__content'>

	<?php

		if ( have_posts() ) {
			// Pagination Results & Filters
			if ( class_exists( 'FacetWP') && $show_filters ) {
				echo "<aside class='archive__sidebar'>";
				nuclearnetwork_archive_filters( array(
					'show_content_types' => !$is_analysis_archive,
					'show_analysis_subtypes' => $is_analysis_archive,
					'show_author' => $show_author_filter,
					'show_series' => $show_series_filter
				));
				echo "</aside>";

				echo facetwp_display( 'facet', 'pagination_results' );

			} else if ( ! is_post_type_archive( 'projects' ) && ! is_post_type_archive( 'programs' ) ) {
				nuclearnetwork_pagination_number_of_posts();
			}
		}

		if (class_exists('ACF') && !is_paged()) {
			// vars
			$featured_post = get_field('featured_post', $term->name);
			if ( $featured_post ) {
				echo '<section class="archive__featured">';
					foreach( $featured_post as $post ):
						// Setup this post for WP functions (variable must be named $post).
						setup_postdata($post);
						// get_template_part( 'template-parts/block-post-featured' );
						get_template_part( 'template-parts/block-post', get_post_type() );
					endforeach;
				echo "</section>";
				// Reset the global post object so that the rest of the page works correctly.
				wp_reset_postdata();
			}
		}

		if ( have_posts() ) {
			echo '<section class="archive__postlist">';
			while ( have_posts() ) {


					the_post();
					if (!get_post_parent()){
						get_template_part( 'template-parts/block-post', get_post_type() );
					}
				
			}
			wp_reset_postdata();
			echo "</section>";
		}

		// Pagination
		if ( class_exists( 'FacetWP') && $show_filters ) {
			echo facetwp_display( 'facet', 'pagination_navigation' );
		} else {
			get_template_part( 'template-parts/pagination' );
		}

		if ( !is_author() ) {
			get_template_part( 'template-parts/featured-image-caption' );
		}

	?>
	</div>

</main><!-- #site-content -->

<?php
get_footer();
