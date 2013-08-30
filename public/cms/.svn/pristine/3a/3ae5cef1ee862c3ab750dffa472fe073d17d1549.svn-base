$(document).ready(function() {
	var divs = $('#categories input[type=checkbox]');
	for ( var i = 0; i < divs.length; i++) {
		var checkbox = divs[i];
		$(checkbox).click(function() {
			if (this.checked) $('div', $(this).parent()).show(500);
			else $('div', $(this).parent()).hide(500);
		});
	}
});