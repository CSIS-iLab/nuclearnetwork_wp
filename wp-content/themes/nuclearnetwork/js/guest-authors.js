/**
 * Guest Author Authenticator
 */

( function( $ ) {
	var emailInput = 'input[name=ap_form_author_email]';
	if ( $( emailInput ).length ) {

		// Alert
		$('.author_email').before('<div class="author_alert">If you\'ve published content with us before, we\'ll look up your detailed information based on your email address.</div>');

		// Load Icon
		$( emailInput ).after('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');


		//setup before functions
		var typingTimer;                //timer identifier
		var doneTypingInterval = 1500;  //time in ms (5 seconds)

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
			$( '.spinner' ).addClass('is-visible');
		    $.ajax({
		        url: '/wp-json/guest-author/v1/email?email=' + email,
		        method: 'GET',
		        contentType: 'application/json',
		        success: function( data ) {

		        	if ( data ) {

		        		$( '.author_alert' ).text('Thank you for contributing content to the Nuclear Network! We have the following information for you on record. If you wish to change your information, you may do so by editing them below.');

			            if ( data['post_title'] ) {
			            	$( 'input[name=ap_form_author_name]' ).val( data['post_title'] );
			            }

			            if ( data['biography'] ) {
			            	$( 'textarea[name=ap_author_bio]' ).val( data['biography'] );
			            }
			        } else {
			        	$( '.author_alert' ).text('Thank you for contributing content to the Nuclear Network! Please provide your name and a brief biography.');
			        }

			        $( '.spinner' ).removeClass('is-visible');

			        $( '.author_alert' ).addClass('alert-blue');

		            $( '.author_name, .ap_author_bio' ).addClass('is-visible');
		        },
		        error: function( error ) {
		            console.log( error );
		        }
		    });
		}
	}

} )( jQuery );