/**
 * Mobile Navigation
 * Toggles the mobile menu and the search bar
 */

( function( $ ) {

  // Add class to header on scroll
  $(window).scroll(function(){
    var currentScroll = $(this).scrollTop();

      
    if(currentScroll > 0){
      $(".site-header .header-logo").removeClass("col-md-4").addClass("is-minimal");
      $(".site-header .header-content-container").removeClass("col-md-8").addClass("is-minimal");
    }
    else {
      $(".site-header .header-logo").addClass("col-md-4").removeClass("is-minimal");
      $(".site-header .header-content-container").addClass("col-md-8").removeClass("is-minimal");
    }
    
  });


  window.addEventListener('resize', function(event){
    width = $(window).width();
  });

} )( jQuery );