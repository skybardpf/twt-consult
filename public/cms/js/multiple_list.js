$(document).ready(function(){
    $('#multiple_all').change(function(){
        $('input[class=multiple]').attr('checked', $('#multiple_all').attr('checked'));
    });
    $('input[class=multiple]').change(function(){
        var checked = $(this).attr('checked');
        var all = true;
        $('input[class=multiple]').each(function(i, elem) {
            all = all && ($(elem).attr('checked') == checked);
        });
        $('#multiple_all').attr('checked', all && checked);
    });
    $('a[class=multiple]').click(function(){
        var checked = false;
        $('input[class=multiple]').each(function(i, elem) {
            checked  = checked || $(elem).attr('checked');
        });
        if (!checked) {
            alert('Выберите хоть один элемент для группового действия.');
        }
        else if (confirm($(this).attr('title')+'?')) {
            $('form[name=multiple]').attr('action', $(this).attr('href')).submit();
        }
        return false;
    });
});