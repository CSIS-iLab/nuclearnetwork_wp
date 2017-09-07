/**
 * JavaScript for Posts
 */

( function( $ ) {

  // Toggle class on search.
  $(".sources-label").on("click", function() {
    $(this).toggleClass("is-active");
    $(".entry-content .sources").toggleClass("is-active");
  });

} )( jQuery );