<?php
/**
 * Single Post: Alumni
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Nuclear_Network
 */

$id = $post->ID;

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'sidebar-left header-simple footer-simple' ); ?>>
				<div class="content-wrapper">
					<header class="entry-header">
						<div class="title-container">
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						</div>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<div class="post-sidebar">
							<?php
							nuclearnetwork_post_format( $id );
							?>
							<?php
							if ( has_post_thumbnail() ) {
								echo '<div class="post-thumbnail">';
								the_post_thumbnail( 'thumbnail' );
								echo '</div>';
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
						<a href="/next-generation/" class="alumni btn btn-blue">Back To Next Gen</a>
						</div>
					</div><!-- .entry-content -->
				</div>

				<footer class="entry-footer">

				</footer><!-- .entry-footer -->
			</article><!-- #post-<?php the_ID(); ?> -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
