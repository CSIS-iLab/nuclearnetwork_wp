<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Nuclear_Network
 */

$id = $post->ID;
$sources = get_post_meta( $id, '_post_sources', true );

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<div class="content-wrapper row">
						<div class="col-xs-12 col-md-6">
							<?php
								the_title( '<h1 class="entry-title">', '</h1>' );
								the_excerpt();
							?>
						</div>
						<div class="col-xs-12 col-md-6">
							Thumbnail
						</div>
					</div>
				</header><!-- .entry-header -->

				<div class="entry-content content-wrapper row">
					<div class="post-sidebar col-xs-12 col-md-3">
						<?php
						nuclearnetwork_post_format( $id );
						nuclearnetwork_authors_list();
						nuclearnetwork_posted_on();
						nuclearnetwork_entry_categories();
						?>
					</div>
					<div class="post-content col-xs-12 col-md-9">
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
					<?php if ( $sources ) : ?>
					<p class="sources-label">View Sources</p>
					<div class="sources">
						<?php echo wp_kses_post( $sources ); ?>
					</div>
					<?php endif; ?>

					</div>
				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<div class="content-wrapper row">
						<div class="post-about-authors col-xs-12 col-sm-9">
							<?php nuclearnetwork_post_disclaimer( $id ); ?>
							About the Authors
						</div>
						<div class="post-write col-xs-12 col-sm-3">
							<?php nuclearnetwork_post_write(); ?>
						</div>
					</div>
					<div class="post-related-container">
						<div class="content-wrapper row">
							<div class="col-xs-12">
								<h4 class="related-header"><?php echo esc_html_x( 'Related Reading', 'nuclearnetwork' ); ?></h4>
							</div>
							<div class="col-xs">
								Related Posts
							</div>
							<div class="col-xs">
								<?php nuclearnetwork_entry_tags(); ?>
							</div>
						</div>
					</div>
				</footer><!-- .entry-footer -->
			</article><!-- #post-<?php the_ID(); ?> -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
