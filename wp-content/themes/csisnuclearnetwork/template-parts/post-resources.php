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
// var_dump($resources);

if ( ! empty( $resources ) ) {
  echo '<h2 class="section__heading">Resources</h2>
  <div>' . $resources . '</div>';
}
?>