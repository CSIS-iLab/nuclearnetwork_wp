<?php
/**
 * Displays the site navigation.
 *
 * @package CSIS iLab
 * @subpackage @package NuclearNetwork
 * @since 1.0.0
 */

?>
<?php if ( has_nav_menu( 'primary' ) ) : ?>
	<nav id="site-navigation" class="site-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'nuclearnetwork' ); ?>">
		<button
			class="site-nav__trigger"
			aria-expanded="true"
			aria-label="Toggle Menu"
		>
			<span class="line"></span>
			<span class="line"></span>
			<span class="line"></span>
			<span class="line"></span>
			<span class="visually-hidden">Menu</span>
		</button>
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'menu_class'      => 'site-nav__menu',
				'container_class' => 'site-nav__container',
				'items_wrap'      => '<ul role="list" id="primary-menu-list" class="%2$s">%3$s</ul>',
				'fallback_cb'     => false,
			)
		);
		?>
	</nav><!-- #site-navigation -->
<?php endif; ?>
