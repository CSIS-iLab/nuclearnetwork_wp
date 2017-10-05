<?php
/**
 * Template part for displaying alumni posts.
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
	<?php
	if ( has_post_thumbnail() ) {
		echo '<div class="col-xs-12 col-md-4 post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">';
		the_post_thumbnail( 'thumbnail' );
		echo '</a></div>';
	}
	?>
	<div class="col-xs-12 col-md">
		<header class="entry-header">
			<?php
			nuclearnetwork_post_format( $post->ID );
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

