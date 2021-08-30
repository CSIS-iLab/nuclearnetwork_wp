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

$classes = 'home__upcomingEventSection';
if( ! class_exists('ACF') ) {
    return;
}

$excluded_posts = $args;


// $excluded_featured_post_ids_from_recent = array();
// $featured_posts = get_field( 'featured_posts' );

// foreach($featured_posts as $post){
//     $excluded_featured_post_ids_from_recent[] = $post->ID;
// }

// echo $args[0];
// echo $excluded_featured_post_ids_from_recent[0];

$news_args = array(
'numberposts' => 3,
'posts_per_page' => 3,
'post_type'   => 'post',
'post_status' => 'publish',
'post__not_in' => $excluded_posts
// 'fields' => 'ids'
);
$event_args = array(
'numberposts' => 1,
'posts_per_page' => 1,
'post_status' => 'publish',
'post_type'   => 'events',
'post__not_in' => $excluded_posts
);
$latest_news = new WP_Query( $news_args );
$latest_events = new WP_Query( $event_args );

echo "<div class='home__event-and-posts-block'>";
if ( $latest_events ) {
    // do logic
    echo "<div class='upcoming-event'>";
    while ( $latest_events->have_posts() ) {
        $latest_events->the_post();
        // get_template_part( 'template-parts/block-post');
        get_template_part( 'template-parts/home-event-block' );
    }
    wp_reset_postdata();
    echo "</div>";
}

if ( $latest_news ) {
    echo "<div class='news-posts'><h3 class='news-posts-title'>Latest News</h3>";
    while ( $latest_news->have_posts() ) {
        $latest_news->the_post();
        get_template_part( 'template-parts/block-post-related');
    }
    wp_reset_postdata();
    echo "<div class='post-meta__event-meta'></div>";
    echo "</div>";
}

echo "<div class='twitter-section'><h3 class='twitter-section-title'>Twitter</h3>";
// twitter sidebar
dynamic_sidebar( 'sidebar-2' );
echo "</div></div>";

?>

<article <?php post_class( $classes ); ?>>




</article>