<?php
/**
 * Template part for displaying news posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

$current_date = date( 'Y-m-d' );
$start_date = get_post_meta( $id, '_post_start_date', true );
if ( $current_date > $start_date ) {
	$past_class = ' past';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-card row' . $past_class ); ?>>
	<div class="col-xs-12 col-sm-2">
		<?php nuclearnetwork_posted_on_calendar( $post->ID ); ?>
	</div>
	<div class="col-xs-12 col-sm-10">
		<header class="entry-header">
			<?php
			nuclearnetwork_post_format( $post->ID );
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

