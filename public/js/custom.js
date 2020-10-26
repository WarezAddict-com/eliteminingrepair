$(document).ready(function () {

    /** Hide Preloader **/
    $.LoadingOverlay('hide');

    /** Change Body Class **/
    $('body').removeClass('loading').addClass('loaded');

    /** Default Easing **/
    $.easing.def = 'easeInOutExpo';

    /** Disable # Links **/
    $('a[href="#"]').on('click', function(e) {
        e.preventDefault();
    });

    /** Animate On Scroll **/
    AOS.init({
        once: true,
        mirror: false,
        easing: 'easeInOutExpo',
        duration: 1500,
        delay: 0,
        debounceDelay: 50,
        throttleDelay: 99,
    });

    /** Navbar Active Class Toggle **/
    $('.nav-item').on('click', 'a.nav-link', function() {
        $('a.nav-link').removeClass('active');
        $(this).toggleClass('active');
    });

    /** Smooth Scroll Back To Top **/
    $('#scroll').on('click', function() {
        $('html, body').stop().animate({
            scrollTop : 0
            }, 500, 'easeInOutExpo'
        );
        return false;
    });

    /** AJAX Config **/
    $(document).ajaxStart(function() {
        /** Show Loading Spinner **/
        $.LoadingOverlay('show');
    });
    $(document).ajaxComplete(function() {
        /** Hide Loading Spinner **/
        $.LoadingOverlay('hide');
    });
    $(document).ajaxError(function(event, request, settings) {
        /** Hide Loading Spinner, Show Error In Console **/
        $.LoadingOverlay('hide');
        console.log('AJAX ERROR!')
        console.log(event);
        console.log(request);
        console.log(settings);
    });

    $('#slick').slick({
        autoplay: true,
        autoplaySpeed: 2000,
        dots: false,
        infinite: true,
        accessibility: true,
        arrows: false,
        draggable: true,
        swipe: true,
        touchMove: true,
        useCSS: true,
        useTransform: true,
        slidesToShow: 3,
        slidesToScroll: 3
    });

});

// Navbar Switch On Scroll
$(window).on('scroll', function () {
    if ($(window).scrollTop() <= 75) {
        $('#topNav').removeClass('nav-switch');
    } else {
        $('#topNav').addClass('nav-switch');
    }
});
