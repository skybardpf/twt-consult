$(document).ready(function(){
    var form = $('form[name=geographer]');
    $('select', form).change(function(){
        var valu  = $(this).val();
        var level = $(this).attr('id');
        
        if( level.indexOf('adds') == -1 ){ var add = 'm';}else{var add = 'a'}
        if(valu != ''){ var va = valu;}else{var va = '0'}
        $('input[name=changed]', form).attr('value', (add + '_' + level + '_' + va));
        
        this.form.submit();
    })
    
});