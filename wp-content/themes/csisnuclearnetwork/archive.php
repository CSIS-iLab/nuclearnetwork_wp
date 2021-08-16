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
		if ( have_posts() ) {
			// Pagination Results & Filters
			if ( class_exists( 'FacetWP') && $show_filters ) {
				echo facetwp_display( 'facet', 'pagination_results' );

				nuclearnetwork_archive_filters( array(
					'show_content_types' => !$is_analysis_archive,
					'show_analysis_subtypes' => $is_analysis_archive
				));

			} else {
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
				get_template_part( 'template-parts/block-post', get_post_type() );
			}
			wp_reset_postdata();
			get_template_part( 'template-parts/pagination' );
			echo "</section>";
		}

		// Pagination
		if ( class_exists( 'FacetWP') && $show_filters ) {
			echo facetwp_display( 'facet', 'pagination_navigation' );
		} else {
			get_template_part( 'template-parts/pagination' );
		}

		if (class_exists('ACF') && !is_paged()) {
			$cards = get_field('card', $term);

			if ( $cards ) { ?>
				<div class="cards__container">
				<?php foreach( $cards as $card) {
					if ( $card['card_description'] ) {

						$link = $card['page_link'];
						?>
					<div class='card' style="background-image: url('<?php echo esc_url($card['background_image']); ?>');">
						<a href="<?php echo esc_url($link['url'])  ?>" class="card__link">
							<?php if($card['card_title']) {
								echo '<h2 class="card__title">' . $card['card_title'] . '</h2>';
							} else {
								echo '<h2 class="card__title">' . $link['title'] . '</h2>';
							} ?>
							<?php echo '<p class="card__description">' . nuclearnetwork_get_svg( 'single-arrow' ) . $card['card_description'] . '</p>'; ?>
						</a>
					</div><!-- .card -->
				<?php }
				} ?>
			</div><!-- .cards__container -->
			<?php
			}
		}
	?>
	</div>

</main><!-- #site-content -->

<?php
get_footer();
