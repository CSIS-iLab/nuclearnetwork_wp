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
		if ( get_the_date() !== get_the_modified_date() ) {
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
		if ( in_array( get_post_type(), array( 'post', 'events', 'opportunities', 'announcements', 'resources' ), true ) ) {
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
		if ( in_array( get_post_type(), array( 'post', 'events', 'opportunities', 'announcements', 'resources' ), true ) ) {
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
		if ( in_array( $post_type, array( 'post', 'news', 'events', 'opportunities', 'announcements', 'resources' ), true ) ) {

			$is_featured = get_post_meta( $id, '_post_is_featured', true );
			if ( 1 == $is_featured ) {
				$is_featured = '<span class="featured">' . esc_html( 'Featured', 'nuclearnetwork' ) . '</span>';
			} else {
				$is_featured = null;
			}

			if ( 'post' === $post_type ) {
				$post_format = get_post_meta( $id, '_post_post_format', true );
				$is_nextgen = get_post_meta( $id, '_post_is_nextgen', true );

				if ( $is_nextgen ) {
					$is_nextgen = '<span class="nextgen">' . esc_html( 'Next Gen Perspectives', 'nuclearnetwork' ) . '</span>';
				}
			} elseif ( 'events' === $post_type ) {
				$event_types = get_the_terms( $id, 'event_types' );
				if ( ! empty( $event_types ) && ! is_wp_error( $event_types ) ) {
					$event_types = wp_list_pluck( $event_types, 'name' );
					$post_format = $event_types[0];
				}
			} elseif ( 'opportunities' === $post_type ) {
				$opportunity_types = get_the_terms( $id, 'opportunity_types' );
				if ( ! empty( $opportunity_types ) && ! is_wp_error( $opportunity_types ) ) {
					$opportunity_types = wp_list_pluck( $opportunity_types, 'name' );
					$post_format = $opportunity_types[0];
				}
			} elseif ( 'resources' === $post_type ) {
				$resource_types = get_the_terms( $id, 'resource_types' );
				if ( ! empty( $resource_types ) && ! is_wp_error( $resource_types ) ) {
					$resource_types = wp_list_pluck( $resource_types, 'name' );
					$post_format = $resource_types[0];
				}
			}

			if ( ! $post_format ) {
				$obj = get_post_type_object( $post_type );
				$post_format = $obj->labels->name;
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

if ( ! function_exists( 'nuclearnetwork_archive_search' ) ) :
	/**
	 * Returns HTML of archive search according to settings.
	 */
	function nuclearnetwork_archive_search() {
		if ( class_exists( 'Search_Filter' ) ) {
			global $wp_query;
			$post_type = $wp_query->query['post_type'];
			$id = get_option( 'nuclearnetwork_' . $post_type . '_archive_search' );

			if ( $id && '-1' === $id ) {
				return;
			} elseif ( ! $id ) {
				$id = get_option( 'nuclearnetwork_default_archive_search' );
			}

			$output = '<div class="content-wrapper archive-search-container">' . do_shortcode( '[searchandfilter id="' . $id . '"]' ) . '</div>';

			return $output;
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_posted_on_calendar' ) ) :
	/**
	 * Prints HTML of posted on date in calendar form.
	 */
	function nuclearnetwork_posted_on_calendar() {
		$date_string = '<div class="month">%1$s</div><div class="day">%2$s</div>';

		$date_string = sprintf( $date_string,
			esc_attr( get_the_date( 'M' ) ),
			esc_html( get_the_date( 'j' ) )
		);

		echo '<div class="calendar-container"><a href="' . esc_url( get_permalink() ) . '">' . $date_string . '</a></div>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'nuclearnetwork_poni_sponsored' ) ) :
	/**
	 * Returns HTML with PONI sponsored marker.
	 *
	 * @param  int $id Post ID.
	 */
	function nuclearnetwork_poni_sponsored( $id ) {
		if ( in_array( get_post_type(), array( 'events', 'opportunities' ), true ) && 1 == get_post_meta( $id, '_post_poni_sponsored', true ) ) {
			printf( '<div class="poni-sponsored"><i class="icon-bookmark"></i> <span class="meta-label">' . esc_html_x( 'PONI Program Opportunity', 'nuclearnetwork' ) . '</span></div>' ); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_post_location' ) ) :
	/**
	 * Returns HTML with post location.
	 *
	 * @param  int $id Post ID.
	 */
	function nuclearnetwork_post_location( $id ) {
		if ( in_array( get_post_type(), array( 'events', 'opportunities' ), true ) && '' !== get_post_meta( $id, '_post_location', true ) ) {
			$location = get_post_meta( $id, '_post_location', true );
			printf( '<div class="post-location"><span class="meta-label">' . esc_html_x( 'Location:', 'nuclearnetwork' ) . '</span> %1$s</div>', $location ); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_event_dates' ) ) :
	/**
	 * Returns HTML with event dates.
	 *
	 * @param  int $id Post ID.
	 */
	function nuclearnetwork_event_dates( $id ) {
		if ( 'events' === get_post_type() && null !== get_post_meta( $id, '_post_start_date', true ) ) {
			$start_date = get_post_meta( $id, '_post_start_date', true );
			$start_date_array = nuclearnetwork_check_date( $start_date );
			if ( $start_date_array ) {
				$start_date = date( get_option( 'date_format' ), mktime( 0, 0, 0, $start_date_array[1], $start_date_array[2], $start_date_array[0] ) );
			}

			$end_date = get_post_meta( $id, '_post_end_date', true );
			if ( $end_date ) {
				$label = 'Dates';
				$end_date_array = nuclearnetwork_check_date( $end_date );
				if ( $end_date_array ) {
					$end_date = ' - ' . date( get_option( 'date_format' ), mktime( 0, 0, 0, $end_date_array[1], $end_date_array[2], $end_date_array[0] ) );
				}
			} else {
				$label = 'Date';
			}

			printf( '<div class="post-event-dates"><span class="meta-label">' . esc_html_x( '%1$s:', 'nuclearnetwork' ) . '</span> %2$s%3$s</div>', $label, $start_date, $end_date ); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_opportunity_deadline' ) ) :
	/**
	 * Returns HTML with event dates.
	 *
	 * @param  int $id Post ID.
	 */
	function nuclearnetwork_opportunity_deadline( $id ) {
		if ( 'opportunities' === get_post_type() && null !== get_post_meta( $id, '_post_deadline', true ) ) {
			$date = get_post_meta( $id, '_post_deadline', true );
			$date_array = nuclearnetwork_check_date( $date );
			if ( $date_array ) {
				$date = date( get_option( 'date_format' ), mktime( 0, 0, 0, $date_array[1], $date_array[2], $date_array[0] ) );
			}

			if ( '1' === get_post_meta( $id, '_post_is_ongoing', true ) ) {
				$ongoing = ' (Ongoing)';
			}

			printf( '<div class="post-opportunity-deadline"><span class="meta-label">' . esc_html_x( 'Deadline:', 'nuclearnetwork' ) . '</span> %1$s%2$s</div>', $date, $ongoing ); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_info_url' ) ) :
	/**
	 * Returns info button with custom label.
	 *
	 * @param  int    $id Post ID.
	 * @param  string $label Label for the button.
	 */
	function nuclearnetwork_info_url( $id, $label = 'More Info' ) {
		if ( in_array( get_post_type(), array( 'events', 'opportunities', 'resources' ), true ) && '' !== get_post_meta( $id, '_post_info_url', true ) ) {
			$info_url = get_post_meta( $id, '_post_info_url', true );
			$info_url = esc_url( $info_url );
			printf( '<div class="post-info-url"><a href="%1$s" target="_blank" class="btn btn-yellow">%2$s</a></div>', $info_url, $label ); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_publication_date' ) ) :
	/**
	 * Returns publication dates for resources.
	 *
	 * @param  int $id Post ID.
	 */
	function nuclearnetwork_publication_date( $id ) {
		if ( 'resources' === get_post_type() && ( '' !== get_post_meta( $id, '_post_publication_year', true ) || '' !== get_post_meta( $id, '_post_publication_month', true ) ) ) {
			$publication_month = ' ' . get_post_meta( $id, '_post_publication_month', true );
			$publication_year = ' ' . get_post_meta( $id, '_post_publication_year', true );
			printf( '<div class="post-publication-date"><span class="meta-label">Published:</span>%1$s%2$s</a></div>', $publication_month, $publication_year ); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'nuclearnetwork_resources_authors' ) ) :
	/**
	 * Prints HTML with resource author information.
	 *
	 * @param  int $id Post ID.
	 */
	function nuclearnetwork_resources_authors( $id ) {
		// Hide category and tag text for pages.
		if ( 'resources' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$authors_list = wp_get_post_terms( $id, 'resource_authors', array(
				'fields' => 'names',
			) );
			if ( $authors_list ) {

				if ( count( $authors_list ) > 1 ) {
					$label = 'Authors';
				} else {
					$label = 'Author';
				}
				$authors_list = implode( ', ', $authors_list );

				/* translators: 1: list of resource authors. */
				printf( '<div class="resource-authors"><span class="meta-label">' . esc_html__( '%1$s:', 'nuclearnetwork' ) . '</span> ' . esc_html( '%2$s' ) . '</div>', $label, $authors_list ); // WPCS: XSS OK.
			}
		}
	}
endif;

/**
 * Check a given date to ensure it is valid.
 *
 * @param  string $date Date string in YYYY-MM-DD format.
 * @return [type]       [description]
 */
function nuclearnetwork_check_date( $date ) {
	$date_array = explode( '-', $date );
	if ( wp_checkdate( $date_array[1], $date_array[2], $date_array[0], $date ) ) {
		return $date_array;
	} else {
		return false;
	}
}

/**
 * Shows link to past & future archives depending on what page the user is on.
 */
function nuclearnetwork_event_future_past_link() {
	if ( ! is_post_type_archive( 'events' ) ) {
		return false;
	}

	if ( 'true' === get_query_var( 'other' ) ) {
		$label = 'Other';
		$url = 'other/';
	} else {
		$label = 'PONI';
		$url = '';
	}

	if ( 'true' === get_query_var( 'is_past' ) ) {
		$label = 'Future ' . $label;
	} else {
		$label = 'Past ' . $label;
		$url = $url . 'past/';
	}

	printf( '<div class="view-past"><a href="/events/%2$s" class="btn btn-blue">' . esc_html_x( 'View %1$s Events', 'nuclearnetwork' ) . '</a></div>', $label, $url ); // WPCS: XSS OK.
}
