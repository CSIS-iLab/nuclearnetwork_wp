<?php
/**
 * The newsletter section of the home page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

?>

<?php
    if( ! class_exists('ACF') ) {
    return;
    }

    $news_args = array(
    'numberposts' => 1,
    'post_type'   => 'news',
    'fields' => 'ids'
    );

    $progUpdate_args = array(
    'numberposts' => 1,
    'post_type'   => 'updates',
    'meta-key' => 'newsletter',
    'meta-value' => 'true'
    );

    $latest_news = get_posts( $news_args );

    $latest_updates = get_posts( $progUpdate_args );

    if( $latest_news ) {
        $recentNewsUrl = get_permalink($latest_news[0]);
    }

    if ($latest_updates) {
        $recentUpdatesUrl = get_permalink($latest_updates[0]);
    }

    $dailyNewsletterName = get_field('daily_newsletter_name');
    $dailyNewsletterDesc = get_field('daily_newsletter_description');
    $dailyNewsletterLinks = "<div class='recent-news'><a href=" . $recentNewsUrl . ">Most recent newsletter" .nuclearnetwork_get_svg('chevron-right') . "</a><a href=" . get_post_type_archive_link( 'news' ) . ">All Nuclear Policy News" .nuclearnetwork_get_svg('chevron-right') . "</a></div>";
    $monthlyNewsletterName = get_field('monthly_newsletter_name');
    $monthlyNewsletterDesc = get_field('monthly_newsletter_description');
    $monthlyNewsletterLinks = "<div class='recent-news'><a href=" . $recentUpdatesUrl . ">Most recent newsletter" .nuclearnetwork_get_svg('chevron-right') . "</a></div>";

    $constructedDailyNewsletter = "<div class='daily'><h3>" . $dailyNewsletterName . "</h3><p class='text--short'>" . $dailyNewsletterDesc . "</p><a class='subscribe btn btn--teal btn--newsletter' href=" . get_field('nuclear_policy_news_link', 'option') . ">Subscribe</a>" . $dailyNewsletterLinks . "</div>";

    $constructedMonthlyNewsletter = "<div class='monthly'><h3>" . $monthlyNewsletterName . "</h3><p class='text--short'>" . $monthlyNewsletterDesc . "</p><a class='subscribe btn btn--teal btn--newsletter' href=" . get_field('monthly_newsletter_link', 'option') . ">Subscribe</a>" . $monthlyNewsletterLinks . "</div>";

    $output = "<div class='newsletter-block-acf'><h2 class='home__subtitle'>Newsletters</h3>" . $constructedDailyNewsletter . $constructedMonthlyNewsletter . "</div>";

    echo $output;
?>
