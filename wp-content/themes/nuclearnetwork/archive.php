<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

get_header();

$img = get_archive_thumbnail_src( 'full' );
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
				<div class="content-wrapper">
					<?php echo do_shortcode( '[searchandfilter slug="analysis-search"]' ); ?>
				</div>
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
						get_template_part( 'template-parts/content', get_post_format() );

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
