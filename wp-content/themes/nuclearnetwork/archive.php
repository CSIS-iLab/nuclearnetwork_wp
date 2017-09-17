<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

get_header();

if ( is_home() && get_option( 'page_for_posts' ) ) {
	$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_option( 'page_for_posts' ) ), 'full' );
	$featured_img = ' style="background-image:url(\'' . esc_attr( $img[0] ) . '\');"';
}

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<header class="page-header"<?php echo $featured_img; ?>>
				<div class="header-content">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</div>
				<div class="content-wrapper">
					<?php echo do_shortcode( '[searchandfilter taxonomies="category,post_tag"]' ); ?>
				</div>
			</header><!-- .page-header -->

			<div class="content-wrapper row archive-container">
				<div class="col-xs-12 col-md-9 archive-content">
				<?php
				if ( have_posts() ) :

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
