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
		$post_type = get_post_type();
		if ( in_array( $post_type, array( 'post', 'news' ), true ) ) {

			$is_featured = get_post_meta( $id, '_post_is_featured', true );

			if ( 'post' === $post_type ) {
				$post_format = get_post_meta( $id, '_post_post_format', true );
				$is_nextgen = get_post_meta( $id, '_post_is_nextgen', true );

				if ( $is_nextgen ) {
					$is_nextgen = '<span class="nextgen">' . esc_html( 'Next Gen Perspectives', 'nuclearnetwork' ) . '</span>';
				}
			} else {
				$obj = get_post_type_object( $post_type );
				$post_format = $obj->labels->name;
			}

			if ( 1 == $is_featured ) {
				$is_featured = '<span class="featured">' . esc_html( 'Featured', 'nuclearnetwork' ) . '</span>';
			} else {
				$is_featured = '';
			}

			if ( $post_format ) {
				printf( '<p class="post-format">' . esc_html( '%2$s' ) . esc_html( '%1$s' ) . esc_html( '%3$s' ) . '</p>', $post_format, $is_featured, $is_nextgen ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_post_callout' ) ) :
	/**
	 * Returns HTML with discuss this post message.
	 *
	 * @param string $title Title of the callout.
	 * @param string $message Message of the callout.
	 * @param string $url URL to link to.
	 * @param string $icon Icon to use.
	 */
	function nuclearnetwork_post_callout( $title, $message, $url, $icon = null ) {

		if ( $title && $message && $url ) {
			$output = '<div class="callout-container"><a href="' . esc_url( $url ) . '" target="_blank">
				<i class="' . esc_attr( $icon ) . '"></i><h5 class="callout-header">' . esc_html( $title ) . '</h5>
				<p>' . esc_html( $message ) . '</p></a></div>';

			return $output;
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

if ( ! function_exists( 'nuclearnetwork_post_num' ) ) :
	/**
	 * Returns HTML with total # of posts returned and the current page the user is on.
	 */
	function nuclearnetwork_post_num() {
		global $wp_query;
		// Current page.
		$paged = (get_query_var( 'paged' )) ? get_query_var( 'paged' ) : 1;
		/* translators: 1: number of pages. */
		printf( '<div class="pagination-totals">' . esc_html_x( '%1$s entries', 'nuclearnetwork' ) . ' <span>|</span> ' . esc_html_x( 'Page %2$s of %3$s', 'nuclearnetwork' ) . '</div>', $wp_query->found_posts, $paged, $wp_query->max_num_pages ); // WPCS: XSS OK.
	}
endif;
