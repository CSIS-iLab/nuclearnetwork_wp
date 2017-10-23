/**
 * Guest Author Authenticator
 */

( function( $ ) {
	var emailInput = 'input[name=ap_form_author_email]';
	if ( $( emailInput ).length ) {

		//setup before functions
		var typingTimer;                //timer identifier
		var doneTypingInterval = 3000;  //time in ms (5 seconds)

		//on keyup, start the countdown
		$( emailInput ).keyup(function(){
		    clearTimeout(typingTimer);
		    if ( $( emailInput).val() ) {
		        typingTimer = setTimeout(doneTyping, doneTypingInterval);
		    }
		});

		//user is "finished typing," do something
		function doneTyping () {
			var email = $( emailInput ).val();
		    $.ajax({
		        url: '/wp-json/guest-author/v1/email?email=' + email,
		        method: 'GET',
		        contentType: 'application/json',
		        success: function( data ) {

		        	if( data ) {
			            if ( data['post_title'] ) {
			            	$( 'input[name=ap_form_author_name]' ).val( data['post_title'] );
			            }

			            if ( data['biography'] ) {
			            	$( 'textarea[name=ap_author_bio]' ).val( data['biography'] );
			            }
			        }

		            $( '.author_name, .ap_author_bio' ).addClass('is-visible');
		        },
		        error: function( error ) {
		            console.log( error );
		        }
		    });
		}
	}

} )( jQuery );