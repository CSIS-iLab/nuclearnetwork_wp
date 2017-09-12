<?php
/**
 * Share Component
 *
 * @package Nuclear_Network
 */

?>

<div class="share-container">
	<div class="share-open-container">
		<button class="open-share"><i class="icon-share"></i> Share</button>
		<button class="to-top">Top <i class="icon-arrow-up"></i></button>
	</div>
	<div class="share-close-container">
		<button class="share-close"><i class="icon-close"></i></button>
		<?php
		if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) {
			ADDTOANY_SHARE_SAVE_KIT();
		}
		?>
	</div>
</div>
