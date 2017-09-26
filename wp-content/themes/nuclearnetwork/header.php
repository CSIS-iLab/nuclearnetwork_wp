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
			<div class="header-logo col-xs-2 col-md-4">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<!--<img src="/wp-content/themes/nuclearnetwork/img/NGNN-header-logo.svg" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" class="logo-big" /> -->
					<div class="logo-container">
					<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 289.56 96.58" class="logo-big"><defs><linearGradient id="linear-gradient" x1="23.91" y1="62.8" x2="67.34" y2="39.02" gradientTransform="matrix(1, 0, 0, -1, 1.55, 101.12)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#a3a5a9"/><stop offset=".22" stop-color="#a3a5a9" stop-opacity=".73"/><stop offset=".66" stop-color="#a3a5a9" stop-opacity=".16"/><stop offset=".67" stop-color="#a3a5a9" stop-opacity=".12"/><stop offset=".7" stop-color="#a3a5a9" stop-opacity=".05"/><stop offset=".74" stop-color="#a3a5a9" stop-opacity=".01"/><stop offset=".87" stop-color="#a3a5a9" stop-opacity="0"/></linearGradient><linearGradient id="linear-gradient-2" x1="11.11" y1="68.85" x2="80.21" y2="33.05" gradientTransform="matrix(1, 0, 0, -1, 1.55, 101.12)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#a3a5a9"/><stop offset=".1" stop-color="#a3a5a9" stop-opacity=".95"/><stop offset=".26" stop-color="#a3a5a9" stop-opacity=".82"/><stop offset=".45" stop-color="#a3a5a9" stop-opacity=".6"/><stop offset=".68" stop-color="#a3a5a9" stop-opacity=".3"/><stop offset=".77" stop-color="#a3a5a9" stop-opacity=".16"/><stop offset=".78" stop-color="#a3a5a9" stop-opacity=".12"/><stop offset=".79" stop-color="#a3a5a9" stop-opacity=".05"/><stop offset=".81" stop-color="#a3a5a9" stop-opacity=".01"/><stop offset=".87" stop-color="#a3a5a9" stop-opacity="0"/></linearGradient><linearGradient id="linear-gradient-3" x1=".12" y1="63.52" x2="91.15" y2="38.3" gradientTransform="matrix(1, 0, 0, -1, 1.55, 101.12)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#a3a5a9"/><stop offset=".19" stop-color="#a3a5a9" stop-opacity=".98"/><stop offset=".33" stop-color="#a3a5a9" stop-opacity=".92"/><stop offset=".45" stop-color="#a3a5a9" stop-opacity=".83"/><stop offset=".57" stop-color="#a3a5a9" stop-opacity=".69"/><stop offset=".68" stop-color="#a3a5a9" stop-opacity=".52"/><stop offset=".79" stop-color="#a3a5a9" stop-opacity=".3"/><stop offset=".85" stop-color="#a3a5a9" stop-opacity=".16"/><stop offset=".86" stop-color="#a3a5a9" stop-opacity=".12"/><stop offset=".88" stop-color="#a3a5a9" stop-opacity=".05"/><stop offset=".91" stop-color="#a3a5a9" stop-opacity=".01"/><stop offset="1" stop-color="#a3a5a9" stop-opacity="0"/></linearGradient></defs><title>Logo-animation</title><g id="Inner-Ring"><g id="Inner-Orbit"><path d="M67.7,61.44a24.07,24.07,0,0,1-44.09-4.32,24.39,24.39,0,0,1-1-9.56,24.08,24.08,0,1,1,45.08,13.9Zm0,0a23.48,23.48,0,0,0,2.68-8.71A22.73,22.73,0,1,0,53.69,72.46a22.94,22.94,0,0,0,8.11-4.08A23.48,23.48,0,0,0,67.7,61.44Z" transform="translate(0.01)" fill="url(#linear-gradient)"/></g><g id="Inner-Oval"><g id="Oval"><circle cx="23.65" cy="48.49" r="4.2" fill="#f1c161"/><path d="M23.64,45.29a3.2,3.2,0,1,1-3.2,3.2,3.2,3.2,0,0,1,3.2-3.2h0m0-2a5.2,5.2,0,1,0,5.2,5.2A5.2,5.2,0,0,0,23.64,43.29Z" transform="translate(0.01)" fill="#153553"/></g><circle id="Oval-guide" cx="47.19" cy="50.2" r="23.39" transform="translate(-18.41 71.23) rotate(-64.54)" fill="none"/></g></g><g id="Middle-Ring"><g id="Middle-Orbit"><path d="M80.55,67.47A38.22,38.22,0,1,1,76,25.33,38.25,38.25,0,0,1,80.55,67.47Zm0,0a37.7,37.7,0,0,0,4-14.07,36.93,36.93,0,1,0-13.2,25.47A37.7,37.7,0,0,0,80.55,67.47Z" transform="translate(0.01)" fill="url(#linear-gradient-2)"/></g><g id="Middle-Ovals"><circle id="Oval-guide-2" cx="47.19" cy="50.2" r="37.53" transform="translate(-18.41 71.23) rotate(-64.54)" fill="none"/><g id="Oval-2"><circle cx="18.25" cy="26.78" r="4.89" fill="#f1c161"/><path d="M18.24,22.89a3.89,3.89,0,1,1-3.89,3.89h0a3.89,3.89,0,0,1,3.89-3.89m0-2a5.89,5.89,0,1,0,5.89,5.89h0A5.89,5.89,0,0,0,18.24,20.89Z" transform="translate(0.01)" fill="#153553"/></g></g></g><g id="Outer-Ring"><g id="Outer-Orbit"><path d="M91.37,62.44a46.54,46.54,0,1,1-16-48.92A46.53,46.53,0,0,1,91.37,62.44Zm0,0A46.06,46.06,0,0,0,92.64,44.6,45.17,45.17,0,0,0,42.09,5.55l-.39.05A45.18,45.18,0,1,0,83.28,78.39,46.06,46.06,0,0,0,91.37,62.44Z" transform="translate(0.01)" fill="url(#linear-gradient-3)"/></g><g id="Outer-Ovals"><g id="Oval-small"><circle id="Oval-guide-3" cx="47.19" cy="50.2" r="45.85" transform="translate(-18.41 71.23) rotate(-64.54)" fill="none"/><g id="Oval2"><g id="Oval2-background"><circle cx="67.24" cy="91.06" r="3.3" fill="#153553"/><path d="M67.23,88.77a2.3,2.3,0,1,1-2.3,2.3,2.3,2.3,0,0,1,2.3-2.3h0m0-2a4.3,4.3,0,1,0,4.3,4.3,4.3,4.3,0,0,0-4.3-4.3Z" transform="translate(0.01)" fill="#153553"/></g><circle id="Oval2-yellow" cx="67.24" cy="91.06" r="2.3" fill="#f1c161" opacity=".35" style="isolation:isolate"/></g></g><g id="Oval-large"><circle id="Oval-guide-4" cx="47.19" cy="50.2" r="45.85" transform="translate(-18.41 71.23) rotate(-64.54)" fill="none"/><g id="Oval1"><g id="Oval1-background"><path d="M54.25,9.43a4.21,4.21,0,1,1,4.14-4.9h0a4.18,4.18,0,0,1-4.14,4.89Z" transform="translate(0.01)" fill="#153553"/><path d="M54.26,2a3.22,3.22,0,0,1,.51,6.39,3.24,3.24,0,0,1-1-6.39,3.24,3.24,0,0,1,.52,0m0-2h0a5.26,5.26,0,0,0-.84.07,5.21,5.21,0,0,0,.83,10.36A5.22,5.22,0,0,0,54.26,0Z" transform="translate(0.01)" fill="#153553"/></g><g id="Oval1-yellow" opacity=".7"><circle cx="54.25" cy="5.22" r="3.22" transform="translate(-0.12 8.78) rotate(-9.24)" fill="#f1c161"/></g></g></g></g></g><g id="Logo-Text"><g id="Letters"><polygon id="Shape" points="50.36 46.32 50.36 58.89 48.42 58.89 48.42 41.98 49.56 41.98 59.16 54.89 59.05 42.2 60.99 42.2 60.99 59.12 59.85 59.12 50.36 46.32" fill="#fff"/><polygon id="Shape-2" points="66.7 41.98 75.73 41.98 75.73 43.8 68.65 43.8 68.65 49.41 75.16 49.41 75.16 51.23 68.65 51.23 68.65 57.29 75.85 57.29 75.85 59.12 66.7 59.12 66.7 41.98" fill="#fff"/><polygon id="Shape-3" points="86.13 50.43 80.88 41.98 83.39 41.98 87.39 48.83 91.73 41.98 93.9 41.98 88.53 50.32 94.13 59.12 91.73 59.12 87.39 52.26 82.7 59.12 80.42 59.12 86.13 50.43" fill="#fff"/><polygon id="Shape-4" points="110.13 43.8 104.88 43.8 104.88 59.12 102.82 59.12 102.82 43.8 97.56 43.8 97.56 41.98 110.13 41.98 110.13 43.8" fill="#fff"/><path id="Shape-5" d="M127,50.55H133v7.31c-.34.23-.57.34-.91.57a4.17,4.17,0,0,1-1.26.46c-.46.12-.91.11-1.37.23a5.56,5.56,0,0,1-1.37.11,9.63,9.63,0,0,1-3.09-.46,6.81,6.81,0,0,1-2.4-1.6,9,9,0,0,1-1.6-2.63,12.33,12.33,0,0,1,.11-7.77,7.25,7.25,0,0,1,1.83-2.65,7,7,0,0,1,2.51-1.49,7.89,7.89,0,0,1,2.86-.46,18.52,18.52,0,0,1,2.51.11,9.52,9.52,0,0,1,1.71.46l-.57,1.71a9,9,0,0,0-3.39-.53,6.47,6.47,0,0,0-2.06.34,4.85,4.85,0,0,0-1.94,1.15,8.08,8.08,0,0,0-1.37,2.06,10.5,10.5,0,0,0-.57,3.2,9.63,9.63,0,0,0,.46,3.09,7.9,7.9,0,0,0,1.14,2.17A4.06,4.06,0,0,0,126,57.19a8.9,8.9,0,0,0,2.4.46,7.36,7.36,0,0,0,2.74-.57v-5h-4.11Z" transform="translate(0.01)" fill="#fff"/><polygon id="Shape-6" points="138.7 41.98 147.73 41.98 147.73 43.8 140.65 43.8 140.65 49.41 147.16 49.41 147.16 51.23 140.65 51.23 140.65 57.29 147.85 57.29 147.85 59.12 138.7 59.12 138.7 41.98" fill="#fff"/><polygon id="Shape-7" points="171.85 41.98 180.88 41.98 180.88 43.8 173.79 43.8 173.79 49.41 180.19 49.41 180.19 51.23 173.79 51.23 173.79 57.29 180.99 57.29 180.99 59.12 171.85 59.12 171.85 41.98" fill="#fff"/><path id="Shape-8" d="M186.69,42.21a12.66,12.66,0,0,1,2.17-.23,14.57,14.57,0,0,1,2.17-.11,17.61,17.61,0,0,1,2.17.23,4,4,0,0,1,1.71.8,5.13,5.13,0,0,1,1.26,1.49,5.26,5.26,0,0,1-.57,5.49,5.11,5.11,0,0,1-2.51,1.49l5,7.54H195.8l-4.69-7.31h-2.4v7.31h-2.06Zm3.77,1.26h-1.6v6.4h1.94a4.56,4.56,0,0,0,2.74-.8,3.16,3.16,0,0,0,1.14-2.63,3.12,3.12,0,0,0-.91-2.17,5.57,5.57,0,0,0-3.31-.81Z" transform="translate(0.01)" fill="#fff"/><path id="Shape-9" d="M212.55,54.43h-6.2l-1.71,4.69H202.7L209.1,42H210l6.4,17.14h-2.17Zm-5.49-1.71H212l-2.42-7.09Z" transform="translate(0.01)" fill="#fff"/><polygon id="Shape-10" points="230.13 43.8 224.88 43.8 224.88 59.12 222.82 59.12 222.82 43.8 217.56 43.8 217.56 41.98 230.13 41.98 230.13 43.8" fill="#fff"/><polygon id="Shape-11" points="234.7 41.98 236.99 41.98 236.99 59.12 234.7 59.12 234.7 41.98" fill="#fff"/><path id="Shape-12" d="M242.69,50.55c0-2.74.57-4.91,1.83-6.29a6.52,6.52,0,0,1,5-2.29,9.8,9.8,0,0,1,3.09.57,6.29,6.29,0,0,1,2.17,1.71A7.53,7.53,0,0,1,256,47a17.67,17.67,0,0,1,.46,3.54c0,2.74-.57,4.91-1.83,6.29a6.59,6.59,0,0,1-5.12,2.3,9.8,9.8,0,0,1-3.09-.57,8,8,0,0,1-2.17-1.71A7.53,7.53,0,0,1,243,54.12a18.61,18.61,0,0,1-.34-3.54Zm2.17,0a20.4,20.4,0,0,0,.23,2.63,7.08,7.08,0,0,0,.8,2.17,4.61,4.61,0,0,0,1.49,1.49,4.73,4.73,0,0,0,2.17.57,4.28,4.28,0,0,0,3.54-1.71,9,9,0,0,0,1.26-5.14,20.4,20.4,0,0,0-.23-2.63,5.2,5.2,0,0,0-.91-2.17,4.61,4.61,0,0,0-1.49-1.49,4.73,4.73,0,0,0-2.17-.57,4.07,4.07,0,0,0-3.43,1.71A7.49,7.49,0,0,0,244.86,50.55Z" transform="translate(0.01)" fill="#fff"/><path id="Shape-13" d="M74.92,64.83h3.2V75.69a8.31,8.31,0,0,1-.46,2.86,5.16,5.16,0,0,1-1.26,1.94,4.19,4.19,0,0,1-1.94,1.14,8.91,8.91,0,0,1-2.51.34q-6.51,0-6.51-5.83V64.83h3.31V75.46c.23,3,2.06,3.66,3.2,3.66s2.74-.57,3-3.54Z" transform="translate(0.01)" fill="#fff"/><path id="Shape-14" d="M93.66,81a4.69,4.69,0,0,1-1.94.8,17,17,0,0,1-2.4.23,9,9,0,0,1-3-.46,6.49,6.49,0,0,1-4.23-4.23,11.77,11.77,0,0,1-.69-4,10.07,10.07,0,0,1,.69-4.11,8.54,8.54,0,0,1,1.71-2.74,5.45,5.45,0,0,1,2.51-1.37A10.59,10.59,0,0,1,89,64.61a8.17,8.17,0,0,1,2.4.23,9.52,9.52,0,0,1,1.71.46L92.55,68a6.44,6.44,0,0,0-1.37-.46,10.46,10.46,0,0,0-1.83-.11A4.4,4.4,0,0,0,86,68.83a6.56,6.56,0,0,0-1.26,4.34,8.7,8.7,0,0,0,.34,2.4A5.5,5.5,0,0,0,86,77.4a3.21,3.21,0,0,0,1.6,1.14,4.48,4.48,0,0,0,2.06.46,8.88,8.88,0,0,0,1.83-.23,7,7,0,0,0,1.37-.57Z" transform="translate(0.01)" fill="#fff"/><polygon id="Shape-15" points="107.85 81.98 97.56 81.98 97.56 64.83 100.76 64.83 100.76 79 107.85 79 107.85 81.98" fill="#fff"/><polygon id="Shape-16" points="112.42 64.83 122.59 64.83 122.59 67.81 115.73 67.81 115.73 71.81 121.9 71.81 121.9 74.78 115.73 74.78 115.73 79 122.7 79 122.7 81.98 112.42 81.98 112.42 64.83" fill="#fff"/><path id="Shape-17" d="M136.06,78.21H130.8L129.55,82h-3.43l6.17-17.14h2.51L141,82h-3.54Zm-4.46-2.63h3.66l-1.71-5.95Z" transform="translate(0.01)" fill="#fff"/><path id="Shape-18" d="M144.41,65.18c.34-.11.8-.11,1.14-.23a20.53,20.53,0,0,1,2.51-.23,22.6,22.6,0,0,1,3.43.23,5.13,5.13,0,0,1,2.06.8A3.71,3.71,0,0,1,155,67.24a5.2,5.2,0,0,1,.57,2.29,5.29,5.29,0,0,1-2.86,5L157,82h-3.77l-4-7h-1.49v6.86h-3.31Zm3.2,2.51v5H149a3.45,3.45,0,0,0,2.17-.57,2.27,2.27,0,0,0,.8-2.06,2.33,2.33,0,0,0-.69-1.71,2.6,2.6,0,0,0-1.83-.69Z" transform="translate(0.01)" fill="#fff"/><polygon id="Shape-19" points="186.7 64.83 196.88 64.83 196.88 67.81 190.02 67.81 190.02 71.81 196.19 71.81 196.19 74.78 190.02 74.78 190.02 79 196.99 79 196.99 81.98 186.7 81.98 186.7 64.83" fill="#fff"/><polygon id="Shape-20" points="215.28 67.81 210.13 67.81 210.13 81.86 206.7 81.86 206.7 67.81 201.56 67.81 201.56 64.83 215.28 64.83 215.28 67.81" fill="#fff"/><polygon id="Shape-21" points="224.65 75.12 228.19 64.83 230.36 64.83 233.56 75.12 235.96 64.83 239.28 64.83 234.7 81.86 232.53 81.86 229.1 71 225.56 81.86 223.28 81.86 218.7 64.83 222.25 64.83 224.65 75.12" fill="#fff"/><path id="Shape-22" d="M241.55,73.52c0-2.74.57-4.8,1.83-6.17a6.22,6.22,0,0,1,5-2.17,7.16,7.16,0,0,1,3.09.69,5,5,0,0,1,2.08,1.71,8,8,0,0,1,1.26,2.63,11.8,11.8,0,0,1,.46,3.43c0,2.74-.57,4.8-1.83,6.17a6.22,6.22,0,0,1-5,2.17,7.54,7.54,0,0,1-3.09-.69,5,5,0,0,1-2.06-1.71A8,8,0,0,1,242,76.95,11.8,11.8,0,0,1,241.55,73.52Zm3.2,0a14,14,0,0,0,.23,2.17,5,5,0,0,0,.69,1.83,2.5,2.5,0,0,0,1,1.14,2.62,2.62,0,0,0,1.6.46,3.2,3.2,0,0,0,2.63-1.37,8.18,8.18,0,0,0,.91-4.34,14,14,0,0,0-.23-2.17,5,5,0,0,0-.69-1.83,2.5,2.5,0,0,0-1-1.14,3.11,3.11,0,0,0-4.23.91,8.47,8.47,0,0,0-.91,4.34Z" transform="translate(0.01)" fill="#fff"/><polygon id="Shape-23" points="279.96 74.79 279.28 74.79 279.28 81.99 275.85 81.99 275.85 64.96 279.28 64.96 279.28 72.62 284.88 64.96 288.76 64.96 282.36 73.08 289.56 81.99 285.33 81.99 279.96 74.79" fill="#fff"/><polygon id="Shape-24" points="155.5 46.32 155.5 58.89 153.56 58.89 153.56 41.98 154.7 41.98 164.3 54.89 164.19 42.2 166.13 42.2 166.13 59.12 164.99 59.12 155.5 46.32" fill="#fff"/><polygon id="Shape-25" points="264.08 46.32 264.08 58.89 262.13 58.89 262.13 41.98 263.28 41.98 272.88 54.89 272.76 42.2 274.7 42.2 274.7 59.12 273.56 59.12 264.08 46.32" fill="#fff"/><polygon id="Shape-26" points="173.68 73.06 172.65 71.58 172.65 81.86 169.56 81.86 169.56 64.83 171.85 64.83 178.13 73.86 179.05 75.23 179.05 64.95 182.13 64.95 182.13 81.98 179.85 81.98 173.68 73.06" fill="#fff"/><path id="Shape-27" d="M259.84,65.18c.34-.11.8-.11,1.14-.23a20.53,20.53,0,0,1,2.51-.23,22.6,22.6,0,0,1,3.43.23,5.13,5.13,0,0,1,2.06.8,3.71,3.71,0,0,1,1.49,1.49,5.2,5.2,0,0,1,.57,2.29,5.29,5.29,0,0,1-2.86,5L272.41,82h-3.77l-4-7h-1.49v6.86h-3.31Zm3.2,2.63v4.91h1.37a3.45,3.45,0,0,0,2.14-.6,2.27,2.27,0,0,0,.8-2.06,2.33,2.33,0,0,0-.69-1.71,2.6,2.6,0,0,0-1.83-.69,15.56,15.56,0,0,0-1.79.15Z" transform="translate(0.01)" fill="#fff"/></g><g id="LetterN"><polygon id="Shape-28" points="52.53 73.06 51.5 71.58 51.5 81.86 48.42 81.86 48.42 64.83 50.7 64.83 56.99 73.86 57.9 75.23 57.9 64.95 60.99 64.95 60.99 81.98 58.7 81.98 52.53 73.06" fill="#fff"/></g></g></svg>
				</div>
					<img src="/wp-content/themes/nuclearnetwork/img/NGNN-header-logo-small.svg" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" class="logo-small" />
				</a>
			</div>
			<div class="header-content-container col-xs-10 col-md-8">
				<div class="header-top row hidden-xs hidden-sm middle-md">
					<div class="social-container col-md-4 col-lg-3">
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
					<div class="search-container col-md-8 col-lg-9">
						<?php get_template_part( 'search-inline' ); ?>
					</div>
				</div>
				<nav id="site-navigation" class="header-bottom main-navigation row middle-xs">
					<div class="col-xs-10 hidden-md hidden-lg">
						<button class="btn btn-transparent menu-toggle" aria-controls="primary-menu" aria-expanded="false">
							<span id="menu-toggle-menu"><?php esc_html_e( 'Menu', 'nuclearnetwork' ); ?></span>
							<span id="menu-toggle-close" class="is-hidden"><i class="icon-close"></i></span>
						</button>
					</div>
					<div class="menu-container col-md-9 col-lg-8">
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
