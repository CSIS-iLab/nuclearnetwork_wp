<?php
/**
 * Featured Announcement
 *
 * @package Nuclear_Network
 */

?>

<div class="featured-announcement">
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	&mdash; <?php the_date(); ?>
</div>
