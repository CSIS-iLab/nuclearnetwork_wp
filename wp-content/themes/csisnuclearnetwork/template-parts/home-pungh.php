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

$project_archive_page = get_field( 'project_archive_page' );

?>

<div class="home__pungh">
  Program Updates
	<header class="home__projects-header">
		<h2 class="home__subtitle home__subtitle--border">Projects</h2>
		<?php if ( $project_archive_page ) : ?>
			<a href="<?php echo esc_url( $project_archive_page); ?>" class="home__archive-link text--link">
				<?php
					the_field( 'project_archive_cta' );
					echo nuclearnetwork_get_svg( "chevron-right" );
				?>
			</a>
		<?php endif; ?>
	</header>
	<?php
	if( have_rows('next_gen_highlights') ):
    echo '<div class="home__ngh"><h2 class="home__subtitle">Next Gen Highlights</h2>';
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
		<ul class="home__ngh-list splide__list" role="list">';
		while( have_rows('next_gen_highlights') ): the_row();
			$image = get_sub_field('next_gen_image');
			$link = get_sub_field('next_gen_link');
			$url = $link['url'];
			$name = $link['title'];
			?>
			<li class="home__ngh-item splide__slide">
				<a href="<?php echo esc_url($url); ?>" class="home__ngh-img"><?php echo wp_get_attachment_image( $image, 'medium' ); ?></a>
				<h3 class="home__ngh-title text--bold"><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($name); ?></a></h3>
				<p class="post-block__excerpt"><?php the_sub_field('next_gen_description'); ?></p>
			</li>
		<?php
		endwhile;
		echo "</ul></div></div></div>";
		endif;
	?>
</div>
