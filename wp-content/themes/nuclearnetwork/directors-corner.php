<?php
/**
 * The template for the Director's Corner
 *
 * Template Name: Director's Corner
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

get_header();

if ( is_category() || is_tag() ) {
	$img = get_option( 'nuclearnetwork_category_and_tag_archive_image' );
} elseif ( is_author() ) {
	$img = get_option( 'nuclearnetwork_authors_archive_image' );
} else {
	$img = get_archive_thumbnail_src( 'full' );
}

$featured_img = ' style="background-image:url(\'' . esc_attr( $img ) . '\');"';

?>
