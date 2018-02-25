$(document).ready(function() {

	$("#forum-frame").on("load", function () {

		$('#forum-frame').contents().find('body').css({"min-height": "100", "overflow" : "hidden"});
		setInterval( "$('#forum-frame').height($('#forum-frame').contents().find('body').height() + 20)", 1 );

	})
});
