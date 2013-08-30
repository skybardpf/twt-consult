$(function() {
	$('.infield').each(function() {
		$(this).iflabel();
	});
});
$.fn.iflabel = function() {
	var label = this;
	var input = this.next('input');
    label.bind('click', function(){
        input.focus();
    });
	input.bind('focus', function() {
		label.hide();
	});
	input.bind('blur', function() {
		if (input.val() == '') {
			label.show();
		}
	});

    setInterval(function() {
        if (input.val()) label.hide();
    }, 100);

}
