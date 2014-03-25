
$(document).ready(function() {
	w1 = $("#left-content").height();
	w2 = $("#right-content").height();
	w3 = $(window).width();
	if (w3 > 767) {
		if (w2 > w1) {
			$("#left-content").removeClass("left-content");
			$("#right-content").addClass("right-content");
		} else {
			$("#right-content").removeClass("right-content");
			$("#left-content").addClass("left-content");
		}
	}
});

$(window).resize(function() {
	w1 = $("#left-content").height();
	w2 = $("#right-content").height();
	w3 = $(window).width();
	if (w3 > 767) {
		if (w2 > w1) {
			$("#left-content").removeClass("left-content");
			$("#right-content").addClass("right-content");
		} else {
			$("#right-content").removeClass("right-content");
			$("#left-content").addClass("left-content");
		}
	} else {
		$("#left-content").removeClass("left-content");
		$("#right-content").removeClass("right-content");
	}
});
