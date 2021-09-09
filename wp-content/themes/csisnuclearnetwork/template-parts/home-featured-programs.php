<?php
/**
 * Display featured programs
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

?>

<section class='home__programs'>
	<h2 class='home__subtitle home__subtitle--border'>Programs</h2>
	<a href='<?php home_url() ?>/programs/' class="home__archive-link text--link">All Programs <?php echo nuclearnetwork_get_svg( 'chevron-right' ); ?></a>
	<?php
	$featured_programs = get_field( 'featured_programs' );
	if ( $featured_programs ) :
		echo "<ul class='home__programs-list' role='list'>";
		foreach ( $featured_programs as $post ) :
			setup_postdata ( $post ); ?>
			<li>
				<?php the_title( '<h3 class="home__programs-title text--bold"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>
				<?php the_excerpt(); ?>
			</li>
		<?php
		endforeach;
		wp_reset_postdata();
		echo "</ul>";
		endif;
	?>
</section>
