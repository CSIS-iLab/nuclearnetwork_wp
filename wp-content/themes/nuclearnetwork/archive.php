<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

get_header();

if ( is_category() || is_tag() ) {
	$img = get_option( 'nuclearnetwork_category_and_tag_archive_image' );
} elseif ( is_author() ) {
	$img = get_option( 'nuclearnetwork_authors_archive_image' );
} else {
	$img = get_archive_thumbnail_src( 'full' );
}

$featured_img = ' style="background-image:url(\'' . esc_attr( $img ) . '\');"';

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<header class="page-header"<?php echo $featured_img; ?>>
				<div class="header-content">
					<?php
						echo '<div class="archive-category">';
						the_archive_top_content();
						echo '</div>';
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
						echo '<div class="archive-description">';
						the_archive_bottom_content();
						echo '</div>';
					?>
				</div>
				<?php echo nuclearnetwork_archive_search(); ?>
			</header><!-- .page-header -->

			<div class="content-wrapper row archive-container">
				<div class="col-xs-12 col-md-9 archive-content">
				<?php
				if ( have_posts() ) :

					nuclearnetwork_post_num();

					if ( is_post_type_archive( 'resources' ) ) {
						$types = get_terms( 'resource_types' );
						foreach ( $types as $type ) {
							$resource_posts = new WP_Query( array(
								'post_type' => 'resources',
								'tax_query' => array(
									array(
										'taxonomy' => 'resource_types',
										'field' => 'slug',
										'terms' => array( $type->slug ),
										'operator' => 'IN',
									),
								),
								'orderby' => 'title',
								'order' => 'ASC',
							) );

							while ( $resource_posts->have_posts() ) : $resource_posts->the_post();
								get_template_part( 'template-parts/content', 'resources' );
							endwhile;
							unset( $resource_posts );
							wp_reset_postdata();
						}
					} else {
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_type() );

						endwhile;
					}

					the_posts_pagination();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;

				nuclearnetwork_event_future_past_link();

				?>
				</div>
				<div class="col-xs-12 col-md-3 archive-sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
