<?php
/**
 * Custom Post Types
 *
 * @package Nuclear_Network
 */

/*----------  Custom Post Meta for Posts  ----------*/
require get_template_directory() . '/inc/cpts/custom-post-meta.php';

/*----------  Custom Post Type: Alumni  ----------*/
require get_template_directory() . '/inc/cpts/alumni.php';

/*----------  Custom Post Type: Announcements  ----------*/
require get_template_directory() . '/inc/cpts/announcements.php';

/*----------  Custom Post Type: Essentials  ----------*/
require get_template_directory() . '/inc/cpts/essentials.php';

/*----------  Custom Post Type: Events  ----------*/
require get_template_directory() . '/inc/cpts/events.php';

/*----------  Custom Post Type: News  ----------*/
require get_template_directory() . '/inc/cpts/news.php';

/*----------  Custom Post Type: Opportunities  ----------*/
require get_template_directory() . '/inc/cpts/opportunities.php';
