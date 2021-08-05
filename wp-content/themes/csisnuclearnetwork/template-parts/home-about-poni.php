<?php
/**
 * The about PONI section of the home page,
 * including information about directors and a team photo
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

 global $coauthors_plus;

?>

<section class="home__about">
	<div class="home__about-content">
		<h2 class="home__subtitle home__subtitle--border">About PONI</h2>
		<?php 
			$poni_description = get_field('poni_description');
		?>
		<p class="home__about-description text--short"><?php echo esc_html( $poni_description ) ?></p>
		<?php
			$director_and_deputy_director = get_field( 'director_and_deputy_director' );
			if ( $director_and_deputy_director ) :
				echo '<dl class="home__about-people">';
				foreach ( $director_and_deputy_director as $post ) :
					setup_postdata ( $post );
					$coauthor_data = $coauthors_plus->get_coauthor_by( 'id', $post->ID );

				?>
				<div class='home__about-person'>
					<dt class="home__about-person-title text--bold"><?php the_title(); ?></dt>
					<dd class="home__about-person-bio"><?php the_field( 'short_bio' ); ?></dd>
					<dd class="home__about-person-image"><?php echo coauthors_get_avatar( $coauthor_data, "100" ); ?></dd>
				</div>
				<?php 
				endforeach; 
				wp_reset_postdata();
				echo '</dl>';
			endif;
		?>
	</div>
	<figure class="home__about-familyphoto">
		<?php 
		$team_photo = get_field('team_photo');
		?>
		<img src="<?php echo esc_url($team_photo['url']);?>" alt="<?php echo $team_photo['alt'] ?>">
		<figcaption><?php echo $team_photo['caption'];?></figcaption>
	</figure>
</section> 