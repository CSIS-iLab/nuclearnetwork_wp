/**
 * Adds class to header on scroll & toggles search
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

  // Toggle class on search.
  $(".header-search-form .search-label").on("click", function() {
    $(".header-search-form .search-field").toggleClass("is-hidden");
    $(".main-navigation .apply").toggleClass("is-shifted");
  });


} )( jQuery );