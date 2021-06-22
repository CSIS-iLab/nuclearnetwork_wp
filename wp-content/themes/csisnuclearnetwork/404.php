<?php
/**
 * The template for displaying the 404 template in the Reconnecting Asia theme.
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

get_header();
?>

<main id="site-content" role="main">

	<?php

		get_template_part( 'template-parts/entry-header' );

	?>

	<div class="error-404">

		<div class="error-404__content">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/image-404.jpg" alt="<?php bloginfo('name'); ?> 404" title="<?php bloginfo('name'); ?> 404" />

			<h1 class="error-404__title"><?php _e( '404', 'nuclearnetwork' ); ?></h1>
			<h1 class="error-404__subtitle error-404__text-spacing"><?php _e( 'Page Not Found', 'nuclearnetwork' ); ?></h1>

			<div class="intro-text">
				<p class="error-404__text-spacing"><?php _e( 'The page you are looking for was moved, removed, renamed, or might never have existed. We apologize for the inconvenience!', 'nuclearnetwork' ); ?></p>
				<p class="error-404__text-spacing"><?php _e( 'Instead, visit our homepage for the latest, or use the search tool above.', 'nuclearnetwork' ); ?></p>
			</div>
		</div>

	</div><!-- .section-inner -->

</main><!-- #site-content -->

<?php
get_footer();
