<?php
/**
 * Displays the featured image
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

$is_singular = is_singular();
$is_front_page = is_front_page();

if ( has_post_thumbnail() && ! post_password_required() ) {

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
	</figure><!-- .featured-media -->

	<?php
}
