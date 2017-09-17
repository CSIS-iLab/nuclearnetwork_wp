<?php
/**
 * Template Name: Page with Left Sidebar
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'sidebar-left' ); ?>>
				<div class="content-wrapper">
					<div class="post-img-container">
						<?php the_post_thumbnail( 'full' ); ?>
						<div class="caption">
							<?php the_post_thumbnail_caption(); ?>
						</div>
					</div>
					<header class="entry-header">
						<div class="title-container">
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						</div>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<div class="post-sidebar">
							<?php
							if ( get_post_meta( $post->ID, '_post_sidebar' ) ) {
								echo wp_kses_post( get_post_meta( $post->ID, '_post_sidebar', true ) );
							}
							?>
							<?php get_template_part( 'share-inline' ); ?>
						</div>
						<div class="post-content">
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
					</div><!-- .entry-content -->
				</div>

				<footer class="entry-footer content-wrapper">
					<?php
					if ( get_post_meta( $post->ID, '_post_footer' ) ) {
						echo wp_kses_post( get_post_meta( $post->ID, '_post_footer', true ) );
					}
					?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-<?php the_ID(); ?> -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
