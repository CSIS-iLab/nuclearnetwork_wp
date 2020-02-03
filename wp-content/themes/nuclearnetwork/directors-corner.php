<?php
/**
 * The template for the Director's Corner 
 *
 * Template Name: Director's Corner
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

get_header();

// $wp_query = new WP_Query(array(
//   'author_name' => 'rebecca-hersman'
// ));

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
					nuclearnetwork_directors_list();
   
					// Don't show description on author pages because the bios are too long.
					if ( ! is_author() ) {
						echo '<div class="archive-description">';
						the_archive_bottom_content();
						echo '</div>';
					}
					?>
				</div>
			
			</header><!-- .page-header -->

			<div class="content-wrapper row archive-container">
				<div class="col-xs-12 col-md-9 archive-content">
				<?php

				// Show description in post section if author page.
				if ( is_author() ) {
					echo '<h2>About the Author</h2>';
					the_archive_description( '<div class="archive-description">', '</div>' );
				}

				if ( have_posts() ) :

					nuclearnetwork_post_num();

					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content-alumni', get_the_excerpt() );

					endwhile;

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
