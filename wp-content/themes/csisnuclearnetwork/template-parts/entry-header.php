<?php
/**
 * Displays the post header
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */


$is_archive = is_archive(); //Not search, 404 or Analysis
// $is_page = is_page();
$post_type = get_post_type(); //News, updates, projects, events, programs
// $is_404 = is_404(); //404
$is_search = is_search(); //Search
$is_home = is_home(); //Analysis
$is_tag = is_tag(); //Tag
$is_tax = is_tax(); //Series, Analysis subtypes
$is_category = is_category(); //Category
// $is_author = is_author(); //Author
$is_single = is_single();
$post_parent_id = wp_get_post_parent_id(get_the_ID());

	if ( $is_tax || $is_category || $is_tag || $is_search || ( $post_type === 'updates' && $is_archive ) || ( $post_type === 'programs' && $is_single && $post_parent_id ) || $post_type === 'news' || $is_home || $post_type === 'events' || ( $post_type === 'programs' && $is_archive ) ) {  

		get_template_part( 'template-parts/entry-header-blue' );
			
	} else {

		get_template_part( 'template-parts/entry-header-light' );
	}
	?>
