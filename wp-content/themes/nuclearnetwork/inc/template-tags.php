<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Nuclear_Network
 */

if ( ! function_exists( 'nuclearnetwork_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function nuclearnetwork_posted_on() {
		$time_string = '<span class="meta-label">Published:</span><time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<span class="meta-label">Published:</span><time class="entry-date published" datetime="%1$s">%2$s</time><span class="meta-label">Last Updated:</span><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		echo '<div class="posted-on">' . $time_string . '</div>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'nuclearnetwork_authors_list' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function nuclearnetwork_authors_list() {
		$byline = sprintf(
			'<span class="meta-label">' . esc_html_x( 'by', 'post author', 'nuclearnetwork' ) . '</span> %s',
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<div class="authors-list">' . $byline . '</div>'; // WPCS: XSS OK.
	}
endif;

if ( ! function_exists( 'nuclearnetwork_entry_tags' ) ) :
	/**
	 * Prints HTML with meta information for the tags.
	 */
	function nuclearnetwork_entry_tags() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list();
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'More on... %1$s', 'nuclearnetwork' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_entry_categories' ) ) :
	/**
	 * Prints HTML with meta information for the categories.
	 */
	function nuclearnetwork_entry_categories() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list();
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<div class="cat-links"><span class="meta-label">' . esc_html__( 'Categories:', 'nuclearnetwork' ) . '</span>' . esc_html( '%1$s' ) . '</div>', $categories_list ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_post_format' ) ) :
	/**
	 * Returns HTML with post format.
	 *
	 * @param int $id Post ID.
	 */
	function nuclearnetwork_post_format( $id ) {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$post_format = get_post_meta( $id, '_post_post_format', true );
			if ( $post_format ) {
				printf( '<p class="post-format">' . esc_html( '%1$s' ) . '</p>', $post_format ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_linkedin' ) ) :
	/**
	 * Returns HTML with post format.
	 *
	 * @param int $id Post ID.
	 */
	function nuclearnetwork_linkedin( $id ) {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$linkedin_url = get_post_meta( $id, '_post_linkedin_url', true );
			if ( ! $linkedin_url ) {
				$linkedin_url = get_option( 'nuclearnetwork_linkedin' );
			}

			if ( $linkedin_url ) {
				$message = get_option( 'nuclearnetwork_post_discuss' );

				$output = '<div class="discuss-linkedin"><a href="' . esc_url( $linkedin_url ) . '" target="_blank">
				<i class="icon-linkedin-discuss"></i><h5 class="callout-header">' . esc_html_x( 'Discuss this Post', 'nuclearnetwork' ) . '</h5>
				<p>' . $message . '</p></a></div>';

				return $output;
			}
		}
	}
endif;
