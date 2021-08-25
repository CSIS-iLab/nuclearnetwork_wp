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

$news_args = array(
'numberposts' => 3,
'posts_per_page' => 3,
'post_type'   => 'post',
'post_status' => 'publish'
// 'fields' => 'ids'
);
$event_args = array(
'numberposts' => 1,
'posts_per_page' => 1,
'post_status' => 'publish',
'post_type'   => 'events'
);
$latest_news = new WP_Query( $news_args );
$latest_events = get_posts( $event_args );

if ( $latest_events ) {
    // do logic
}

if ( $latest_news ) {
    echo "<div class='home__three-posts'><h3 class='home__three-posts-title'>Latest News</h3>";
    while ( $latest_news->have_posts() ) {
        $latest_news->the_post();
        // get_template_part( 'template-parts/block', get_post_type() );
        get_template_part( 'template-parts/block-post-related');
    }
    wp_reset_postdata();
    echo "</div>";
}


?>

<article <?php post_class( $classes ); ?>>




</article>