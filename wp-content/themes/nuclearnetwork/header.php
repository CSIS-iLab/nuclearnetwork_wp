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
					<!--<img src="/wp-content/themes/nuclearnetwork/img/NGNN-header-logo.svg" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" class="logo-big" /> -->
					<div class="logo-container">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 289.55 96.56" class="logo-big" ><defs><linearGradient id="linear-gradient" x1="23.92" y1="35.19" x2="67.35" y2="58.97" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#a3a5a9"/><stop offset=".22" stop-color="#a3a5a9" stop-opacity=".73"/><stop offset=".66" stop-color="#a3a5a9" stop-opacity=".16"/><stop offset=".67" stop-color="#a3a5a9" stop-opacity=".12"/><stop offset=".7" stop-color="#a3a5a9" stop-opacity=".05"/><stop offset=".74" stop-color="#a3a5a9" stop-opacity=".01"/><stop offset=".87" stop-color="#a3a5a9" stop-opacity="0"/></linearGradient><linearGradient id="linear-gradient-2" x1="11.09" y1="29.18" x2="80.19" y2="64.98" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#a3a5a9"/><stop offset=".1" stop-color="#a3a5a9" stop-opacity=".95"/><stop offset=".26" stop-color="#a3a5a9" stop-opacity=".82"/><stop offset=".45" stop-color="#a3a5a9" stop-opacity=".6"/><stop offset=".68" stop-color="#a3a5a9" stop-opacity=".3"/><stop offset=".77" stop-color="#a3a5a9" stop-opacity=".16"/><stop offset=".78" stop-color="#a3a5a9" stop-opacity=".12"/><stop offset=".79" stop-color="#a3a5a9" stop-opacity=".05"/><stop offset=".81" stop-color="#a3a5a9" stop-opacity=".01"/><stop offset=".87" stop-color="#a3a5a9" stop-opacity="0"/></linearGradient><linearGradient id="linear-gradient-3" x1=".12" y1="34.47" x2="91.15" y2="59.69" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#a3a5a9"/><stop offset=".19" stop-color="#a3a5a9" stop-opacity=".98"/><stop offset=".33" stop-color="#a3a5a9" stop-opacity=".92"/><stop offset=".45" stop-color="#a3a5a9" stop-opacity=".83"/><stop offset=".57" stop-color="#a3a5a9" stop-opacity=".69"/><stop offset=".68" stop-color="#a3a5a9" stop-opacity=".52"/><stop offset=".79" stop-color="#a3a5a9" stop-opacity=".3"/><stop offset=".85" stop-color="#a3a5a9" stop-opacity=".16"/><stop offset=".86" stop-color="#a3a5a9" stop-opacity=".12"/><stop offset=".88" stop-color="#a3a5a9" stop-opacity=".05"/><stop offset=".91" stop-color="#a3a5a9" stop-opacity=".01"/><stop offset="1" stop-color="#a3a5a9" stop-opacity="0"/></linearGradient></defs><title>Logo animation</title><g id="Inner-Ring"><g id="Inner-Orbit"><path d="M66.15,58.32A24.07,24.07,0,0,1,22.06,54a24.39,24.39,0,0,1-1-9.56,24.09,24.09,0,0,1,9.08-16.59,24.07,24.07,0,0,1,36,30.49Zm0,0a23.48,23.48,0,0,0,2.68-8.71A22.68,22.68,0,0,0,39.41,25.77,22.7,22.7,0,0,0,52.14,69.34a22.94,22.94,0,0,0,8.11-4.08A23.48,23.48,0,0,0,66.15,58.32Z" transform="translate(1.55 3.12)" fill="url(#linear-gradient)"/></g><g id="Inner-Oval"><g id="Oval"><circle cx="23.64" cy="48.49" r="4.2" fill="#f0c061"/><path d="M22.09,42.17a3.2,3.2,0,1,1-3.2,3.2,3.2,3.2,0,0,1,3.2-3.2m0-2a5.2,5.2,0,1,0,5.2,5.2,5.21,5.21,0,0,0-5.2-5.2Z" transform="translate(1.55 3.12)" fill="#0f2335"/></g><circle id="Oval-guide" cx="45.64" cy="47.08" r="23.39" transform="translate(-14.94 71.17) rotate(-64.54)" fill="none"/></g></g><g id="Middle-Ring"><g id="Middle-Orbit"><path d="M79,64.35A38.25,38.25,0,0,1,8.74,58.8a38.59,38.59,0,0,1-1.81-15A38.22,38.22,0,0,1,20.6,17.37,38.22,38.22,0,0,1,79,64.35Zm0,0a37.7,37.7,0,0,0,4-14.07,36.84,36.84,0,1,0-72,7.8,36.81,36.81,0,0,0,58.8,17.67A37.7,37.7,0,0,0,79,64.35Z" transform="translate(1.55 3.12)" fill="url(#linear-gradient-2)"/></g><g id="Middle-Ovals"><circle id="Oval-guide-2" data-name="Oval-guide" cx="45.64" cy="47.08" r="37.53" transform="translate(-14.94 71.17) rotate(-64.54)" fill="none"/><g id="Oval-2" data-name="Oval"><circle cx="18.24" cy="26.78" r="4.89" fill="#f0c061"/><path d="M16.69,19.77a3.89,3.89,0,1,1-3.89,3.89,3.89,3.89,0,0,1,3.89-3.89m0-2a5.89,5.89,0,1,0,5.89,5.89,5.89,5.89,0,0,0-5.89-5.89Z" transform="translate(1.55 3.12)" fill="#0f2335"/></g></g></g><g id="Outer-Ring"><g id="Outer-Orbit"><path d="M89.82,59.32a46.53,46.53,0,0,1-91-6.48,46.53,46.53,0,0,1,9.64-34.8A46.54,46.54,0,0,1,89.82,59.32Zm0,0a46.06,46.06,0,0,0,1.27-17.84,45.17,45.17,0,0,0-50.94-39,45.17,45.17,0,0,0-6.57,88.1A45.11,45.11,0,0,0,81.73,75.27,46.06,46.06,0,0,0,89.82,59.32Z" transform="translate(1.55 3.12)" fill="url(#linear-gradient-3)"/></g><g id="Outer-Ovals"><g id="Oval-small"><circle id="Oval-guide-3" data-name="Oval-guide" cx="45.64" cy="47.08" r="45.85" transform="translate(-14.94 71.17) rotate(-64.54)" fill="none"/><g id="Oval2"><g id="Oval2-background" style="isolation:isolate"><circle cx="67.23" cy="91.06" r="3.3" fill="#0f2335"/><path d="M65.68,85.65a2.3,2.3,0,1,1-2.3,2.3,2.3,2.3,0,0,1,2.3-2.3m0-2a4.3,4.3,0,1,0,4.3,4.3,4.3,4.3,0,0,0-4.3-4.3Z" transform="translate(1.55 3.12)" fill="#0f2335"/></g><circle id="Oval2-yellow" cx="67.23" cy="91.06" r="2.3" fill="#f0c061" opacity=".35" style="isolation:isolate"/></g></g><g id="Oval-large"><circle id="Oval-guide-4" data-name="Oval-guide" cx="45.64" cy="47.08" r="45.85" transform="translate(-14.94 71.17) rotate(-64.54)" fill="none"/><g id="Oval1"><g id="Oval1-background"><path d="M52.7,6.31A4.22,4.22,0,0,1,52-2.06a4.21,4.21,0,0,1,4.84,3.48,4.22,4.22,0,0,1-3.48,4.84A4.19,4.19,0,0,1,52.7,6.31Z" transform="translate(1.55 3.12)" fill="#0f2335"/><path d="M52.71-1.12a3.22,3.22,0,0,1,.51,6.39,3.24,3.24,0,0,1-.52,0,3.22,3.22,0,0,1-.51-6.39,3.24,3.24,0,0,1,.52,0m0-2h0a5.26,5.26,0,0,0-.84.07A5.18,5.18,0,0,0,48.47-1a5.18,5.18,0,0,0-.92,3.88A5.19,5.19,0,0,0,52.7,7.31a5.25,5.25,0,0,0,.84-.07,5.22,5.22,0,0,0-.83-10.36Z" transform="translate(1.55 3.12)" fill="#102335"/></g><g id="Oval1-yellow" opacity=".7"><circle cx="52.7" cy="2.1" r="3.22" transform="translate(1.9 11.61) rotate(-9.24)" fill="#f0c061"/></g></g></g></g></g><g id="Logo-Text"><g id="Letters"><polygon id="Shape" points="50.35 46.32 50.35 58.89 48.41 58.89 48.41 41.98 49.55 41.98 59.15 54.89 59.04 42.2 60.98 42.2 60.98 59.12 59.84 59.12 50.35 46.32" fill="#fff"/><polygon id="Shape-2" data-name="Shape" points="66.69 41.98 75.72 41.98 75.72 43.8 68.64 43.8 68.64 49.41 75.15 49.41 75.15 51.23 68.64 51.23 68.64 57.29 75.84 57.29 75.84 59.12 66.69 59.12 66.69 41.98" fill="#fff"/><polygon id="Shape-3" data-name="Shape" points="86.12 50.43 80.87 41.98 83.38 41.98 87.38 48.83 91.72 41.98 93.89 41.98 88.52 50.32 94.12 59.12 91.72 59.12 87.38 52.26 82.69 59.12 80.41 59.12 86.12 50.43" fill="#fff"/><polygon id="Shape-4" data-name="Shape" points="110.12 43.8 104.87 43.8 104.87 59.12 102.81 59.12 102.81 43.8 97.55 43.8 97.55 41.98 110.12 41.98 110.12 43.8" fill="#fff"/><path id="Shape-5" data-name="Shape" d="M125.49,47.43h5.94v7.31c-.34.23-.57.34-.91.57s-.8.34-1.26.46-.91.11-1.37.23a5.56,5.56,0,0,1-1.37.11,9.63,9.63,0,0,1-3.09-.46,6.81,6.81,0,0,1-2.4-1.6,9,9,0,0,1-1.6-2.63,12.33,12.33,0,0,1,.11-7.77A7.25,7.25,0,0,1,121.37,41a7,7,0,0,1,2.51-1.49,7.89,7.89,0,0,1,2.86-.46,18.52,18.52,0,0,1,2.51.11,9.52,9.52,0,0,1,1.71.46l-.57,1.71A9,9,0,0,0,127,40.8a6.47,6.47,0,0,0-2.06.34A4.85,4.85,0,0,0,123,42.29a8.08,8.08,0,0,0-1.37,2.06,10.5,10.5,0,0,0-.57,3.2,9.63,9.63,0,0,0,.46,3.09,7.9,7.9,0,0,0,1.14,2.17,4.06,4.06,0,0,0,1.83,1.26,8.9,8.9,0,0,0,2.4.46,7.36,7.36,0,0,0,2.74-.57V49h-4.11Z" transform="translate(1.55 3.12)" fill="#fff"/><polygon id="Shape-6" data-name="Shape" points="138.69 41.98 147.72 41.98 147.72 43.8 140.64 43.8 140.64 49.41 147.15 49.41 147.15 51.23 140.64 51.23 140.64 57.29 147.84 57.29 147.84 59.12 138.69 59.12 138.69 41.98" fill="#fff"/><polygon id="Shape-7" data-name="Shape" points="171.84 41.98 180.87 41.98 180.87 43.8 173.78 43.8 173.78 49.41 180.18 49.41 180.18 51.23 173.78 51.23 173.78 57.29 180.98 57.29 180.98 59.12 171.84 59.12 171.84 41.98" fill="#fff"/><path id="Shape-8" data-name="Shape" d="M185.14,39.09a12.66,12.66,0,0,1,2.17-.23,14.57,14.57,0,0,1,2.17-.11,17.61,17.61,0,0,1,2.17.23,4,4,0,0,1,1.71.8,5.13,5.13,0,0,1,1.26,1.49,5.26,5.26,0,0,1-.57,5.49,5.11,5.11,0,0,1-2.51,1.49l5,7.54h-2.29l-4.69-7.31h-2.4v7.31h-2.06Zm3.77,1.26h-1.6v6.4h1.94a4.56,4.56,0,0,0,2.74-.8,3.16,3.16,0,0,0,1.14-2.63,3.12,3.12,0,0,0-.91-2.17A5.57,5.57,0,0,0,188.91,40.34Z" transform="translate(1.55 3.12)" fill="#fff"/><path id="Shape-9" data-name="Shape" d="M211,51.31H204.8L203.09,56h-1.94l6.4-17.14h.91L214.86,56h-2.17Zm-5.49-1.71h4.91L208,42.51Z" transform="translate(1.55 3.12)" fill="#fff"/><polygon id="Shape-10" data-name="Shape" points="230.12 43.8 224.87 43.8 224.87 59.12 222.81 59.12 222.81 43.8 217.55 43.8 217.55 41.98 230.12 41.98 230.12 43.8" fill="#fff"/><polygon id="Shape-11" data-name="Shape" points="234.69 41.98 236.98 41.98 236.98 59.12 234.69 59.12 234.69 41.98" fill="#fff"/><path id="Shape-12" data-name="Shape" d="M241.14,47.43c0-2.74.57-4.91,1.83-6.29a6.52,6.52,0,0,1,5-2.29,9.8,9.8,0,0,1,3.09.57,6.29,6.29,0,0,1,2.17,1.71,7.53,7.53,0,0,1,1.26,2.74,17.67,17.67,0,0,1,.46,3.54c0,2.74-.57,4.91-1.83,6.29A6.59,6.59,0,0,1,248,56a9.8,9.8,0,0,1-3.09-.57,8,8,0,0,1-2.17-1.71A7.53,7.53,0,0,1,241.49,51a18.61,18.61,0,0,1-.34-3.54Zm2.17,0a20.4,20.4,0,0,0,.23,2.63,7.08,7.08,0,0,0,.8,2.17,4.61,4.61,0,0,0,1.49,1.49,4.73,4.73,0,0,0,2.17.57,4.28,4.28,0,0,0,3.54-1.71,9,9,0,0,0,1.26-5.14,20.4,20.4,0,0,0-.23-2.63,5.2,5.2,0,0,0-.91-2.17,4.61,4.61,0,0,0-1.49-1.49,4.73,4.73,0,0,0-2.17-.57,4.07,4.07,0,0,0-3.43,1.71,7.49,7.49,0,0,0-1.26,5.14Z" transform="translate(1.55 3.12)" fill="#fff"/><path id="Shape-13" data-name="Shape" d="M73.37,61.71h3.2V72.57a8.31,8.31,0,0,1-.46,2.86,5.16,5.16,0,0,1-1.26,1.94,4.19,4.19,0,0,1-1.94,1.14,8.91,8.91,0,0,1-2.51.34q-6.51,0-6.51-5.83V61.71H67.2V72.34c.23,3,2.06,3.66,3.2,3.66s2.74-.57,3-3.54Z" transform="translate(1.55 3.12)" fill="#fff"/><path id="Shape-14" data-name="Shape" d="M92.11,77.83a4.69,4.69,0,0,1-1.94.8,17.05,17.05,0,0,1-2.4.23,9,9,0,0,1-3-.46,6.49,6.49,0,0,1-4.23-4.23,11.77,11.77,0,0,1-.69-4,10.07,10.07,0,0,1,.69-4.11,8.54,8.54,0,0,1,1.71-2.74,5.45,5.45,0,0,1,2.51-1.37,10.59,10.59,0,0,1,2.74-.46,8.17,8.17,0,0,1,2.4.23,9.52,9.52,0,0,1,1.71.46L91,64.91a6.44,6.44,0,0,0-1.37-.46,10.46,10.46,0,0,0-1.83-.11,4.4,4.4,0,0,0-3.31,1.37,6.56,6.56,0,0,0-1.26,4.34,8.7,8.7,0,0,0,.34,2.4,5.5,5.5,0,0,0,.91,1.83,3.21,3.21,0,0,0,1.6,1.14,4.48,4.48,0,0,0,2.06.46,8.88,8.88,0,0,0,1.83-.23,7,7,0,0,0,1.37-.57Z" transform="translate(1.55 3.12)" fill="#fff"/><polygon id="Shape-15" data-name="Shape" points="107.84 81.98 97.55 81.98 97.55 64.83 100.75 64.83 100.75 79 107.84 79 107.84 81.98" fill="#fff"/><polygon id="Shape-16" data-name="Shape" points="112.41 64.83 122.58 64.83 122.58 67.81 115.72 67.81 115.72 71.81 121.89 71.81 121.89 74.78 115.72 74.78 115.72 79 122.69 79 122.69 81.98 112.41 81.98 112.41 64.83" fill="#fff"/><path id="Shape-17" data-name="Shape" d="M134.51,75.09h-5.26L128,78.86h-3.43l6.17-17.14h2.51l6.17,17.14h-3.54Zm-4.46-2.63h3.66L132,66.51Z" transform="translate(1.55 3.12)" fill="#fff"/><path id="Shape-18" data-name="Shape" d="M142.86,62.06c.34-.11.8-.11,1.14-.23a20.53,20.53,0,0,1,2.51-.23,22.6,22.6,0,0,1,3.43.23,5.13,5.13,0,0,1,2.06.8,3.71,3.71,0,0,1,1.49,1.49,5.2,5.2,0,0,1,.57,2.29,5.29,5.29,0,0,1-2.86,5l4.23,7.43h-3.77l-4-7h-1.49v6.86h-3.31Zm3.2,2.51v5h1.37A3.45,3.45,0,0,0,149.6,69a2.27,2.27,0,0,0,.8-2.06,2.33,2.33,0,0,0-.69-1.71,2.6,2.6,0,0,0-1.83-.69Z" transform="translate(1.55 3.12)" fill="#fff"/><polygon id="Shape-19" data-name="Shape" points="186.69 64.83 196.87 64.83 196.87 67.81 190.01 67.81 190.01 71.81 196.18 71.81 196.18 74.78 190.01 74.78 190.01 79 196.98 79 196.98 81.98 186.69 81.98 186.69 64.83" fill="#fff"/><polygon id="Shape-20" data-name="Shape" points="215.27 67.81 210.12 67.81 210.12 81.86 206.69 81.86 206.69 67.81 201.55 67.81 201.55 64.83 215.27 64.83 215.27 67.81" fill="#fff"/><polygon id="Shape-21" data-name="Shape" points="224.64 75.12 228.18 64.83 230.35 64.83 233.55 75.12 235.95 64.83 239.27 64.83 234.69 81.86 232.52 81.86 229.09 71 225.55 81.86 223.27 81.86 218.69 64.83 222.24 64.83 224.64 75.12" fill="#fff"/><path id="Shape-22" data-name="Shape" d="M240,70.4c0-2.74.57-4.8,1.83-6.17a6.22,6.22,0,0,1,5-2.17,7.16,7.16,0,0,1,3.09.69A5,5,0,0,1,252,64.46a8,8,0,0,1,1.26,2.63,11.8,11.8,0,0,1,.46,3.43c0,2.74-.57,4.8-1.83,6.17a6.22,6.22,0,0,1-5,2.17,7.54,7.54,0,0,1-3.09-.69,5,5,0,0,1-2.06-1.71,8,8,0,0,1-1.26-2.63A11.8,11.8,0,0,1,240,70.4Zm3.2,0a14,14,0,0,0,.23,2.17,5,5,0,0,0,.69,1.83,2.5,2.5,0,0,0,1,1.14,2.62,2.62,0,0,0,1.6.46,3.2,3.2,0,0,0,2.63-1.37,8.18,8.18,0,0,0,.91-4.34,14,14,0,0,0-.23-2.17,5,5,0,0,0-.69-1.83,2.5,2.5,0,0,0-1-1.14,3.11,3.11,0,0,0-4.23.91,8.47,8.47,0,0,0-.91,4.34Z" transform="translate(1.55 3.12)" fill="#fff"/><polygon id="Shape-23" data-name="Shape" points="279.95 76.66 279.27 76.66 279.27 83.86 275.84 83.86 275.84 66.83 279.27 66.83 279.27 74.49 284.87 66.83 288.75 66.83 282.35 74.95 289.55 83.86 285.32 83.86 279.95 76.66" fill="#fff"/><polygon id="Shape-24" data-name="Shape" points="155.49 46.32 155.49 58.89 153.55 58.89 153.55 41.98 154.69 41.98 164.29 54.89 164.18 42.2 166.12 42.2 166.12 59.12 164.98 59.12 155.49 46.32" fill="#fff"/><polygon id="Shape-25" data-name="Shape" points="264.07 46.32 264.07 58.89 262.12 58.89 262.12 41.98 263.27 41.98 272.87 54.89 272.75 42.2 274.69 42.2 274.69 59.12 273.55 59.12 264.07 46.32" fill="#fff"/><polygon id="Shape-26" data-name="Shape" points="173.67 73.06 172.64 71.58 172.64 81.86 169.55 81.86 169.55 64.83 171.84 64.83 178.12 73.86 179.04 75.23 179.04 64.95 182.12 64.95 182.12 81.98 179.84 81.98 173.67 73.06" fill="#fff"/><path id="Shape-27" data-name="Shape" d="M258.29,62.06c.34-.11.8-.11,1.14-.23a20.53,20.53,0,0,1,2.51-.23,22.6,22.6,0,0,1,3.43.23,5.13,5.13,0,0,1,2.06.8,3.71,3.71,0,0,1,1.49,1.49,5.2,5.2,0,0,1,.57,2.29,5.29,5.29,0,0,1-2.86,5l4.23,7.43h-3.77l-4-7H261.6v6.86h-3.31Zm3.2,2.63V69.6h1.37A3.45,3.45,0,0,0,265,69a2.27,2.27,0,0,0,.8-2.06,2.33,2.33,0,0,0-.69-1.71,2.6,2.6,0,0,0-1.83-.69A15.56,15.56,0,0,0,261.49,64.69Z" transform="translate(1.55 3.12)" fill="#fff"/></g><g id="LetterN"><polygon id="Shape-28" data-name="Shape" points="52.52 73.06 51.49 71.58 51.49 81.86 48.41 81.86 48.41 64.83 50.69 64.83 56.98 73.86 57.89 75.23 57.89 64.95 60.98 64.95 60.98 81.98 58.69 81.98 52.52 73.06" fill="#fff"/></g></g></svg>
				</div>
					<img src="/wp-content/themes/nuclearnetwork/img/NGNN-header-logo-small.svg" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" class="logo-small" />
				</a>
			</div>
			<div class="header-content-container col-xs-10 col-sm-11 col-md-8">
				<div class="header-top row hidden-xs middle-sm">
					<div class="social-container col-sm-4 col-lg-3">
						<ul class="header-social">asdfsdf
							<?php
							if ( $facebook ) {
								echo '<li><a href="' . esc_url( $facebook ) . '"><i class="icon-facebook"></i></a></li>';
							}
							if ( $twitter ) {
								echo '<li><a href="https://twitter.com/' . esc_attr( $twitter ) . '"><i class="icon-twitter"></i></a></li>';
							}
							if ( $linkedin ) {
								echo '<li><a href="' . esc_url( $linkedin ) . '"><i class="icon-linkedin"></i></a></li>';
							}
							?>
						</ul>
					</div>
					<div class="search-container col-sm-8 col-lg-9">
						<?php get_template_part( 'search-inline' ); ?>
					</div>
				</div>
				<nav id="site-navigation" class="header-bottom main-navigation row middle-xs">
					<div class="visible-xs col-xs-10">
						<button class="btn btn-transparent menu-toggle" aria-controls="primary-menu" aria-expanded="false">
							<span id="menu-toggle-menu"><?php esc_html_e( 'Menu', 'nuclearnetwork' ); ?></span>
							<span id="menu-toggle-close" class="is-hidden"><i class="icon-close"></i></span>
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
								echo '<li><a href="' . esc_url( $facebook ) . '"><i class="icon-facebook"></i></a></li>';
							}
							if ( $twitter ) {
								echo '<li><a href="https://twitter.com/' . esc_attr( $twitter ) . '"><i class="icon-twitter"></i></a></li>';
							}
							if ( $linkedin ) {
								echo '<li><a href="' . esc_url( $linkedin ) . '"><i class="icon-linkedin"></i></a></li>';
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
