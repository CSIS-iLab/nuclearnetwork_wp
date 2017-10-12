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
	        bumperPos = $bumper.offset().top,
	        thisHeight = $this.outerHeight(true),
	        $headerHeight = $(".site-header").height(),
	        sidebarMarginBottom = $('.post-sidebar').css('margin-bottom'),
	        setPosition = function(){

	        	if (sidebarMarginBottom != '0px') {
	        		$this.css({
	                    position: 'static',
	                    top: 0
	                });
	        	} else if ($window.scrollTop() == 0 ) { 
	                $this.css({
	                    position: 'absolute',
	                    top: $startPos
	                });
	            } else if ($window.scrollTop() < $startPos - 100 ) {
	            	$this.css({
	                    position: 'absolute',
	                    top: $startPos
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
	    	sidebarMarginBottom = $('.post-sidebar').css('margin-bottom');
	        bumperPos = $bumper.offset().top;
	        thisHeight = $this.outerHeight();
	        setPosition();
	    });
	    $window.scroll(setPosition);
	    setPosition();
	};

	var sidebarMarginBottom = $('.post-sidebar').css('margin-bottom');
	function stickySidebar() {
		if(sidebarMarginBottom == '0px') {
			$('.post-sidebar').followTo('.entry-header', '.entry-footer');
		}
	}

	if ( $('.post-sidebar').height() < $('.post-content').height() ) {
		stickySidebar();
	} else {
		$('.post-sidebar').css('position', 'relative');
	}

	window.addEventListener('resize', function(event){
	  sidebarMarginBottom = $('.post-sidebar').css('margin-bottom');
	  stickySidebar();
	});

	// Smooth Scrolling
	$('a[href*="#"]:not([href="#"])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html, body').animate({
					scrollTop: target.offset().top - 100
				}, 1500);
				return false;
			}
		}
	});

} )( jQuery );