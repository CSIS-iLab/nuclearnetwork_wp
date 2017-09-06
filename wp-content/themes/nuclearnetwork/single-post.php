<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Nuclear_Network
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<div class="content-wrapper row">
						<div class="col-xs-12 col-md-6">
							<?php
								the_title( '<h1 class="entry-title">', '</h1>' );

							if ( 'post' === get_post_type() ) : ?>
							<div class="entry-meta">
								<?php nuclearnetwork_posted_on(); ?>
							</div><!-- .entry-meta -->
							<?php
							endif; ?>
						</div>
						<div class="col-xs-12 col-md-6">
							Thumbnail
						</div>
					</div>
				</header><!-- .entry-header -->

				<div class="entry-content content-wrapper row">
					<div class="col-xs-12 col-md-3">Sidebar</div>
					<div class="col-xs-12 col-md-9">
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

				<footer class="entry-footer">
					<?php nuclearnetwork_entry_footer(); ?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-<?php the_ID(); ?> -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
