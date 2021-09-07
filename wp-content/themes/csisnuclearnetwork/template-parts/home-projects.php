<?php
/**
 * Template for showing Projects on the home page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

?>

<section class="home__projects">
	<header class="home__projects-header">
		<h2 class="home__subtitle home__subtitle--border">Projects</h2>
		<a href="/projects/" class="home__archive-link">
			All Projects
			<?php echo nuclearnetwork_get_svg( "chevron-right" ); ?>
		</a>
	</header>
	<?php
	$featured_projects = get_field( 'featured_projects' );
	if ( $featured_projects ) :
		echo '<div class="js-splide splide">
		<div class="splide__arrows">
			<button class="splide__arrow splide__arrow--prev">
				' . nuclearnetwork_get_svg( "arrow-long-left" ) . '
			</button>
			<button class="splide__arrow splide__arrow--next">
				' . nuclearnetwork_get_svg( "arrow-long-right" ) . '
			</button>
		</div>
		<div class="splide__track">
		<ul class="home__projects-list splide__list" role="list">';
		foreach ( $featured_projects as $post ) :
			setup_postdata ( $post ); ?>
			<li class="home__projects-item splide__slide">
				<a href="<?php the_permalink(); ?>" class="home__projects-img"><?php the_post_thumbnail(); ?></a>
				<?php the_title( '<h3 class="home__projects-title text--bold"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>
				<?php the_excerpt(); ?>
			</li>
		<?php
		endforeach;
		wp_reset_postdata();
		echo "</ul></div></div>";
		endif;
	?>
</section>
