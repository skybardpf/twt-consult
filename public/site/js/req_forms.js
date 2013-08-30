$(document).ready(function () {
    //Форма заявки на счет
    var bank_cur = new Object;
    var bank_id = 'account_req_bank_id';
    var currency_id = 'account_req_currency_id';
    var banks = $("select[id*='account_req_bank_id']");
    var account_number = 1;
    for (var key=0; key < banks.length; key++){
        account_number+=1;
    }

    $('#bank_currency').live('click', function(){
        account_number += 1;
        $('#'+bank_id).attr({'name': 'bank_id[]'});
        $('#'+currency_id).attr({'name': 'currency_id[]'});
        $($("#currency_id").add($(this).prev()).add($(this)).clone(true).insertAfter($(this)));
        $("<input type=\"button\" class=\"delinput\" value=\"-\"/>").insertAfter($(this));
        $(this).next().next().next().attr('value', '');
        $(this).remove();
        $("select[name*='bank_id']:last").attr({'id': bank_id+'_'+account_number, 'number': account_number});
        $("select[name*='bank_id']:last option").attr({'selected': ''});
        $("select[name*='currency_id']:last").attr({'id': currency_id+'_'+account_number, 'number': account_number, 'disabled': 'disabled', 'class': 'filter_disabled std'});
        $("select[name*='currency_id']:last option").attr({'selected': ''});
        $("select[name*='currency_id']:last").parent().find('div').hide();
        //$('select[name*=bank_id]:last').attr({'id': bank_id+'_'+account_number, 'number': account_number});
        //$('select[name*=currency_id]:last').attr({'id': currency_id+'_'+account_number, 'number': account_number, 'disabled': 'disabled', 'class': 'filter_disabled std'});
        return false;
    });
    $('.delinput').live('click', function(){
        $(this).add($(this).next()).remove();
    });

    if($('#'+currency_id+' option').size() > 1 && $()) {
        $('#'+currency_id).removeAttr('disabled');
        $('#'+currency_id).attr({'class': 'std'});
    } else {
        $('#'+currency_id).attr({'disabled': 'disabled', 'class': 'filter_disabled std'});
    }

    $("select[id*='account_req_bank_id']").live('change', function(){
        var url = root_url + 'bank_change/ajax/1';
        var id = this.id;
        var number = $('#'+id).attr("number");
        number = (number) ? '_'+number : '';
        var bank = $('#'+id);
        var currency = $('#'+currency_id+number);
        var curr_id = '#'+currency_id+number;
        $.ajax({
            type: "POST",
            url: url,
            data: {
                bank_id: bank.val()
            },
            success: function(data){
                var d = JSON.parse(data);
                var values = d['values'];
                bank_cur[bank.val()] = d['price'];
                if (values['currencies'] && values['currencies'].length == 0) {
                    var html = '<option selected="selected" value="">Не выбран</option>';
                    currency.html(html);
                } else {
                    var html = '<option selected="selected" value="">Не выбран</option>', selected = '';
                    var currency_val = values['currencies'];
                    for (var key in currency_val){
                        selected = currency_val[key].selected ? ' selected' : '';
                        html += '<option value="' + key + '"' + selected + '>' + currency_val[key] + '</option>';
                    }
                    currency.html(html);
                }
                
                /*if (currency.val()) {
                    currency.attr({'disabled': 'disabled', 'class': 'filter_disabled std'});
                }*/
                if($(curr_id+' option').size() > 1) {
                    currency.attr({'class': 'std'});
                    currency.removeAttr('disabled');
                } else {
                    currency.attr({'disabled': 'disabled', 'class': 'filter_disabled std'});
                }
            }
        });
        return false;
    });

    $("select[id*='account_req_currency_id']").live('change', function(){
        if ($(this).val()) {
            $(this).parent().find('div').show();
            var bank_id = $(this).parent().parent().parent().find('select[id*="account_req_bank_id"]').val();
            //_alert(bank_id);
            $(this).parent().find('div #cur').html(bank_cur[bank_id]);
            console.log(bank_cur);
        } else {
            $(this).parent().find('div').hide();
        }
    });

    //Форма заявки на транспортировку

    var loading_city = 'transport_req_loading_city';
    var loading_index = 'transport_req_loading_index';
    var loading_number = 0;
    var loading_cities = $("input[id*='transport_req_loading_city']");
    for (var key=0; key < loading_cities.length; key++){
        loading_number+=1;
    }

    $('#loading').live('click', function(){
        loading_number += 1;
        $('#'+loading_city).attr({'name': 'loading_city[]'});
        $('#'+loading_index).attr({'name': 'loading_index[]'});
        $($("#loading_index").add($(this).prev()).add($(this)).clone(true).insertAfter($(this)));
        $("<input type=\"button\" class=\"delinputload\" value=\"-\"/>").insertAfter($(this));
        $(this).next().next().next().attr('value', '');
        $(this).remove();
        $("input[name*='loading_city']:last").attr({'id': loading_city+'_'+loading_number, 'number': loading_number, 'name': 'loading_city['+loading_number+']'});
        $("input[name*='loading_city']:last").val('');
        $("input[name*='loading_index']:last").attr({'id': loading_index+'_'+loading_number, 'number': loading_number, 'name': 'loading_index['+loading_number+']'});
        $("input[name*='loading_index']:last").val('');
        return false;
    });
    $('.delinputload').live('click', function(){
        $(this).add($(this).next()).remove();
    });

    var delivery_city = 'transport_req_delivery_city';
    var delivery_index = 'transport_req_delivery_index';
    var delivery_number = 0;
    var delivery_cities = $("input[id*='transport_req_delivery_city']");
    for (var key=0; key < delivery_cities.length; key++){
        delivery_number+=1;
    }

    $('#delivery').live('click', function(){
        delivery_number += 1;
        $('#'+delivery_city).attr({'name': 'delivery_city[]'});
        $('#'+delivery_index).attr({'name': 'delivery_index[]'});
        $($("#delivery_index").add($(this).prev()).add($(this)).clone(true).insertAfter($(this)));
        $("<input type=\"button\" class=\"delinputdelivery\" value=\"-\"/>").insertAfter($(this));
        $(this).next().next().next().attr('value', '');
        $(this).remove();
        $("input[name*='delivery_city']:last").attr({'id': delivery_city+'_'+delivery_number, 'number': delivery_number, 'name': 'delivery_city['+delivery_number+']'});
        $("input[name*='delivery_city']:last").val('');
        $("input[name*='delivery_index']:last").attr({'id': delivery_index+'_'+delivery_number, 'number': delivery_number, 'name': 'delivery_index['+delivery_number+']'});
        $("input[name*='delivery_index']:last").val('');
        return false;
    });
    $('.delinputdelivery').live('click', function(){
        $(this).add($(this).next()).remove();
    });
    $('input[name=entity_form]').click(function(){
        $('#kind_activities_added option, #country_source_added option, #country_receiver_added option').attr({'selected': 'selected'}) ;
        $('#kind_activities_original option, #country_source_original option, #country_receiver_original option').attr({'selected': ''}) ;
    });
});

function Add_v(id1, id2) {
    var selected_or = $('#' + id1 + ' :selected');
    var select_added = $('#' + id2);
    var select_added_opt= $('#' + id2 + ' option');
    var selected = selected_or.clone();
    if (select_added_opt.size()) {
        var arr = {};
        select_added_opt.each(function(key, value){
            arr[value.text] = value.text;
        });
        selected.each(function(){
            if (this.text != arr[this.text]) {
                select_added.append(this);
            }
        });
    } else {
        if (selected.size()) {
            select_added.append(selected);
        } 
    }
    $('#' + id2 + ' option').each(function(){
        $(this).attr({'selected': 'selected'});
    });
    return false;
}

function Add_d(id1) {
    $('#' + id1 + ' :selected').remove();
    return false;
}

function Add_dAll(id1) {
    $('#' + id1).empty();
    return false;
}
