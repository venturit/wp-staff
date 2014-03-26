$(document).ready(function () {
	$(".vt-toggle-title").click(function(){
		$(this).siblings('.vt-toggle-pane').toggle(
			function () {
				$(this).addClass('active-toggle');
				$(this).siblings('.vt-toggle-pane').slideDown(200);
			}, function () {
				$(this).removeClass('active-toggle');
				$(this).siblings('.vt-toggle-pane').slideUp(200);
			});
	});
});