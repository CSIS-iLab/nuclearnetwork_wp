<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */
$post_type = get_post_type();
$page_for_posts = get_option( 'page_for_posts' );
?>

<?php
$event_info = get_field( 'event_post_info' );
$event_start_date = $event_info['event_start_date'];
$legacy_event_date = get_post_meta( $id, '_post_start_date', true );

if ( get_post_meta( $id, '_post_location', true ) ) {
	$event_location = get_post_meta( $id, '_post_location', true );
}

if ($args[0] == "true") {
    $post_info = "primary";
}else {
    $post_info = "secondary";
}

$classes = 'post';

if ( $event_start_date ) {
	$event_day = date_i18n('d', strtotime($event_start_date));
	$event_month = date_i18n('M', strtotime($event_start_date));
	$event_year = date_i18n('Y', strtotime($event_start_date));
	
	$event_date = '<span class="featured-event-date">'. $event_month . ' ' . $event_day . ', ' . $event_year. '</span>';
}

if ( $legacy_event_date ) {
	$event_day = date_i18n('d', strtotime($legacy_event_date));
	$event_month = date_i18n('M', strtotime($legacy_event_date));
	$event_year = date_i18n('Y', strtotime($legacy_event_date));
	
	$event_date = '<span class="featured-event-date">'. $event_month . ' ' . $event_day . ', ' . $event_year. '</span>';
}


?>
<article <?php post_class( $classes ); ?> id="post-<?php the_ID(); ?>">	
		<?php if ( has_post_thumbnail() && $post_type != 'events' && $args[0] == "true" ) : ?>
			<a href="<?php the_permalink(); ?>" class="post__img" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'large' ); ?>
			</a>
		<?php endif; 

if ( $post_type === 'events' ) { ?>
		<div class="post__event-content">
			<?php
            nuclearnetwork_display_subtypes();
            the_title( '<h3 class="post__title text--bold"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
			if ( $event_date ) { ?>
			<div class='post-meta__date'>Event Date:<?php echo $event_date; ?></div>
			<?php
			}
			the_excerpt(); 
            ?>
		</div>
		<?php
	} else {
		nuclearnetwork_display_subtypes();
		the_title( '<h3 class="post__title text--bold"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		nuclearnetwork_authors();
		nuclearnetwork_posted_on('M j, Y');
		the_excerpt();
		nuclearnetwork_display_series();
	} 
	?>
</article><!-- .post -->
