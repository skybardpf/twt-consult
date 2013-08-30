$(document).ready(function(){
    $('#sel_all').click(function(){
		var link_end = '?';
		$('input[type=checkbox]').each(function(index){
			$(this).attr('checked', 'true');
		});
	});
    $('#sel_none').click(function(){
		$('input[type=checkbox]').removeAttr('checked');
	});
    $('#delete_many_link').click(function(){
		var link_end = '?';
		$('input[type=checkbox]').each(function(index){
			if( $(this).attr('checked') == true)
			{
				link_end = link_end + 'id[' + $(this).attr('name') + ']=1&';
			}
		});
	   document.location.href = "/admin/estate/delete_many/type/" + $(this).attr('name') + '/' + link_end;
	});
});