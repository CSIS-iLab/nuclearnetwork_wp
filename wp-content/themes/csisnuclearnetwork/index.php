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

get_header();
?>

<main id="site-content" role="main">

	<?php
		get_template_part( 'template-parts/entry-header' );
	?>

	<div class='archive__content'>
	<?php
		if ( have_posts() ) {
			nuclearnetwork_pagination_number_of_posts();
		}
		?>

		<div class="archive__filters">
			<p class="facet-headings text--caps">Filter By Analaysis Type</p>
			<?php echo facetwp_display( 'facet', 'analysis_subtypes' ); ?>

			<p class="facet-headings text--caps">Author</p>
			<?php echo facetwp_display( 'facet', 'author' ); ?>

			<p class="facet-headings text--caps">Series</p> 
			<?php echo facetwp_display( 'facet', 'series' ); ?>

			<p class="facet-headings text--caps">Topics</p>
			<?php echo facetwp_display( 'facet', 'topics' );?>
		</div>

		<?php

		if (class_exists('ACF') && !is_paged()) {
			// vars
			$featured_post = get_field('featured_post', $term);
			if ( $featured_post ) {

				echo '<section class="archive__featured">';
					echo '<h2 class="archive__featured-label">Featured</h2>';
					foreach( $featured_post as $post ):
						// Setup this post for WP functions (variable must be named $post).
						setup_postdata($post);
						// get_template_part( 'template-parts/block-post-featured' );
						get_template_part( 'template-parts/block', get_post_type() );
					endforeach;
				echo "</section>";
				// Reset the global post object so that the rest of the page works correctly.
				wp_reset_postdata();
			}
		}

		if ( have_posts() ) {
			echo '<section class="archive__base">';
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/block', get_post_type() );
			}
			echo "</section>";
			wp_reset_postdata();
		}
		get_template_part( 'template-parts/pagination' );
	?>
	</div>

</main><!-- #site-content -->

<?php
get_footer();
