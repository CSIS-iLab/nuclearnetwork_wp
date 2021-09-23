<?php
/**
 * Displays the featured image caption
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

 	// Borrowed from https://wordpress.stackexchange.com/a/116512
	$ancestors = get_ancestors(
		get_queried_object_id(),
		get_queried_object()->taxonomy
	);
	if ( !empty ( $ancestors ) ) {
		foreach ( $ancestors as $ancestor )
		{
				$term     = get_term( $ancestor, get_queried_object()->taxonomy );
				$subtype = esc_attr( "$term->slug-$term->taxonomy" );
		}
	}


$object = get_queried_object();

$is_archive = is_archive(); //Not search, 404 or Analysis
$is_page = is_page();
$has_thumbnail = has_post_thumbnail();
$post_type = get_post_type(); //News, updates, projects, events, programs
$is_404 = is_404(); //404
$is_search = is_search(); //Search
$is_home = is_home(); //Analysis
$page_for_posts = get_option( 'page_for_posts' );
$is_tag = is_tag(); //Tag
$series_page = get_field('series_page', 'option'); // Series page as archive
$series_page_id = $series_page->ID;
$is_series_page = is_page($series_page_id);
$is_series = is_tax('series') || is_page( $series_page_id ); //Series
$is_category = is_category(); //Category
$is_single = is_single();
$post_parent_id = wp_get_post_parent_id(get_the_ID());

$archive_image = get_field('image', $object->name);

if ( $is_home || $is_series || $is_series_page || $subtype === 'analysis-filtered_content_types' ) {
	$archive_image = get_field('image', $page_for_posts);
} elseif ( $is_category || $is_tag || $is_search ) {
	$archive_image = get_field('general_archive_header_image', 'option');
} elseif ( $subtype === 'event-filtered_content_types' ) {
	$archive_image = get_field('image', $term->name . 's');
}

	$caption = $archive_image['caption'];

	if ( $caption ) {
		echo '<div class="archive__header-image-caption text--short">Header Image: ' . esc_html( $caption ) . '</div>';
	}
