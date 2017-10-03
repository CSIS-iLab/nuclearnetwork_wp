<?php
/**
 * Template part for displaying resources posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

$is_featured = get_post_meta( $id, '_post_is_featured', true );

if ( $is_featured ) {
	$featured_class = ' featured';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-card row' . $featured_class ); ?>>
	<div class="col-xs-12">
		<header class="entry-header">
			<?php
			nuclearnetwork_post_format( $post->ID );
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			nuclearnetwork_resources_authors( $id );
			nuclearnetwork_publication_date( $id );
			nuclearnetwork_entry_categories();
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_excerpt(); ?>
			<?php nuclearnetwork_info_url( $id, 'View Resource' ); ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

