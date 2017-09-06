<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nuclear_Network
 */

$facebook = get_option( 'nuclearnetwork_facebook' );
$twitter = get_option( 'nuclearnetwork_twitter' );
$linkedin = get_option( 'nuclearnetwork_linkedin' );

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'nuclearnetwork' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="content-wrapper row">
			<div class="header-logo col-xs-2 col-sm-1 col-md-4">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="/wp-content/themes/nuclearnetwork/img/poni-logo-big.svg" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" class="logo-big" />
					<img src="/wp-content/themes/nuclearnetwork/img/poni-logo-small.svg" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" class="logo-small" />
				</a>
			</div>
			<div class="header-content-container col-xs-10 col-sm-11 col-md-8">
				<div class="header-top row hidden-xs middle-sm">
					<div class="social-container col-sm-3">
						<ul class="header-social">
							<?php
							if ( $facebook ) {
								echo '<li><a href="' . esc_url( $facebook ) . '">F</a></li>';
							}
							if ( $twitter ) {
								echo '<li><a href="https://twitter.com/' . esc_attr( $twitter ) . '">T</a></li>';
							}
							if ( $linkedin ) {
								echo '<li><a href="' . esc_url( $linkedin ) . '">in</a></li>';
							}
							?>
						</ul>
					</div>
					<div class="search-container col-sm-9">
						<?php get_template_part( 'search-inline' ); ?>
					</div>
				</div>
				<nav id="site-navigation" class="header-bottom main-navigation row middle-xs">
					<div class="visible-xs col-xs-10">
						<button class="btn btn-transparent menu-toggle" aria-controls="primary-menu" aria-expanded="false">
							<span id="menu-toggle-menu"><?php esc_html_e( 'Menu', 'nuclearnetwork' ); ?></span>
							<span id="menu-toggle-close" class="is-hidden">X</span>
						</button>
					</div>
					<div class="menu-container col-sm-10 col-md-9 col-lg-8">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							) );
						?>
						<ul class="header-social">
							<?php
							if ( $facebook ) {
								echo '<li><a href="' . esc_url( $facebook ) . '">F</a></li>';
							}
							if ( $twitter ) {
								echo '<li><a href="https://twitter.com/' . esc_attr( $twitter ) . '">T</a></li>';
							}
							if ( $linkedin ) {
								echo '<li><a href="' . esc_url( $linkedin ) . '">in</a></li>';
							}
							?>
						</ul>
					</div>
					<div class="search-container col-xs-2 col-sm-2 col-md-3 col-lg-4">
						<?php get_template_part( 'search-inline' ); ?>
					</div>
				</nav><!-- #site-navigation -->
			</div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
