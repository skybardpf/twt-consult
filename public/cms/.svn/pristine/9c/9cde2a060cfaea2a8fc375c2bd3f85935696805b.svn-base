$(document).ready( function(){
    $('a.activated').each(function () {
        $(this).click(function () {
            reason = window.prompt('Укажите причину, по которой хотите деактивировать риэлтора?');
            if (reason == null) return false;
            this.href += '?comments=' + reason;
        });
    });
});
