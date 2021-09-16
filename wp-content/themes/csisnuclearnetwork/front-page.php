<?php
/**
 * The template for displaying the home page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

get_header();
?>

<main id="site-content" role="main">
	<div class="home__top">
	<!-- set up excluded posts array – important because it is used by template-parts/home-recent-section -->
	<?php
	$excluded_featured_post_ids_from_recent = array();
	$featured_posts = get_field( 'featured_posts' );
	if ( $featured_posts ) :
		foreach ( $featured_posts as $post ) :
			$excluded_featured_post_ids_from_recent[] = $post->ID;
		endforeach;
	endif;
	?>

	<?php get_template_part( 'template-parts/home-featured-posts', null, $featured_posts ); ?>

	<?php
	$featured_content = get_field('featured_content');

	if ( $featured_content ) :
		echo '<section class="home__featured-content" style="background-image:url(' . esc_url($featured_content['image']['url']) . ');">';
			echo '<div class="home__featured-content-wrapper">';
				echo '<h2 class="home__featured-content-title">' . $featured_content['title'] . '</h2>';
				echo '<div class="home__featured-content-desc">' . $featured_content['description'] . '</div>';
				echo '<a class="home__featured-content-link btn btn--outline-light btn--small" href="' . $featured_content['url'] . '">Browse our resources' . nuclearnetwork_get_svg( "chevron-right" ) . '</a>';
			echo '</div>';
		echo '</section>';
	endif;

	?>
	<?php get_template_part( 'template-parts/home-recent-section', null, $excluded_featured_post_ids_from_recent); ?>
	<?php get_template_part( 'template-parts/home-projects' ); ?>
	</div>
	<?php get_template_part( 'template-parts/newsletter-block-acf' ); ?>
	<?php get_template_part( 'template-parts/home-featured-programs' ); ?>
	<?php get_template_part( 'template-parts/home-pungh' ); ?>
	<?php get_template_part( 'template-parts/home-about-poni' ); ?>

</main><!-- #site-content -->

<?php get_footer(); ?>
