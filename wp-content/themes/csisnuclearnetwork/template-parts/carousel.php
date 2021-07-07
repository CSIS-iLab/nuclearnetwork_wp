<?php
/**
 * A template partial to output a carousel for the Nuclear Network default theme.
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */



?>

<?php $featured_projects = get_field( 'featured_projects' ); ?>

<?php if ( $featured_projects ) : ?>
  <div id="splide" class="splide">
    <div class="splide__track">
      <ul class="splide__list">
	<?php foreach ( $featured_projects as $post ) : ?>
		<?php setup_postdata ( $post ); ?>
    <?php if ( has_post_thumbnail() && ! post_password_required() ) { ?>
        <li class="splide__slide">
          <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail(); ?>
          </a>
          <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
          </a>
          <?php the_excerpt(); ?>
        </li>
        <?php } ?>
	<?php endforeach; ?>
	<?php wp_reset_postdata(); ?>
      </ul>
    </div>
  </div>
<?php endif; ?>