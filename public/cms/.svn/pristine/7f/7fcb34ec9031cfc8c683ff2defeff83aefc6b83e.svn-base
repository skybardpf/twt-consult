$(document).ready(function(){
    var form = $('form[name=Add_film_form]');
	
	$('#Add_film_form_nomination', form).attr('name', 'bar_code');
	$('#Add_film_form_nomination').attr('disabled', 'disabled');
	
    $('input[type=submit]', form).attr('disabled', 'disabled');
    $('input[name=bar_code]', form).change(function(){
		$('#Add_film_form_amount', form).val('');
		this.form.submit();
    });
	
    $('select[name=bar_code]', form).change(function(){
		$('#Add_film_form_amount', form).val('');
		this.form.submit();
    });
	
	$('#nomination_search').click(function(){
		if($(this).val() == 'Искать по наименованию')
		{
			$(this).val('Искать по штрихкоду');
			$('#bar_code_search_div').css('display', 'none');
			$('#nomination_search_div').css('display', 'block');
			$('#Add_film_form_nomination').removeAttr('disabled');
		}
		else
		{
			$(this).val('Искать по наименованию');
			$('#bar_code_search_div').css('display', 'block');
			$('#nomination_search_div').css('display', 'none');
		}
	});
	
    $('input[name=amount]', form).change(function(){
		this.form.submit();
    });
	
    $('input[readonly=true]', form).addClass('readonly');
    //$('#Add_film_form_bar_code').css({height: '32px', width: '240px'});
    //$('#Add_film_form_amount').css({height: '32px', width: '240px'});
    //$('#Add_film_form_bar_code').css('font-size', '24pt');
    //$('#Add_film_form_amount').css('font-size', '24pt');
	
    //$('#Add_film_form_bar_code').focus();
	
	if($('input[name=true_bar_code]',form).val() == 'yes')
	{
		if( $('#Add_film_form_amount', form).val() != 'Слишком много' )
		{
			var temp = 'selected_films[' + $('input[name=id]', form).val() + ']';
			var vl = $('input[name=' + temp + ']',window.opener.document).val(); // Сколько уже набрали
//            if( $('#warehouse_income').text() != '' && vl)
			if( vl )
			{
				$('input[name=amount_on_warehouse]').val( $('input[name=amount_on_warehouse]').val()*1 - vl*1 );
                if( ($('input[name=amount_on_warehouse]').val()*1 < 0) )
                {
                    $('input[name=amount_on_warehouse]').val('приход в систему');
                }
			}
			var test = $('input[name=amount_on_warehouse]').val()*1; // Сколько мы можем выбрать
			var selected_amount = $('#Add_film_form_amount', form).val()*1; // Сколько мы выбрали
			if( selected_amount )
			{
				if( selected_amount <= test ) // Выбрали правильное число
				{
					$('input[type=submit]', form).removeAttr("disabled");
				}
				else
				{
					if( $('#warehouse_income').text() == '' ) // Выбрали неправильное, но так как склад расхода пуст, то можем добавить
					{
						$('input[type=submit]', form).removeAttr("disabled");
					}
				}
			}
		}
		else
		{
			$('#Add_film_form_amount', form).css('color', 'red');
		}
		//$('#Add_film_form_amount').focus();
	}
	else
	{
		$('input[readonly=true]', form).removeClass('readonly');
		$('input[readonly=true]', form).addClass('deny');
	};
	
	$('input[type=submit]', form).val('Добавить');
	
	$('input[type=submit]', form).click(function(){
		window.opener.addFm(
            $('input[name=id]', form).val(), 
            $('#Add_film_form_amount', form).val(), 
            $('#Add_film_form_title', form).val()
        );
		$('input[name=bar_code]').val('');
		$('input[name=amount]').val('');
		this.form.submit();
	});
});