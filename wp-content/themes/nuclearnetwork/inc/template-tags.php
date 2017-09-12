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
	 * Prints HTML with short author list.
	 */
	function nuclearnetwork_authors_list() {
		if ( function_exists( 'coauthors_posts_links' ) ) {
			$authors = '';
			foreach ( get_coauthors() as $coauthor ) :
				if ( ! get_user_meta( $coauthor->ID, 'title') ) {
					$title = 'Guest Author';
				} else {
					$title = get_user_meta( $coauthor->ID, 'title', true );
				}

				$authors .= '<div class="entry-author"><span class="meta-label">by</span> 
					<a href="' . get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ) . '">' . $coauthor->display_name . '</a>
					<span class="author-title">' . esc_html( $title ) . '</span></div>';
			endforeach;

		} else {
			$authors = the_author_posts_link();
		}

		echo '<div class="authors-list">' . $authors . '</div>';
	}
endif;

if ( ! function_exists( 'nuclearnetwork_authors_list_extended' ) ) :
	/**
	 * Prints HTML with short author list.
	 */
	function nuclearnetwork_authors_list_extended() {
		if ( function_exists( 'coauthors_posts_links' ) ) {
			$authors = '';
			foreach ( get_coauthors() as $coauthor ) :
				if ( ! get_user_meta( $coauthor->ID, 'title') ) {
					$title = 'Guest Author';
				} else {
					$title = get_user_meta( $coauthor->ID, 'title', true );
				}

				$authors .= '<div class="entry-author"><h4 class="section-header">' . esc_html_x( 'About the Author:', 'nuclearnetwork' ) . ' <a href="' . get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ) . '">' . $coauthor->display_name . '</a></h4>
				<p><span class="author-title">' . esc_html( $title ) . ' &mdash; </span>' . $coauthor->description . '</p></div>';
			endforeach;

		} else {
			$authors = the_author_posts_link();
		}

		echo '<div class="authors-list-extended">' . $authors . '</div>';
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
			$tags_list = get_the_tag_list( '<ul><li>','</li><li>','</li></ul>' );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<div class="post-tags-container">' . esc_html__( 'More on... %1$s', 'nuclearnetwork' ) . '</div>', $tags_list ); // WPCS: XSS OK.
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
		if ( 'post' === get_post_type() ) {
			$post_format = get_post_meta( $id, '_post_post_format', true );
			if ( $post_format ) {
				printf( '<p class="post-format">' . esc_html( '%1$s' ) . '</p>', $post_format ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_post_discuss' ) ) :
	/**
	 * Returns HTML with discuss this post message.
	 *
	 * @param int $id Post ID.
	 */
	function nuclearnetwork_post_discuss( $id ) {
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

if ( ! function_exists( 'nuclearnetwork_post_disclaimer' ) ) :
	/**
	 * Returns HTML with post disclaimer.
	 *
	 * @param int $id Post ID.
	 */
	function nuclearnetwork_post_disclaimer( $id ) {
		if ( 'post' === get_post_type() && ! get_post_meta( $post->ID, '_post_disable_linkedin', true ) ) {
			$disclaimer = get_option( 'nuclearnetwork_post_disclaimer' );
			if ( $disclaimer ) {
				printf( '<p class="post-disclaimer">' . esc_html( '%1$s' ) . '</p>', $disclaimer ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_post_write' ) ) :
	/**
	 * Returns HTML with post "Write for Us" message.
	 */
	function nuclearnetwork_post_write() {
		if ( 'post' === get_post_type() ) {
			$message = get_option( 'nuclearnetwork_post_write' );
			if ( $message ) {
				printf( '<div class="post-write">
					<h5 class="callout-header"><a href="/submit-analysis/"><i class="icon-pencil-write"></i> ' . esc_html_x( 'Write for Us', 'nuclearnetwork' ) . '</a></h5>
				<p>' . esc_html( '%1$s' ) . '</p></div>', $message ); // WPCS: XSS OK.
			}
		}
	}
endif;
