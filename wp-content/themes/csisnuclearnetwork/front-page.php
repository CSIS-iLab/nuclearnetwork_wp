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
$poni_description = get_field('poni_description');
$poni_about_page = get_field('about_poni');
?>

<main id="site-content" role="main">
	<div class="home__top">
		<div class="home__container">
	<!-- set up excluded posts array – important because it is used by template-parts/home-recent-section -->
	<hr class="home__top-border"/>
	<?php
	if ( !empty( $poni_description ) ) { ?>
		<section class="home__poni-description text--short">
			<p>
				<?php echo $poni_description; ?>
			</p>
			<?php if ( $poni_about_page) : ?>
			<a href="<?php echo esc_url( $poni_about_page); ?>" class="home__archive-link text--link">
				<?php
					the_field( 'poni_description_cta' );
					echo nuclearnetwork_get_svg( "chevron-right" );
				?>
			</a>
		<?php endif; ?>
		</section>

	<?php
	}
	?>
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
	</div>
	<?php get_template_part( 'template-parts/newsletter-block-acf' ); ?>
	<?php get_template_part( 'template-parts/home-featured-programs' ); ?>
	<?php get_template_part( 'template-parts/home-pungh' ); ?>
	<?php get_template_part( 'template-parts/home-about-poni' ); ?>

</main><!-- #site-content -->

<?php get_footer(); ?>
