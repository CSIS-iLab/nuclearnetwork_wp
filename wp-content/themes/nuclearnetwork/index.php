<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

get_header();

if ( is_home() && get_option( 'page_for_posts' ) ) {
	$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_option( 'page_for_posts' ) ), 'full' );
	$featured_img = ' style="background-image:url(\'' . esc_attr( $img[0] ) . '\');"';
	$archive_desc = get_option( 'nuclearnetwork_analysis_desc' );
	$archive_category = get_option( 'nuclearnetwork_analysis_category' );
}

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<header class="page-header"<?php echo $featured_img; ?>>
				<div class="header-content">
					<?php
						echo '<div class="archive-category">';
						echo '<p>' . esc_html( $archive_category ) . '</p>';
						echo '</div>';
						echo '<h1 class="page-title">' . esc_html( 'Analysis', 'nuclearnetwork' ) . '</h1>';
						echo '<div class="archive-description">';
						echo '<p>' . esc_html( $archive_desc ) . '</p>';
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

					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_type() );

					endwhile;

					the_posts_pagination();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
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
