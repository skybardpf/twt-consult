$(document).ready(function(){
    if ($('.zf_image').length) {
        var field = $('.zf_image').next().get(0).name;
        var append = window.location.href.charAt(window.location.href.length - 1) == '/' ? 'field/' : '/field/'
        $('.zf_image').append(' &nbsp; &nbsp; <a href="' + window.location.href.replace('modify', 'delete_image') + append + field + '/">удалить</a>');
    }
});