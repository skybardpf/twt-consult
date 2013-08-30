var last = null;

$(document).ready(function(){
	$('.zf_plus_file').live('click', function(){
		var $this = $(this);
		if (typeof($this[0].outerHTML) != "undefined") {
			var $input = $($this.prev()[0].outerHTML);
		} else {
			var $input = $this.prev().clone().val('');
		}
		$('<br/>').insertAfter($(this));
		$input.insertAfter($(this).next());
	});
});