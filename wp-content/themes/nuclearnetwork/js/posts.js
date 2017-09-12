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

} )( jQuery );