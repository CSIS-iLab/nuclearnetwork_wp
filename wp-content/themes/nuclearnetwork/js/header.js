/**
 * Adds class to header on scroll & toggles search
 */

(function($) {

    // Add class to header on scroll
    $(window).scroll(function() {
        var currentScroll = $(this).scrollTop();


        var sBrowser, sUsrAg = navigator.userAgent;
        if (currentScroll > 0) {
            $(".site-header .header-logo").removeClass("is-large").addClass("is-minimal");
            $(".site-header .header-content-container").addClass("is-minimal");
            $(".site-content").addClass("is-minimal");

            if ($('#Shape-28').css('display') == "inline-block") {

                $("#Shape-28").attr('transform', 'scale(5) translate(-30 -59)');
                $("#Middle-Ring").attr('transform', 'scale(1) translate(50 -5)');
                $("#Outer-Ring").attr('transform', 'scale(1.2) translate(30 -15)');
                $("#Oval-small").attr('transform', 'scale(2.5) translate(-60 -85)');
                $("#Oval-large").attr('transform', 'scale(1.2) translate(5 5)');
                $("#Oval-2").attr('transform', 'scale(1.2) translate(-5 25)');

                $('.home .header-logo .logo-small').css('width', '40px');
            }

        } else {
            $(".site-header .header-logo").removeClass("is-minimal").addClass("is-large");
            $(".site-header .header-content-container").removeClass("is-minimal");
            $(".site-content").removeClass("is-minimal");

            if ($('#Shape-28').css('display') == "inline-block") {

                $("#Shape-28").attr('transform', 'scale(1) translate(0 0)');
                $("#Shape-28").attr('transform', 'scale(1) translate(0 0)');
                $("#Middle-Ring").attr('transform', 'scale(1) translate(0 0)');
                $("#Outer-Ring").attr('transform', 'scale(1) translate(0 0)');
                $("#Oval-small").attr('transform', 'scale(1) translate(0 0)');
                $("#Oval-large").attr('transform', 'scale(1) translate(0 0)');
                $("#Oval-2").attr('transform', 'scale(1) translate(0 0)');
            }
        }

    });

    // Toggle class on search.
    $(".header-search-form .search-label").on("click", function() {
        var parent = $(this).parents(".header-search-form");
        $(parent).children(".search-field").toggleClass("is-hidden").focus();
        $(parent).find(".search-label").toggleClass("is-hidden");
        $(parent).toggleClass("is-active");
        $(".main-navigation .apply").toggleClass("is-shifted");
        $("body").toggleClass("toggled");
    });

    $(".menu-toggle").on("click", function() {
        if ($(".header-search-form").hasClass("is-active")) {
            $(".header-search-form").removeClass("is-active");
            $(".header-search-form .search-field").addClass("is-hidden");
            $(".main-navigation .apply").removeClass("is-shifted");
        }
    });






})(jQuery);