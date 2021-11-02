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
if( ! class_exists('ACF') ) {
    return;
}

$date_now = date('Y-m-d H:i:s');

// set excluded posts
$excluded_posts = $args;

// set args for retrieving posts
$recent_args = array(
'numberposts' => 3,
'posts_per_page' => 3,
'post_type'   => 'post',
'post_status' => 'publish',
'post__not_in' => $excluded_posts
);
$event_args = array(
'numberposts' => 1,
'posts_per_page' => 1,
'post_status' => 'publish',
'post_type'   => 'events',
'post__not_in' => $excluded_posts,
'meta_query' => array(
	'relation' => 'OR',
	array(
	'key'           => 'event_post_info_event_start_date',
	'compare'       => '>=',
	'value'         => $date_now,
	'type'          => 'DATE',
	),
),
'orderby' => 'meta_value',
'order' => 'ASC'
);

// retrieve posts 
$latest_posts = new WP_Query( $recent_args );
$latest_events = new WP_Query( $event_args );

// start output
echo "<section class='home__event-and-posts-block'>";

// check for events
if ( $latest_events ) {
    echo "<div class='upcoming-event'>";
    // cycle through and output all events
    while ( $latest_events->have_posts() ) {
        $latest_events->the_post();
        get_template_part( 'template-parts/home-event-block' );
    }
    wp_reset_postdata();
    echo "</div>";
}

// check for posts
if ( $latest_posts ) {
    // cycle through and post all news
    echo "<div class='recent-posts'><h3 class='home__event-and-posts-block-title'>Latest Analysis</h3>";
    while ( $latest_posts->have_posts() ) {
        $latest_posts->the_post();
        get_template_part( 'template-parts/block-post-related');
    }
    wp_reset_postdata();
    echo "<hr></hr>";
    echo "</div>";
}

echo "<div class='twitter-section'><h3 class='home__event-and-posts-block-title home__event-and-posts-block-title--twitter'>Twitter</h3>";
// twitter sidebar
dynamic_sidebar( 'sidebar-2' );

// finish output
echo "</div></section>";

?>