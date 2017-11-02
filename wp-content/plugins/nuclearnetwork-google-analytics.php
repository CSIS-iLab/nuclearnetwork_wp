<?php
/*
Plugin Name: Simple Google Analytics Plugin
Plugin URI: https://github.com/CSIS-iLab
Description: Adds a Google analytics tracking code to the <head> of your theme, by hooking to wp_head.
Author: CSIS iLab
Version: 1.0
 */

function nuclearnetwork_google_analytics() { ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109178732-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-109178732-1');
	</script>
<?php }
add_action( 'wp_head', 'nuclearnetwork_google_analytics', 10 );