<?php
/**
 * The about PONI section of the home page,
 * including information about directors and a team photo
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

?>

<?php 
    $dailyNewsletterName = get_field('daily_newsletter_name');
    $dailyNewsletterDesc = get_field('daily_newsletter_description');
    $dailyNewsletterLinks = "<div class='recent-news'><a href=''>Most recent newsletter" .nuclearnetwork_get_svg('chevron-right') . "</a><a href=''>All Nuclear Policy News" .nuclearnetwork_get_svg('chevron-right') . "</a></div>";
    $monthlyNewsletterName = get_field('monthly_newsletter_name');
    $monthlyNewsletterDesc = get_field('monthly_newsletter_description');
    $monthlyNewsletterLinks = "<div class='recent-news'><a href=''>Most recent newsletter" .nuclearnetwork_get_svg('chevron-right') . "</a></div>";

    $constructedDailyNewsletter = "<div class='daily'><h3>" . $dailyNewsletterName . "</h3><p>" . $dailyNewsletterDesc . "</p><a class='subscribe' href='https://www.csis.org/subscribe#section-newsletters'>Subscribe</a>" . $dailyNewsletterLinks . "</div>";

    $constructedMonthlyNewsletter = "<div class='monthly'><h3>" . $monthlyNewsletterName . "</h3><p>" . $monthlyNewsletterDesc . "</p><a class='subscribe' href='https://www.csis.org/subscribe#section-newsletters'>Subscribe</a>" . $monthlyNewsletterLinks . "</div>";

    $output = "<div class='newsletter-block-acf'><h3>Newsletters</h3>" . $constructedDailyNewsletter . $constructedMonthlyNewsletter . "</div>";
    
    
    echo $output;
    // var_dump($dailyNewsletterName);

?>