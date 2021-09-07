<?php
/**
 * The Archive template.
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

$current_year = get_query_var('year', date('Y'));
$current_month = get_query_var('monthnum', date('m'));

$date = date("F Y", strtotime($current_year . "-" . $current_month . "-01"));

get_header();
?>

<main id="site-content" role="main">

	<?php
		get_template_part( 'template-parts/entry-header' );
	?>

	<div class='archive__content'>
		<div class="archive__subheader">
			<h2 class="archive__subheading"><?php echo $date; ?> Nuclear Policy News</h2>
			<?php
			if ( class_exists('ACF') ) {
				$instructions = get_field( 'archive_instructions', 'news' );
				echo '<p class="archive__disclaimer text--short">' . $instructions . '</p>';
			}
			?>
		</div>

	<?php
		if ( have_posts() ) {
      echo "<aside class='archive__sidebar'>";
      echo "<select class='archive__dropdown' name='archive-dropdown' onchange='document.location.href=this.options[this.selectedIndex].value;'>";
      $args = array(
        'type'            => 'monthly',
        'format'          => 'option', 
        'post_type'       => 'news',
        'echo'            => 1,
      );
      wp_get_archives( $args );
      echo "</select>";
      dynamic_sidebar( 'nuclear-policy-news' );
      echo "</aside>";
		}

		if ( have_posts() ) {
			echo '<section class="archive__postlist">';
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/block-post', get_post_type() );
			}
			wp_reset_postdata();
			echo "</section>";
		}
	?>
	</div>

</main><!-- #site-content -->

<?php
get_footer();
