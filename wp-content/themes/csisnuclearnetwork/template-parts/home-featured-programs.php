<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package nuclearnetwork
 * @since 1.0.0
 */

?>

<!-- structure of big div surrounding the three programs coming from function in template tags -->
<div class='home__featured-programs'>
    <h3 class='home__featured-programs-subtitle home__subtitle home__subtitle--border'>Programs</h3>
    <!-- .nuclearnetwork_get_svg('chevron-right') . -->
    <div class='home__featured-programs-all-link'><a href='https://nuclearnetwork.csis.org/programs/'>All Programs <?php nuclearnetwork_get_svg('chevron-right'); ?></a></div>
    <!-- template tags function -->
    <?php nuclearnetwork_display_featured_programs() ?>
<!-- end div -->
</div>