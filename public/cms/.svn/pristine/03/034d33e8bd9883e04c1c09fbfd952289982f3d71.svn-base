var inputs = null;

$(document).ready(function () {
    var div = $('div.input');
    inputs  = $(':input[type=checkbox]', div);
    div.append('<br /><br /><a href="#" onclick="return checkPermissionsBoxes(true)">выбрать все</a> / ');
    div.append('<a href="#" onclick="return checkPermissionsBoxes(false)">снять выделение со всех</a>');
});

function checkPermissionsBoxes(check)
{
    inputs.each(function (index) {
        this.checked = check;
    });
    return false;
}