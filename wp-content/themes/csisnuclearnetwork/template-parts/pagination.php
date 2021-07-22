<?php
/**
 * A template partial to output pagination for the Nuclear Network default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

/**
 * Translators:
 * This text contains HTML to allow the text to be shorter on small screens.
 * The text inside the span with the class nav-short will be hidden on small screens.
 */

$first_text = sprintf(
	'<span aria-hidden="true">%s</span> <span class="screen-reader-text">%s</span>',
	nuclearnetwork_get_svg( 'chevron-line-left' ),
	__( 'First Post', 'nuclearnetwork' )
);

$last_text = sprintf(
	'<span aria-hidden="true">%s</span> <span class="screen-reader-text">%s</span>',
	nuclearnetwork_get_svg( 'chevron-line-right' ),
	__( 'Last Post', 'nuclearnetwork' )
);

$prev_text = sprintf(
	'<span aria-hidden="true">%s</span> <span class="screen-reader-text">%s</span>',
	nuclearnetwork_get_svg( 'chevron-left' ),
	__( 'Newer Posts', 'nuclearnetwork' )
);

$next_text = sprintf(
	'<span class="screen-reader-text">%s</span> <span aria-hidden="true">%s</span>',
	__( 'Older Posts', 'nuclearnetwork' ),
	nuclearnetwork_get_svg( 'chevron-right' )
);

$posts_pagination = get_the_posts_pagination(
	array(
		'mid_size'  => 1,
		'prev_text' => $prev_text,
		'next_text' => $next_text,
	)
);

// If we're not outputting the previous page link, prepend a placeholder with visibility: hidden to take its place.
if ( strpos( $posts_pagination, 'prev page-numbers' ) === false ) {
	$posts_pagination = str_replace( '<div class="nav-links">', '<div class="nav-links"><span class="prev page-numbers placeholder" aria-hidden="true">' . $prev_text . '</span>', $posts_pagination );
}

// If we're not outputting the next page link, append a placeholder with visibility: hidden to take its place.
if ( strpos( $posts_pagination, 'next page-numbers' ) === false ) {
	$posts_pagination = str_replace( '</div>', '<span class="next page-numbers placeholder" aria-hidden="true">' . $next_text . $last_text . '</span></div>', $posts_pagination );
}

if ( $posts_pagination ) { ?>

	<div class="pagination__wrapper">
	<?php
		if($pages == '')
		{
				global $wp_query;
				$pages = $wp_query->max_num_pages;
				if(!$pages)
				{
						$pages = 1;
				}
		} 

		if ( $paged != 1 ) {
			echo "<a href='".get_pagenum_link(1)."' class='yo'>$first_text</a>";
		}

		echo $posts_pagination; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already escaped during generation.
		
		if ($paged != $pages) {
			echo "<a href='".get_pagenum_link($pages)."' class='yo'>$last_text</a>";  
		}
	?>
	</div><!-- .pagination-wrapper -->

	<?php
}
