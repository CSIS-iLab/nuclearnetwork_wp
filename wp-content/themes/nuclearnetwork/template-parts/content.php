<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nuclear_Network
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-card row' ); ?>>
	<?php
	if ( has_post_thumbnail() ) {
		echo '<div class="col-xs-12 col-md-4 post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">';
		the_post_thumbnail( 'medium_large' );
		echo "</a></div>";
	}
	?>
	<div class="col-xs-12 col-md">
		<header class="entry-header">
			<?php
			nuclearnetwork_post_format( $post->ID );
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				nuclearnetwork_authors_list();
				nuclearnetwork_posted_on();
				nuclearnetwork_entry_categories();
				?>
			</div><!-- .entry-meta -->
			<?php
			endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
