startTime = new Date().getTime();
var renderTime = 0;


$(document).ready(function(){
	$(document).keydown(function(e){
		if((e.ctrlKey || e.metaKey) && (e.keyCode == 192 || e.keyCode == 101)) {
			//$('#debugDiv').prependTo('body');
			if ($('#debugDiv').is(':hidden')) {
				$("#debugDiv").slideDown(500);
			} else {
				$("#debugDiv").slideUp(400);
			}
		}
		return true;
	});
	
	$('.debug_item').find('.debug_title_div').css('cursor', 'pointer');
	$('.debug_item').find('.debug_title_div').hover(
		function(){
			$(this).toggleClass('debug_title_hover');
		},
		function(){
			$(this).toggleClass('debug_title_hover');
		}
	);
	
	$('a.debug_line').cluetip({splitTitle: '|', width: 500});
	$('a.debug_line').click(function(){return false;});
	
	$('.debug_title_div').click(function(){
		if($('#'+this.id + '_body')) {
			if ($('#'+this.id + '_body').is(':hidden')) {
				//this.css('color', 'red');
				$('#'+this.id + '_body').slideDown(500);
			} else {
				$('#'+this.id + '_body').slideUp(400);
			}
		}
		return true;
	});
});

$(window).load(function(){
	renderTime = (new Date().getTime() - startTime) / 1000;	
	$('#renderTime').html(renderTime);
});

