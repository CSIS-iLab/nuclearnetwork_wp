<?php
/**
 * Custom template tags for this theme.
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

/**
 * Table of Contents:
 * Logo & Description
 * Post Meta
 * Menus
 * Classes
 * Archives
 * Miscellaneous
 */

/**
 * Logo & Description
 */
/**
 * Displays the site logo, either text or image.
 *
 * @param array   $args Arguments for displaying the site logo either as an image or text.
 * @param boolean $echo Echo or return the HTML.
 *
 * @return string $html Compiled HTML based on our arguments.
 */
function nuclearnetwork_site_logo( $args = array(), $echo = true ) {
	$logo       = get_custom_logo();
	$site_title = get_bloginfo( 'name' );
	$contents   = '';
	$classname  = '';

	$defaults = array(
		'logo'        => '%1$s<span class="screen-reader-text">%2$s</span>',
		'logo_class'  => 'site-logo',
		'title'       => '<a href="%1$s">%2$s</a>',
		'title_class' => 'site-title',
		'home_wrap'   => '<h1 class="%1$s">%2$s</h1>',
		'wrap' => '<div class="%1$s faux-heading">%2$s</div>',
		'condition'   => ( is_front_page() || is_home() ) && ! is_page(),
	);

	$args = wp_parse_args( $args, $defaults );

	/**
	 * Filters the arguments for `nuclearnetwork_site_logo()`.
	 *
	 * @param array  $args     Parsed arguments.
	 * @param array  $defaults Function's default arguments.
	 */
	$args = apply_filters( 'nuclearnetwork_site_logo_args', $args, $defaults );

	if ( has_custom_logo() ) {
		$contents  = sprintf( $args['logo'], $logo, esc_html( $site_title ) );
		$classname = $args['logo_class'];
	} else {
		$contents  = sprintf( $args['title'], esc_url( get_home_url( null, '/' ) ), esc_html( $site_title ) );
		$classname = $args['title_class'];
	}

	$wrap = $args['condition'] ? 'home_wrap' : 'single_wrap';

	$html = sprintf( $args[ $wrap ], $classname, $contents );

	/**
	 * Filters the arguments for `nuclearnetwork_site_logo()`.
	 *
	 * @param string $html      Compiled html based on our arguments.
	 * @param array  $args      Parsed arguments.
	 * @param string $classname Class name based on current view, home or single.
	 * @param string $contents  HTML for site title or logo.
	 */
	$html = apply_filters( 'nuclearnetwork_site_logo', $html, $args, $classname, $contents );

	if ( ! $echo ) {
		return $html;
	}

	echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}

/**
 * Displays the site description.
 *
 * @param boolean $echo Echo or return the html.
 *
 * @return string $html The HTML to display.
 */
function nuclearnetwork_site_description( $echo = true ) {
	$description = get_bloginfo( 'description' );

	if ( ! $description ) {
		return;
	}

	$wrapper = '<div class="site-description">%s</div><!-- .site-description -->';

	$html = sprintf( $wrapper, esc_html( $description ) );

	/**
	 * Filters the html for the site description.
	 *
	 * @since 1.0.0
	 *
	 * @param string $html         The HTML to display.
	 * @param string $description  Site description via `bloginfo()`.
	 * @param string $wrapper      The format used in case you want to reuse it in a `sprintf()`.
	 */
	$html = apply_filters( 'nuclearnetwork_site_description', $html, $description, $wrapper );

	if ( ! $echo ) {
		return $html;
	}

	echo $html; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Post Meta
 */

/**
 * Displays the page's formatted title.
 *
 *
 * @return string $html The formatted page title.
 */
function nuclearnetwork_formatted_title( $post_id = false ) {
	$formatted_title = get_field('formatted_title', $post_id);

	if ( is_archive() ) {
		$object = get_queried_object();
		$formatted_title = get_field( 'formatted_title', $object->name );
	}

	if ( !$formatted_title ) {
		return;
	}

	printf( '<h1 class="entry-header__title">' . esc_html__( '%1$s', 'nuclearnetwork' ) . '</h1>', $formatted_title ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Displays the post's publish date.
 *
 *
 * @return string $html The post date.
 */
function nuclearnetwork_posted_on( $date_format = null ) {

	// Require post ID.
	if ( ! get_the_ID() ) {
		return;
	}

	$date = get_option( 'date_format' );

	if  ( $date_format ) {
		$date = $date_format;
	}

	echo '<div class="post-meta post-meta__date">' . get_the_time( $date ) . '</div>';
}

/**
 * Displays the post's publish date.
 *
 *
 * @return string $html The post date.
 */
function nuclearnetwork_last_updated() {

	// Require post ID.
	if ( ! get_the_ID() ) {
		return;
	}

	echo '<div class="post-meta post-meta__date"><span class="post-meta__label">Last Updated</span> ' . get_the_modified_time( get_option( 'date_format' ) ) . '</div>';
}

/**
 * Displays the post authors. Uses CoAuthors Plus plugin to display guest authors in place of standard WP authors.
 *
 */
function nuclearnetwork_authors() {

	/*
	* This will show or not the author information. If ACF hide_author_info is checked won't show the author.
	*/
	if ( class_exists('ACF') ) {
		$hide_author_info = get_field('hide_author_info');
		if( $hide_author_info ) {
			return;
		}
	}

	if ( function_exists( 'coauthors' ) ) {
		$authors = coauthors_posts_links( ', ', ' and ', null, null, false );
	} else {
		$authors = the_author_posts_link();
	}

	if ( !$authors ) {
		return;
	}

	echo '<div class="post-meta post-meta__authors">By ' . $authors . '</div>';
}

if (! function_exists('nuclearnetwork_authors_list_extended')) :
	/**
	 * Prints HTML with short author list.
	 */
	function nuclearnetwork_authors_list_extended()
	{
		global $post;

		if ( 'post' !== get_post_type() ) {
			return;
		}

		if (function_exists('coauthors_posts_links')) {
			$authors = '<h2 class="section__heading">Authors</h2>';

			foreach (get_coauthors() as $coauthor) {
				$name = $coauthor->display_name;

				$authors .= '<div class="post__authors-author"><h3 class="post__authors-author-name">' . $name . '</h3><p class="post__authors-author-bio">' . $name . ' ' . $coauthor->description . '</p>';

				if ( $coauthor->website ) {
					$authors .= '<a href="' . $coauthor->website . '" class="post__authors-author-link">Learn More ' . nuclearnetwork_get_svg( 'arrow-external' ) .'</a></div>';
				} else {
					$authors .= '</div>';
				}
			}
		} else {
			$authors = the_author_posts_link();
		}
		return '<div class="post__authors"><hr class="post__authors-divider alignfull">' . $authors . '</div>';
	}
endif;

/**
 * Displays the post's categories.
 *
 *
 * @return string $html The categories.
 */
if (! function_exists('nuclearnetwork_display_categories')) :
	function nuclearnetwork_display_categories() {

		// Require post ID.
		if ( ! get_the_ID() ) {
			return;
		}

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list();

		if ('Uncategorized' === $categories_list) {
				return;
		}

		// Always display "Event" for events
		if ( 'event' === get_post_type() ) {
			$categories_list = 'Event';
		}

		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<div class="post-meta post-meta__categories">' . esc_html__( '%1$s', 'nuclearnetwork' ) . '</div>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif;

/**
 * Displays the post's categories.
 *
 *
 * @return string $html The categories.
 */
if (! function_exists('nuclearnetwork_display_tags')) :
	function nuclearnetwork_display_tags() {

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list('<ul class="post-meta__tags" role="list"><li class="btn btn--dark btn--xsmall">', '</li><li class="btn btn--dark btn--xsmall">', '</li></ul>');

		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<div class="entry__tags">' . esc_html__( '%1$s', 'nuclearnetwork' ) . '</div>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif;

/**
 * Displays the AddToAny Share Links.
 *
 *
 * @return string $html The share links.
 */
if (! function_exists('nuclearnetwork_share')) :
	function nuclearnetwork_share() {

		if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) {
			// Make sure that we're sharing the archive page and not just the most recent post in that archive.
			if ( is_home() || is_archive() ) {

				ADDTOANY_SHARE_SAVE_KIT( array(
						'linkname' => is_home() ? get_bloginfo( 'description' ) : wp_title( '', false ),
						'linkurl'  => esc_url_raw( home_url( $_SERVER['REQUEST_URI'] ) ),
				) );

			} else {
				ADDTOANY_SHARE_SAVE_KIT();
			}
		}
	}
endif;

/**
 * Displays Page Description.
 *
 *
 * @return string $html The description.
 */
if (! function_exists('nuclearnetwork_page_desc')) :
	function nuclearnetwork_page_desc() {
		$description = get_field( 'description' );

		if ( !$description ) {
			return;
		}

		printf( '<p class="entry-header__desc">' . esc_html__( '%1$s', 'nuclearnetwork' ) . '</p>', $description ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

/*
 * Displays the number of items and pages on archive & search pages.
 *
 *
 * @return string $html The share links.
 */
if (! function_exists('nuclearnetwork_pagination_number_of_posts')) :
	function nuclearnetwork_pagination_number_of_posts() {
		global $wp_query;
		$total_posts = $wp_query->found_posts;
		$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$pages = $wp_query->max_num_pages;

		if ( $total_posts > 0 ) {
			/* translators: 1: list of tags. */
			printf( '<h2 class="pagination__results">' . esc_html__( '%1$s', 'nuclearnetwork' ) . ' Items, Page ' . esc_html__( '%2$s', 'nuclearnetwork' ) . ' of ' . esc_html__( '%3$s', 'nuclearnetwork' ) . '</h2>', $total_posts, $page, $pages ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_display_footnotes' ) ) :
	/**
	 * Returns HTML with easy footnotes.
	 *
	 */
	function nuclearnetwork_display_footnotes() {
		if ( class_exists( 'easyFootnotes' ) ) {
			global $easyFootnotes;

			$footnotes = $easyFootnotes->easy_footnote_after_content('');

			if ( $footnotes != '' ) {
				printf( '<div class="footnotes"><h2 class="footnotes__heading">' . esc_html( 'Footnotes', 'reconaisa') . '</h2><ol class="footnotes__list">%1$s</ol></div>', $footnotes ); // WPCS: XSS OK.
				}
		}
	}
endif;

/**
 * Modify the assets that are loaded on pages that use facets.
 */
add_filter( 'facetwp_assets', function( $assets ) {
	if ( !is_front_page() ) {
		$assets['custom.js'] = '/wp-content/themes/csisnuclearnetwork/assets/plugins/facets.js';
	}

	unset( $assets['fSelect.css'] );

	return $assets;
});

/**
* Add accessibility JS for facets.
*/
add_filter( 'facetwp_load_a11y', '__return_true' );
