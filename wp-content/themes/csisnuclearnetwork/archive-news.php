<?php
/**
 * The Archive template.
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

$current_year = get_query_var('year', date('Y'));
$current_month = get_query_var('monthnum', date('m'));

$date = date("F Y", strtotime($current_year . "-" . $current_month . "-01"));

get_header();
?>

<main id="site-content" role="main">

	<?php
		get_template_part( 'template-parts/entry-header' );
	?>

	<div class='archive__content'>
		<h2 class="archive__subheading"><?php echo $date; ?> Nuclear Policy News</h2>
		<p class="archive__disclaimer text--short">Select the date to view the newsletter in the Nuclear Policy News archive.</p>

	<?php
		if ( have_posts() ) {
      echo "<aside class='archive__sidebar'>";
      dynamic_sidebar( 'nuclear-policy-news' );
      echo "</aside>";
		}

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
	?>
	</div>

</main><!-- #site-content -->

<?php
get_footer();
