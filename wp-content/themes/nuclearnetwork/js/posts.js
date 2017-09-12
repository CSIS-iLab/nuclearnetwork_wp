/**
 * JavaScript for Posts
 */

( function( $ ) {

  // Toggle class to expand sources.
  $(".sources-label").on("click", function() {
    $(this).toggleClass("is-active");
    $(".entry-content .sources").toggleClass("is-active");
  });

  // Toggle class to show share
  $(".open-share, .share-close").on("click", function() {
    $('.share-container .share-open-container').toggleClass('is-hidden');
    $('.share-container .share-close-container').toggleClass('is-active');
  });

  // Back to Top
  $(".to-top").on("click", function() {
    $('html,body').animate({
         scrollTop: 0
    }, 1000);
  });

	// Sticky Menu
	var windw = this;

	$.fn.followTo = function (from, bumper) {
	    var $this = this,
	        $window = $(windw),
	        $from = $(from),
	        $bumper = $(bumper),
	        $startPos = $from.offset().top + $from.outerHeight(true),
	        $startPosMinimalHeader = $from.offset().top + $from.outerHeight(true) - 25,
	        bumperPos = $bumper.offset().top,
	        thisHeight = $this.outerHeight(true),
	        $headerHeight = $(".site-header").height(),
	        setPosition = function(){

	            if ($window.scrollTop() == 0 ) { 
	                $this.css({
	                    position: 'absolute',
	                    top: $startPos
	                });
	            } else if ($window.scrollTop() < $startPos - 100 ) {
	            	$this.css({
	                    position: 'absolute',
	                    top: $startPosMinimalHeader
	                });
	            } else if ($window.scrollTop() > (bumperPos - thisHeight - 175)) {
	                $this.css({
	                    position: 'absolute',
	                    top: (bumperPos - thisHeight - 75)
	                });
	            } else {
	                $this.css({
	                    position: 'fixed',
	                    top: $headerHeight
	                });
	            }
	        };
	    $window.resize(function()
	    {
	        bumperPos = $bumper.offset().top;
	        thisHeight = $this.outerHeight();
	        setPosition();
	    });
	    $window.scroll(setPosition);
	    setPosition();
	};

	var sidebarPos = $('.post-sidebar').css('position');
	if(sidebarPos == 'fixed') {
		$('.post-sidebar').followTo('.entry-header', '.entry-footer');
	}

} )( jQuery );