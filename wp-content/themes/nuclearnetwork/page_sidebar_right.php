<?php
/**
 * Template Name: Page with Right Sidebar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

get_header();

if ( has_post_thumbnail() ) {
	$img = get_the_post_thumbnail_url();
	$featured_img = ' style="background-image:url(\'' . esc_attr( $img ) . '\');"';
}

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<header class="page-header"<?php echo $featured_img; ?>>
				<div class="header-content">
					<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
				</div>
			</header><!-- .page-header -->

			<div class="content-wrapper row archive-container">
				<div class="col-xs-12 col-md-9 archive-content">
				<?php
					the_content( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'nuclearnetwork' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					) );
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
