<?php
/**
 * Template for displaying inline search form
 *
 * @package Nuclear_Network
 */

?>
<form role="search" method="get" class="header-search-form" action="<?php echo esc_attr( home_url( '/' ) ); ?>">
	<input type="search" class="search-field is-hidden" id="header-search"
		placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ); ?>"
		value="<?php echo get_search_query(); ?>" name="s"
		title="<?php echo esc_attr_x( 'Search for:', 'label' ); ?>" />
	<label for="header-search">
		<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label' ); ?></span>
		<span class="search-label"><i class="icon-search"></i></span>
	</label>
</form>
