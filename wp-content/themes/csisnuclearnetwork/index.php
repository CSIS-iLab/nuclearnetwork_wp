<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
	?>

	<div class='archive__content'>
	<?php
		if ( class_exists('ACF') ) {
			$featured_post = get_field('featured_post', $term->name);
			if ( $featured_post ) {
				echo '<section class="archive__featured">';
				foreach( $featured_post as $post ):
					setup_postdata($post);
						get_template_part( 'template-parts/block-post', get_post_type() );
					endforeach;
				echo "</section>";
				wp_reset_postdata();
			}
		}
	?>
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

			} else {
				nuclearnetwork_pagination_number_of_posts();
			}
		}
		?>
		<?php

		if ( have_posts() ) {
			echo '<section class="archive__postlist">';
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/block-post', get_post_type() );
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

		if ( $is_analysis_archive ) {
			get_template_part( 'template-parts/featured-image-caption' );
		}
		?>
	</div>

</main><!-- #site-content -->

<?php
get_footer();
