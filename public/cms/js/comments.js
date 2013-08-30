$(document).ready(function(){
    $('#show_comments').click(function(){
        $.post('/admin/paper/show_comments/', {'paper_id':($(this).attr('paper_id'))}, function(data){$('#comments_div').html(data);});
        return false;
    });
    $('form').live('submit', function(){
        $.post('/admin/paper/add_comment/', $(this).serialize(), function(data){
            $('#comments_add').html(data);
        });
        //add_question_form
        return false;
    });
    $('.change_comment').live('click',function(){
        $('form input:[name=etype]').val($(this).attr('type'));
        $('form input:[name=eid]').val($(this).attr('comm_id'));
        $('#comments_add').show();
        return false;
    });
});
