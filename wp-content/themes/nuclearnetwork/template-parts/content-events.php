<?php
/**
 * Template part for displaying event posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

$is_featured = get_post_meta( $id, '_post_is_featured', true );

if ( $is_featured ) {
	$featured_class = ' featured';
}

$current_date = date( 'Y-m-d' );
$post_date = explode( ' ', $post->post_date);
if ( $current_date > $post_date[0] ) {
	$past_class = ' past';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-card row' . $featured_class . $past_class ); ?>>
	<div class="col-xs-12 col-sm-2">
		<?php nuclearnetwork_posted_on_calendar(); ?>
	</div>
	<div class="col-xs-12 col-sm-10">
		<header class="entry-header">
			<?php
			nuclearnetwork_post_format( $post->ID );
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			nuclearnetwork_poni_sponsored( $id );
			nuclearnetwork_post_location( $id );
			nuclearnetwork_event_dates( $id );
			nuclearnetwork_entry_categories();
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

