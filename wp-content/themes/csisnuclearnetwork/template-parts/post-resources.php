<?php
/**
 * The default template for displaying post resources
 *
 * Used for singular.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */


$resources = get_field( 'resources' );

if ( ! empty( $resources ) ) {
  echo '<div class="resources"><h2 class="resources__heading single__section-heading">Resources</h2>
  <div class="resources__content">' . $resources . '</div></div><hr>';
}
?>