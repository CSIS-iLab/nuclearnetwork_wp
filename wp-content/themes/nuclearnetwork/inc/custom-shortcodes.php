<?php
/**
 * Custom Shortcodes
 *
 * @package Nuclear_Network
 */


/**
 * Displays table of contents heading for report posts.
 *
 * @return String       Formatted Table of Contents heading.
 */
function nuclearnetwork_shortcode_toc() {
	return '<h4 class="toc-heading">' . esc_html( 'Table of Contents', 'nuclearnetwork' ) . '</h4><p class="toc-desc">' . esc_html( 'Click on link to jump to section summary.', 'nuclearnetwork' ) . '</p>';
}
add_shortcode( 'toc', 'nuclearnetwork_shortcode_toc' );

/**
 * Displays Read in Publication link for reports.
 *
 * @param  array $atts Attributes: Page Number.
 * @return String       Formatted Read in Publication link.
 */
function nuclearnetwork_shortcode_read_pdf( $atts ) {
	$atts = shortcode_atts(
		array(
			'page' => '1', // Page number to link to.
		),
		$atts,
		'readPDF'
	);

	$view_url = get_post_meta( get_the_ID(), '_post_view_url', true );

	return '<div class="toc-read-publication"><a href="' . $view_url . '#page=' . $atts['page'] . '" target="_blank">' . esc_html( 'Read in Publication', 'nuclearnetwork' ) . ' <i class="icon-arrow-right"></i></a></div>';
}
add_shortcode( 'readPDF', 'nuclearnetwork_shortcode_read_pdf' );
