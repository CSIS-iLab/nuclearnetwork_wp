<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Nuclear_Network
 */

get_header();

$img = get_option( 'nuclearnetwork_category_and_tag_archive_image' );
$featured_img = ' style="background-image:url(\'' . esc_attr( $img ) . '\');"';
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<header class="page-header"<?php echo $featured_img; ?>>
				<div class="header-content">
					<div class="archive-category"><p><?php echo esc_html_x( 'Search Results for', 'nuclearnetwork' ); ?></p></div>
					<h1 class="page-title"><?php echo get_search_query(); ?></h1>
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

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						
						if( in_array( get_post_type(), array( 'post', 'events', 'opportunities', 'resources', 'announcements' ), true ) ) {
							get_template_part( 'template-parts/content', get_post_type() );
						} else {
							get_template_part( 'template-parts/content', 'search' );
						}

					endwhile;

					the_posts_pagination();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
				</div>
				<div class="col-xs-12 col-md-3 archive-sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
