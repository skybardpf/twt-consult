$(function() {
	$('.addinput').live(
			'click',
			function() {
				$($("</br>").add($(this).prev()).add($(this)).clone(true).insertAfter($(this)));
				$("<input type=\"button\" class=\"delinput\" value=\"-\"/>").insertAfter($(this));
				$(this).next().next().next().attr('value', '');
			});
	$('.delinput').live('click', function(){
		$(this).add($(this).prev()).add($(this).prev().prev()).add($(this).next()).remove();
	});
});