$(document).ready(function () {

    $('a.price_open').live('click', function(){
            $(this).parents('li').find('.slide_up_down').slideToggle();
            return false;
        }
    );

});