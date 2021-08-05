<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

?>

<section class="home__about">
	<div class="home__about-container">
		<div class="home__about-item">
			<h3 class="home__about-title">About PONI</h3>
            <hr>
			<?php 
				$poni_description = get_field('poni_description');
			?>
			<p class="home__about-description"><?php echo esc_html( $poni_description ) ?></p>
			<div class="home__about-directorblock">
				<?php 
				global $coauthors_plus;
				$info = get_field('director_and_deputy_director')[0];
				$name = $info->post_title;
				$bio = $info->short_bio;
				$coauthor_data = $coauthors_plus->get_coauthor_by( 'id', $info->ID );
				echo coauthors_get_avatar( $coauthor_data, "100" );
				?>
				<div>
					<h4><?php echo esc_html( $name ); ?></h4>
					<p><?php echo esc_html( $bio ); ?></p>
				</div>
			</div>
			<div class="home__about-directorblock">
				<?php 
				global $coauthors_plus;
				$info2 = get_field('director_and_deputy_director')[1];
				$name2 = $info2->post_title;
				$bio2 = $info2->short_bio;
				$coauthor_data = $coauthors_plus->get_coauthor_by( 'id', $info2->ID );
				echo coauthors_get_avatar( $coauthor_data, "100" );
				?>
				<div>
					<h4><?php echo esc_html( $name2 ); ?></h4>
					<p><?php echo esc_html( $bio2 ); ?></p>
				</div>
			</div>
		</div>
		<div class="home__about-item">
			<figure>
				<?php 
				$team_photo = get_field('team_photo');
				?>
				<img class="home__about-familyphoto" src="<?php echo esc_url($team_photo['url']);?>" alt="<?php echo $team_photo['alt'] ?>">
				<figcaption><?php echo $team_photo['caption'];?></figcaption>
			</figure>
		</div>
	</div>
</section> 