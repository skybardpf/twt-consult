$(document).ready(function () {
	if($.cookie('left_is_hidden') == 'true') {
		$('#leftPanel').attr('className', 'left-close');
		$('#closeDiv').attr('className', 'action-open');
	}
	else {
		$('#leftPanel').attr('className', 'left-open');
		$('#closeDiv').attr('className', 'action-close');
	}

	$('#closeDiv').click(function () {
		if($.cookie('left_is_hidden') == 'true') {
			$('#leftPanel').attr('className', 'left-open');
			$('#closeDiv').attr('className', 'action-close');
			$.cookie('left_is_hidden', 'false', {path: '/'});
		}
		else {
			$('#leftPanel').attr('className', 'left-close');
			$('#closeDiv').attr('className', 'action-open');
			$.cookie('left_is_hidden', 'true', {path: '/'});
		}
	});
});