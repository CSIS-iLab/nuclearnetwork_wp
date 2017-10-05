/**
 * Guest Author Authenticator
 */

( function( $ ) {
	if ( $( 'input[name=ap_form_author_email]' ).length ) {
		wp.api.loadPromise.done( function() {
			var postMeta = new wp.api.collections.Guestauthor();
			postMeta.fetch();

			console.log(postMeta);

			var author = postMeta.findWhere( { cap_user_email: 'jnschrag@gmail.com' });
			// author.fetch();
			console.log(author);

		} );
	}

} )( jQuery );