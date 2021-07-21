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

$featured_post = get_field( 'featured_post' );
$is_monthly_newsletter = get_field( 'newsletter');
$event_info = get_field( 'event_post_info' );

$classes = ' post-block post-block--post ' . $post_type;

if ( $is_monthly_newsletter ) {
	$classes .= ' post-block__monthly-newsletter';
} elseif ( $featured_post ) {
	$classes .= ' post-block__featured';
}

var_dump($event_info['event_start_time']);
if ( $event_info['event_start_time'] && $event_info['event_end_time'] ) {
	$start_time = wp_date('g:i', strtotime($event_info['event_start_time']));
	$end_time = wp_date('g:i A', strtotime($event_info['event_end_time']));
	$timezone = current_time('T');
	$event_time = $start_time . ' - ' . $end_time . ' ' . $timezone;
} elseif ( $event_info['event_start_time'] ) {
	$event_time = date('g:i A', strtotime($event_info['event_end_time']));
}

?>
<article <?php post_class( $classes ); ?> id="post-<?php the_ID(); ?>">	
		<?php if ( has_post_thumbnail() && $post_type != 'events' && !$is_monthly_newsletter ) : ?>
			<a href="<?php the_permalink(); ?>" class="post-block__img" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'large' ); ?>
			</a>
		<?php endif; ?>

	<?php

	if ( $is_monthly_newsletter ) {
		nuclearnetwork_display_subtypes();
		the_title( '<h3 class="post-block__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		nuclearnetwork_posted_on('M j, Y');
	} elseif ( $post_type === 'news' ) {
		the_title( '<h3 class="post-block__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		nuclearnetwork_posted_on('Y');
	} else {
		nuclearnetwork_display_subtypes();
		the_title( '<h3 class="post-block__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' );
		nuclearnetwork_authors();
		if ( $post_type != 'events' || $post_type !== 'programs' || $post_type !== 'projects' ) {
			nuclearnetwork_posted_on('M j, Y');
		}
		the_excerpt();
		nuclearnetwork_display_series();
		if ( $event_info ) { ?>
			<div class="post-block__event-date"><?php echo $event_info['event_start_date']; ?></div>
			<a href="<?php echo esc_url( $event_info['event_registration_link'] ); ?> class="post-block__register btn">Register</a>
			<div class="post-block__event-meta">
				<?php
				if ( $event_info['event_start_time'] ) { ?>
					<div class="post-block__event-time"><span class="post-block__event-time-label">Time</span><?php echo $event_time; ?></div>
					<?php
				}
				?>
				<div class="post-block__event-location"><?php echo $event_info['event_location']; ?></div>
			</div>
			<?php
		}
	} 
	?>
</article><!-- .post -->
