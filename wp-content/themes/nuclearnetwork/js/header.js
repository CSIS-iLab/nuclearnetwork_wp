/**
 * Adds class to header on scroll & toggles search
 */

( function( $ ) {

  // Add class to header on scroll
  $(window).scroll(function(){
    var currentScroll = $(this).scrollTop();
    console.log("scroll");
      
    if(currentScroll > 0){
      $(".site-header .header-logo").removeClass("col-md-4").removeClass("is-large").addClass("is-minimal");
      $(".site-header .header-content-container").removeClass("col-md-8").addClass("is-minimal");
      $(".site-content").addClass("is-minimal");
      
      

    }
    else {
      $(".site-header .header-logo").addClass("col-md-4").removeClass("is-minimal").addClass("is-large");
      $(".site-header .header-content-container").addClass("col-md-8").removeClass("is-minimal");
      $(".site-content").removeClass("is-minimal");

    }
  });

  // Toggle class on search.
  $(".header-search-form .search-label").on("click", function() {
    var parent = $(this).parents(".header-search-form");
    $(parent).children(".search-field").toggleClass("is-hidden").focus();
    $(parent).toggleClass("is-active");
    $(".main-navigation .apply").toggleClass("is-shifted");
    $("body").toggleClass("toggled");
  });

  $(".menu-toggle").on("click", function() {
    if($(".header-search-form").hasClass("is-active")) {
      $(".header-search-form").removeClass("is-active");
      $(".header-search-form .search-field").addClass("is-hidden");
      $(".main-navigation .apply").removeClass("is-shifted");
    }
  });


} )( jQuery );