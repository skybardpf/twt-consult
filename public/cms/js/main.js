$(document).ready(function(){
	$('input[type="radio"]').each(function(){
		this.style.width = 'auto';
	});
	
	$('input[type="checkbox"]').each(function(){
		this.style.width = 'auto';
	});
    
    $('table.listTable tr td').bind('mouseover mouseout', function () {
        $(this).parent().toggleClass('active');
    });
    
    $('div.input input').add('div.input textarea').each(function () {
        if ($(this).css('display') == 'none') return;
        $(this).parent().css('padding-right', '6px');
    });
    
    $('table#mainTable').css('visibility', 'visible');
    
    
    $('span.sort_btn').click(function() {
    	$(this.nextElementSibling).toggle();
		return false;
	});
    
    var stop = false;
	var timeOutSort = null;
	var xhr = null;
	$(':input.sort_field').keypress(function(e) {
		var key = (typeof e.charCode == 'undefined' ? e.keyCode : e.charCode);
		// Ignore special keys
		if (e.keyCode != 8 && (e.ctrlKey || e.altKey || key < 32)) {
			stop = true;
			return true;
		}
		key = String.fromCharCode(key);
		stop = true;
		return /./.test(key);
	}).bind('keyup change', function(e) {
		if (timeOutSort != null){
			clearTimeout(timeOutSort);
			timeOutSort = null;
		}
		timeOutSort = setTimeout(function () {
			if (xhr && xhr.readyState != 4) {
				xhr.abort();
				xhr = null;
			}
			if (stop || e.type == 'change') {
				var href = window.location.href.split('!', 1);
                href[0] = rtrim(href[0], '/');
				xhr = $.post(href[0]+'/ajax/1/', $(':input.sort_field').serialize(), function(data) {
					$('table.listTable tbody.data').html($('table.listTable tbody.data', '<div>'+data+'</div>').html());
					$('div.page-listing, div.paging, div.pagging').html($('div.page-listing, div.paging, div.pagging', '<div>'+data+'</div>').html());
					var arrows_old = $('span.sort_arrows, div.sort_arrows');
					var arrows_new = $('span.sort_arrows, div.sort_arrows', '<div>'+data+'</div>');
					if (arrows_old.length && arrows_new.length) {
						for (var i = 0; i < arrows_old.length; i++) {
							arrows_old[i].innerHTML = arrows_new[i].innerHTML;
						}
					}
				});
			}
		}, 500);
	});

    $("#btnFullScreeniscontent").mouseup(function(){
        $("#top-menu table td").each(function(){
            if($(this).css('z-index') == 1){
                $(this).css({'z-index': 0})
            }
            else {
                $(this).css({'z-index': 1})
            }
        });
    });
});
function rtrim ( str, charlist ) {    // Strip whitespace (or other characters) from the end of a string
    // 
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Erkekjetter
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

    charlist = !charlist ? ' \s\xA0' : charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
    var re = new RegExp('[' + charlist + ']+$', 'g');
    return str.replace(re, '');
}

/*if ('v' == "\v") {
    $(window).load(function () {
        $('body').css('visibility', 'block');
    });
}*/