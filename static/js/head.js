$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
		$(".navbar-fixed-top").addClass("top_bar_color");
        } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
        $(".navbar-fixed-top").removeClass("top_bar_color");
    }
});

$(function() {
    $('.Scroll_Down').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $("#introduction-1").offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});
