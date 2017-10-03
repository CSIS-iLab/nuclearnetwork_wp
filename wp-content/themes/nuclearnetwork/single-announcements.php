<?php
/**
 * The template for displaying all single announcements
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Nuclear_Network
 */

$id = $post->ID;

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
						<?php the_excerpt(); ?>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<div class="post-sidebar">
							<?php
							nuclearnetwork_post_format( $id );
							nuclearnetwork_authors_list();
							nuclearnetwork_posted_on();
							nuclearnetwork_entry_categories();
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

				<footer class="entry-footer">
					<div class="content-wrapper row">
						<div class="post-about-authors col-xs-12">
							<?php nuclearnetwork_authors_list_extended(); ?>
						</div>
					</div>
					<div class="post-related-container">
						<div class="content-wrapper row">
							<div class="col-xs-12">
								<h4 class="related-header"><?php echo esc_html_x( 'Related Reading', 'nuclearnetwork' ); ?></h4>
							</div>
							<?php
							if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
								echo do_shortcode( '[jprel]' );
							}
							?>
							<div class="col-xs-12 col-md">
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
