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
			<p class="home__about-description">The Project on Nuclear Issues (PONI) at the Center for Strategic and International Studies aims to develop the next generation of policy, technical, and operational nuclear professionals through outreach, mentorship, research, and debate.</p>
			<div class="home__about-directorblock">
				<img src="<?php esc_url( wp_get_attachment_image_src( $img->avatar, 'large' ) ); ?>" alt="">
				<img src="<?php echo get_avatar_url($img); ?>" alt="">
				<?php 
				// working
				$info = get_field('director_and_deputy_director')[0];
				$name = $info->post_title;
				$bio = $info->short_bio;
				// not working
				$authorid = $info->ID;
				$coauthors = get_coauthors();
				foreach( $coauthors as $coauthor ) {
					// var_dump($coauthor);
					if ($coauthor->id == $authorid) {
						var_dump($authorid);
					} else {
						print_r("not working");
					};
					echo $coauthor->ID;
					echo $authorid;
					echo coauthors_get_avatar(get_the_author_meta( $coauthor->ID ));
				}
				$img = $info->post_author;
				$avatar = coauthors_get_avatar( get_the_author_meta($img), 150 );
				// var_dump($info);
				// var_dump($info->avatar);
				?>
				<div>
					<h4><?php echo esc_html( $name ); ?></h4>
					<p><?php echo esc_html( $bio ); ?></p>
				</div>
			</div>
			<div class="home__about-directorblock">
				<?php 
				$info2 = get_field('director_and_deputy_director')[1];
				$name2 = $info2->post_title;
				$bio2 = $info2->short_bio;
				$img2 = $info2->ID;
				?>
				<img src="/wp-content/themes/csisnuclearnetwork/assets/img/image-404.jpg" alt="">
				<?php echo get_avatar(get_the_author_meta( $img2 ), 100); ?>
				<div>
					<h4><?php echo esc_html( $name2 ); ?></h4>
					<p><?php echo esc_html( $bio2 ); ?></p>
				</div>
			</div>
		</div>
		<div class="home__about-item">
			<img class="home__about-familyphoto" src="wp-content/themes/csisnuclearnetwork/assets/img/staff.png" alt="">
			<caption>Photo Caption</caption>
		</div>
	</div>
</section>