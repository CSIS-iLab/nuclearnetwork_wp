<?php
/**
 * Displays the featured image on light entry headers
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

$is_singular = is_singular();
$is_front_page = is_front_page();

if ( has_post_thumbnail() && ! post_password_required() && !is_page_template( 'templates/template-no-image.php' ) ) {

	$caption = get_the_post_thumbnail_caption();

	?>

	<figure class="featured-media">
		<div class="featured-media__image-wrapper">

		<?php
			if ( !$is_singular || $is_front_page ) {
				echo '<a href="' . esc_url ( get_permalink() ) . '">';
			}

			the_post_thumbnail();

			if ( !$is_singular || $is_front_page ) {
				echo '</a>';
			}
		?>
		</div>
		<?php

			if ( $caption ) {
				echo '<div class="featured-media__caption">' . esc_html( $caption ) . '</div>';
			}
		?>
	</figure><!-- .featured-media -->

	<?php
}
