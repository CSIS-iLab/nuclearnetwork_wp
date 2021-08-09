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
	$post_type = get_post_type();

	if  ( $date_format ) {
		$date = $date_format;
	}

	if ( $post_type === 'news' ) {
		echo '<div class="post-meta post-meta__date">' . get_the_time( $date ) . '</div>';
	} elseif ( in_array( $post_type, array( 'events', 'programs', 'projects' ) ) ) {
		return;
	} else {
		echo '<dl class="post-meta post-meta__date"><dt class="post-meta__label">Published </dt><dd>' . get_the_time( $date ) . '</dd></dl>';
	}
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

	echo '<dl class="post-meta post-meta__date"><dt class="post-meta__label">Last Updated</dt> <dd>' . get_the_modified_time( get_option( 'date_format' ) ) . '</dd></dl>';
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

	$post_type = get_post_type();

	if ( !$authors || in_array( $post_type, array( 'events', 'programs', 'projects' ) ) ) {
		return;
	}

	echo '<dl class="post-meta post-meta__authors"><dt class="post-meta__label">By</dt><dd>' . $authors . '</dd></dl>';
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
			$authors = '<h2 class="section__heading post__authors-heading">Authors</h2><p class="text--italic text--short post__authors-disclaimer">The views expressed above are the author’s and do not necessarily reflect those of the Center for Strategic and International Studies or the Project on Nuclear Issues.</p>';

			foreach (get_coauthors() as $coauthor) {
				$name = $coauthor->display_name;
				$username = $coauthor->linked_account;
				$user = get_user_by( 'login', $username );

				$title = get_field( 'title', $coauthor->ID );
				$short_bio = get_field( 'short_bio', $coauthor->ID );
				$user_bio = get_field( 'short_bio', 'user_' . $user->ID );
				$guest_description = $coauthor->description;
				$user_description = get_user_meta( $user->ID, 'description', true );

				if ( $short_bio ) {
					$bio = $short_bio;
				} elseif ( $user_bio ) {
					$bio = $user_bio;
				} elseif ( $guest_description ) {
					$bio = $guest_description;
				} else {
					$bio = $user_description;
				}

				if ( $title == null ){
					$title = get_field( 'title', 'user_' . $user->ID );
				}


				$authors .= '<div class="post__authors-author"><h3 class="text--bold text--short post__authors-author-name">' . $name . '<span class="post__authors-author-title"> - ' . $title . '</span></h3><hr class="divider divider--thicc page__header-divider"><p class="post__authors-author-bio">' . $bio . '</p></div>';
			}
		} else {
			$authors = the_author_posts_link();
		}
		echo '<div class="post__authors">' . $authors . '</div>';
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
 * Displays the post's type and subtypes.
 *
 *
 * @return string $html The subtypes.
 */
if (! function_exists('nuclearnetwork_display_subtypes')) :
	function nuclearnetwork_display_subtypes() {

		
		$post_type = get_post_type_object(get_post_type());
		global $post;

		
		if ( in_array( $post_type->name, array( 'events', 'updates' ) ) || ( $post_type->name === 'programs' && is_single() ) ) {
			$post_type_name = $post_type->labels->singular_name;
			$tax_name = $post_type->taxonomies[0];
		} elseif ($post_type->name === 'post' ) {
			$post_type_name = get_the_title( get_option( 'page_for_posts' ) );
			$tax_name = 'analysis_subtype';
		}
		
		echo '<div class="post-meta post-meta__terms"><a href="' . get_post_type_archive_link( $post->post_type ) . '" class="post-meta__terms-type text--bold">' . $post_type_name . get_the_term_list( $post->ID, $tax_name, ' /&nbsp</a>', ',&nbsp') . '</div>';
	}
endif;

/**
 * Displays the post's series.
 *
 *
 * @return string $html The series.
 */
if (! function_exists('nuclearnetwork_display_series')) :
	function nuclearnetwork_display_series() {

		global $post;
		
		echo get_the_term_list( $post->ID, 'series', '<dl class="post-meta post-meta__series text--italic"><dt class="post-meta__label">Series </dt><dd>', ', ', '</dd></dl>');
	}
endif;

if ( ! function_exists( 'nuclearnetwork_citation' ) ) :
	/**
	 * Returns HTML with post citation.
	 *
	 * @param int $id Post ID.
	 */
	function nuclearnetwork_citation() {
		$authors = coauthors( ', ', null, null, null, false );

		$modified_date = null;
		if ( get_the_modified_date() ) {
			$modified_date = 'last modified ' . get_the_modified_date() . ', ';
		}

		$title = get_the_title();
		if ( is_tax() ) {
			$title = get_the_archive_title();
		}

		printf( '<h2 class="cite__heading text--bold text--caps">Cite this Page</h2><p class="cite__container text--short"><span class="cite__citation">' . esc_html( '%1$s, "%2$s,"', 'nuclearnetwork' ) . ' <em>%3$s</em>' . esc_html( ', Center for Strategic and International Studies, %4$s, %5$s%6$s.', 'nuclearnetwork') . '</span><button id="btn-copy" class="btn btn--dark btn--icon btn--short" data-clipboard-target=".cite__citation" aria-label="Copied!">' . nuclearnetwork_get_svg( 'copy' ) . 'Copy Citation</button></p>', $authors, $title, get_bloginfo( 'name' ), get_the_date(), $modified_date, get_the_permalink() ); // WPCS: XSS OK.
	}
endif;
