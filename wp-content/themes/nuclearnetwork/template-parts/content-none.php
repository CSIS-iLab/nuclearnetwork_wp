<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

?>

<section class="no-results not-found">
	<header class="entry-header">
		<h2 class="entry-title"><?php esc_html_e( 'No Results Found', 'nuclearnetwork' ); ?></h1>
	</header><!-- .page-header -->

	<div class="entry-content">
		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords or filtering options.', 'nuclearnetwork' ); ?></p>
		<?php get_search_form(); ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
