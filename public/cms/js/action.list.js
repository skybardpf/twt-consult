$(document).ready(function() {
	$('table.listTable').append('<tr id="clone" style="display: none"><td></td></td>');
	$('table.listTable tr[id]').bind('drag', function(event) {
		$('#clone').html($(event.dragProxy).clone().html())
		.css({
			display: 'block',
        	position: 'absolute',
        	left: event.offsetX, 
            top: event.offsetY
        });
		$(event.dragTarget).css('border-color', 'red');
	}).bind("dragend", function(event){
    	$('#clone').css({position: 'static', display: 'none'});
	});
	
	$('table.listTable tr[id]').bind( 'drop', function( event ) {
		var src = $("script[src*=action.list.js]:first").attr('src');
		var src = src.split('?');
		var item = '';
		var root_url = '';
		var ctrlName = '';
		var rawGet = src[1].split('&');
		for ( var i = 0; i < rawGet.length; i++) {
			var get = rawGet[i].split('=');
			switch (get[0]) {
			case 'item':
				item = get[1];
				break;
			case 'root_url':
				root_url = get[1];
				break;
			case 'ctrlName':
				ctrlName = get[1];
				break;
			}
		}
		var id1 = event.dragTarget.id.replace('row_', '');
		var id2 = event.dropTarget.id.replace('row_', '');
		$.get(root_url+ctrlName+'/swap_'+item+'/id/'+id1+'/iid/'+id2+'/', function() {
			var dropTargetHTML = $(event.dropTarget).html();
			var dragTargetHTML = $(event.dragTarget).html();
			$(event.dropTarget).html(dragTargetHTML);
			$(event.dragTarget).html(dropTargetHTML);
			alert($('td', event.dragTarget)[1].innerHTML + '<=>' + $('td', event.dropTarget)[1].innerHTML);
		});
	});
});