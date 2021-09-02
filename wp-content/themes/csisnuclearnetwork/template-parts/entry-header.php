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
$is_author = is_author(); //Author
$is_single = is_single();
$post_parent_id = wp_get_post_parent_id(get_the_ID());

$template = get_page_template_slug( get_the_ID() );
$isClassBioTemplate = false;

if ( $template === 'templates/class-bio.php'){
	$isClassBioTemplate = true;
}

	if ( $is_home || ($is_archive && !$is_author) || $is_search || $isClassBioTemplate || in_array( $post_type, array( 'news' ) ) ) {

		get_template_part( 'template-parts/entry-header-blue' );

	} else {

		get_template_part( 'template-parts/entry-header-light' );
	}
	?>
