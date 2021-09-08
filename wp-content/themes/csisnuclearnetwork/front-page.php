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
	<?php
	$excluded_featured_post_ids_from_recent = array();
	$featured_posts = get_field( 'featured_posts' );

	if ( $featured_posts ) :

		echo '<section class="home__featured-primary">';
		echo '<h2 class="home__featured-primary-label">Featured</h2>';

		foreach ( $featured_posts as $post ) :
			$excluded_featured_post_ids_from_recent[] = $post->ID;

			setup_postdata( $post );
			get_template_part( 'template-parts/block', get_post_type() );

		endforeach;

		wp_reset_postdata();

		echo '</section>';

	endif;
	?>

<section class="home__cta">
	<a href="/analysis" class="btn btn--outline-dark btn--large">All Posts <?php echo nuclearnetwork_get_svg( "chevron-right" ); ?></a>
	<a href="/analysis" class="btn btn--outline-blue btn--small">All Posts <?php echo nuclearnetwork_get_svg( "chevron-right" ); ?></a>
	<a href="/analysis" class="btn btn--blue btn--large">All Posts <?php echo nuclearnetwork_get_svg( "chevron-right" ); ?></a>
	<a href="/analysis" class="btn btn--teal btn--large">All Posts <?php echo nuclearnetwork_get_svg( "chevron-right" ); ?></a>
</section>

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
	<?php get_template_part( 'template-parts/newsletter-block-acf' ); ?>
	<?php get_template_part( 'template-parts/home-featured-programs' ); ?>
	<?php get_template_part( 'template-parts/home-about-poni' ); ?>

</main><!-- #site-content -->

<?php get_footer(); ?>
