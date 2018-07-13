function scrollFunc() {
	var scrollTop = $(window).scrollTop();
	var topheight = $(".top_links").outerHeight()
	if (scrollTop >= topheight) {
		$(".header_outer").css("top","0px")
	} else {
		$(".header_outer").css("top",(topheight-scrollTop)+"px")
	}
	
	$(".animatein").each(function() {
		var winHeight = $(window).height()
		var winHeightOffset = $(window).height() / 4
		var offset = Math.min($(this).outerHeight() * 0.75, 200, winHeightOffset )
		var top = $(this).offset().top - winHeight + offset
		
		if (scrollTop > top) {
			if ($(this).hasClass("right")) {
				$(this).animate({
					opacity: 1,
					right: 0
				})
			} else {
				$(this).animate({
					opacity: 1,
					left: 0
				})
			}
		}
	})
}
scrollFunc()
$(window).scroll(scrollFunc)
$(window).resize(scrollFunc)

// Image dimensions
$("[constrain]").one("load", function() {
	var parent = $(this).parent()
	var height = parent.outerHeight() - $(this).height();
	var width = parent.outerWidth() - $(this).width();

	if (height > width) {
		$(this).css("max-height", "100%")
		$(this).css("max-width", "none")
	} else {
		$(this).css("max-width", "100%")
		$(this).css("max-height", "none")
	}
}).each(function() {
	if(this.complete) $(this).load();
});