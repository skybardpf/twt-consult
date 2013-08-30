var captchasuffix = Math.floor(Math.random()*5);

$(document).ready(function(){
    $('.zf_image').each(function() {
    	var field = $(this).next().get(0).name;
        var append = window.location.pathname.charAt(window.location.pathname.length - 1) == '/' ? 'field/' : '/field/';
        if ($(this).attr('rel') != 'no_delete') {
            $(this).append(' &nbsp; &nbsp; <a href="' + window.location.pathname.replace('modify', 'delete_image') + append + field + '/">удалить</a>');
        }
        if (window.cropper) {
            $(this).find('a').attr('link', window.location.pathname.replace('modify', 'crop_image'));
            $(this).find('a').click(function (){
                return window.cropper.show_crop_dialogue(this);
            });
        }        
	});
    
    $(':input[type=checkbox].all_checker').click(function () {
        var name = this.id.split('_all')[0] + '[]';
        $(':input[name=' + name + ']').attr('checked', this.checked);
    });
    
    $('img[src*="/captcha/"]').captcharefresh();
    $('img[data-original*="/captcha/"]').captcharefresh();
    
});

jQuery.fn.captcharefresh = function(refresh)
{
    var jThis = jQuery(this);
    var src = jThis.attr("src");
	if (typeof refresh !='undefined') {
        //if (jThis.attr('src').indexOf("captcha") == -1) return;
        if (jThis.attr("data-original")) {
            jThis.attr("src", jThis.attr("data-original"));
        } else {
            jThis.attr("data-original", jThis.attr("src"));
        }
		jThis.attr('src', jThis.attr('src') + (jThis.attr('src').indexOf("?") == -1 ? ("?" + captchasuffix++) : captchasuffix++));
		return;
	}
	jThis.unbind('click');
    jThis.unbind('load');
    jThis.attr('src', jThis.attr('src') + (jThis.attr('src') && jThis.attr('src').indexOf("?") == -1 ? ("?" + captchasuffix++) : captchasuffix++) )
    jThis.bind('load', function() {
		jThis.next().hide();
		jThis.bind('click', function(){
			jThis.next().show();
			jThis.captcharefresh();
		});
	});
};