<?php
/**
 * Featured Alumni Componenent
 *
 * @package Nuclear_Network
 */

?>

<div class="alumni-featured row">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="col-xs-6 col-md-12">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'thumbnail' ); ?>
			</a>
		</div>
	<?php endif; ?>
	<div class="col-xs col-md-12">
		<h5 class="alumni-name"><?php the_title(); ?></h5>
		<?php the_excerpt(); ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="alumni-readmore">
			<?php esc_html_e( 'Read more', 'nuclearnetwork' ); ?>
		</a>
	</div>
</div>
