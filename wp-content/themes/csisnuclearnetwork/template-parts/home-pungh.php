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

$program_updates_archive = get_field( 'program_updates_archive' );

$updates_args = array(
	'posts_per_page' => 3,
	'post_type'   => 'updates',
	'post_status' => 'publish',
	'date_query' => array(
		array(
			'column' => 'post_date_gmt',
			'after'  => '90 days ago',
		)
	)
);
$updates_posts = new WP_Query( $updates_args );
?>

<section class="home__pungh">
  <div class="home__pu">
		<h2 class="home__subtitle--sm">PONI Updates</h2>
		<?php if ( $program_updates_archive ) : ?>
			<a href="<?php echo esc_url( $program_updates_archive); ?>" class="home__archive-link text--link">
				<?php
					the_field( 'program_updates_cta' );
					echo nuclearnetwork_get_svg( "chevron-right" );
				?>
			</a>
		<?php endif; ?>

		<?php
		if ( !empty($updates_posts->posts) ) {
			echo "<ul class='home__pu-list' role='list'>";
			// cycle through and output all events
			while ( $updates_posts->have_posts() ) {
				$updates_posts->the_post();
				echo '<li>';
				echo '<a href="' . get_permalink() . '" class="home__pungh-title">' . get_the_title() . '</a>';
				nuclearnetwork_posted_on('M j, Y');
				echo '</li>';
			}
			wp_reset_postdata();
			echo "</ul>";
		} else {
			echo '<p class="home__pu-no-results post-block__excerpt">' . get_field('program_updates_no_results') . '</p>';
		}
		?>

	</div>

	<?php
	if( have_rows('next_gen_highlights') ):
    echo '<div class="home__ngh"><h2 class="home__subtitle--sm">Next Gen Highlights</h2>';
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
				<a href="<?php echo esc_url($url); ?>" class="home__ngh-img" aria-hidden="true"><?php echo wp_get_attachment_image( $image, 'medium' ); ?></a>
				<a href="<?php echo esc_url($url); ?>" class="home__pungh-title"><?php echo esc_html($name); ?></a>
				<p class="post-block__excerpt"><?php the_sub_field('next_gen_description'); ?></p>
			</li>
		<?php
		endwhile;
		echo "</ul></div></div></div>";
		endif;
	?>
</section>
