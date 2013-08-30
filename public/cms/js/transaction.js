$(document).ready(function(){
    var form = $('form[name=modify]');
    $('input[type=submit]', form).attr('disabled', 'disabled');
	$('a', form).css('display', 'none');
	var warehouse_target = 0;
	var warehouse_income = 0;
	
	var target_value = $('select[name=target_warehouse_id]', form);
	var income_value = $('select[name=income_warehouse_id]', form);
	
	target_value.change(function(){
		warehouse_target = 0;
		//Выбрали склад прихода
		disableIncome(this.value);
		if( !this.value || this.value == 0)// Выбрали нет
		{
			if( income_value.val() && income_value.val() != 0)
			{
				enableOutput();
				warehouse_income = income_value.val();
				$('a', form).css('display', 'block');
			}
			else
			{
				//Закрыть все нахрен
				enableAll();
				$('a', form).css('display', 'none');
			}
		}
		else
		{
			warehouse_target = target_value.val();
			if( income_value.val() && (income_value.val() != 0) )
			{
				//Выбрали прихода при выбранном расхода
				warehouse_income = income_value.val();
				enableBetween();
				$('a', form).css('display', 'block');
			}
			else
			{
				if(this.options[this.selectedIndex].title == 'prim')
				{
					enableArrival();
					$('a', form).css('display', 'block');
					//Выбрали первичный.
				}
				else
				{
					enableAll();
					$('a', form).css('display', 'none');
					;//Закрыть все нахрен
				}
			}
		}
	})
	
	income_value.change(function(){
		warehouse_income = 0;
		//Выбрали склад расхода
		disableTarget(this.value);
		var income_js = income_value.get(0);
		if( this.value == 0 ) // склад расхода пустой
		{
			var target_js = target_value.get(0);
			if( target_js.options[target_js.selectedIndex].title == 'prim' )
			{
				warehouse_income = income_value.val();
				enableArrival();
				$('a', form).css('display', 'block');
				//Выбрали первичный.
			}
			else
			{
				// Закрыть все нахрен.
				enableAll();
				$('a', form).css('display', 'none');
			}
		}
		else if( income_js.options[income_js.selectedIndex].title == 'end' )
		{
			enableOutput();				
			warehouse_target = 0;
			warehouse_income = income_value.val();
			target_value.val('null');
			disableAllTarget();
			$('a', form).css('display', 'block');
		}
		else
		{
			if( target_value.val() != 0 )
			{
				warehouse_target = target_value.val();
				//Склад прихода выбран
				enableBetween();
				warehouse_income = income_value.val();
				$('a', form).css('display', 'block');
			}
			else
			{
				//Склад прихода не выбран
				//enableOutput();
				warehouse_income = income_value.val();
				//$('a', form).css('display', 'block');
			}
		}
	})
	
	$('a', form).click(function(){
		var newWin = window.open('/admin/fm/add_film_trans/popup/1/pid/'+  warehouse_income + '_' + warehouse_target, 'Something', "width=586,height=430,left=200,top=200,resizable=no,scrollbars=no,status=no");
	})
});

var addFm = function (id, qnty, title) {
    var form = $('form[name=modify]');
    $('#fm_descr').css('margin-left', '0px');
    $('#fm_descr').css({display: 'block', width: '40%'});
    $('input[type=submit]', form).removeAttr('disabled');
	var temp = 'selected_films[' + id + ']';
	var target_js = $('select[name=target_warehouse_id]').get(0);
    if ($('select[name=income_warehouse_id]').val() == 0)
	{
		$('select[name=income_warehouse_id]').val(0);
	}
    $('select[name=income_warehouse_id]').attr('disabled', 'disabled');
    if ($('select[name=target_warehouse_id]').val() == 0)
	{
		$('select[name=target_warehouse_id]').val(0);
	}
	if( target_js.options[target_js.selectedIndex].title == 'prim' )
	{
		$('select[name=target_warehouse_id]').attr('disabled', 'disabled');
	}
    $('select[name=income_warehouse_id]').attr('disabled', 'disabled');
    if( !$('input[name=income_warehouse_id]').val() )
	{
		$('#fm').append('<input type="text" name="income_warehouse_id" value="' + $('select[name=income_warehouse_id]').val() + '" />');
	}
	if( !$('input[name=target_warehouse_id]').val())
	{
		$('#fm').append('<input type="text" name="target_warehouse_id" value="' + $('select[name=target_warehouse_id]').val() + '" />');
	}
	if( $('input[name=' + temp + ']',form).val() )
	{
		var value = $('input[name=' + temp + ']',form).val()*1;
		value += qnty*1;
		$('input[name=' + temp + ']',form).val(value);
		$('#qnty_' + id + '' ,form).text( $('#qnty_' + id + '' ,form).text()*1 + qnty*1 );
	}
	else
	{
		$('#fm').append('<input type="text" name="selected_films[' + id + ']" value="' + qnty + '" />');
		$('#fm_descr').append('<tr class="m-item-center"><td><span>' + title + '</span></td><td><span id="qnty_' + id + '">' + qnty + '</span></td></tr>');
	}
};

var addMore = function (id, qnty) {
};

var enableAll = function () {
	$('option',$('select[name=transaction_type]')).removeAttr('disabled');
};

var disableTarget = function (value) {
	if (!value)
	{
		$('option',$('select[name=target_warehouse_id]')).removeAttr('disabled');
		return;
	}
	$('option',$('select[name=target_warehouse_id]')).removeAttr('disabled');
	$('option[value=' + value + ']',$('select[name=target_warehouse_id]')).attr('disabled', 'disabled');
};

var disableIncome = function (value) {
	if (!value) 
	{
		$('option',$('select[name=income_warehouse_id]')).removeAttr('disabled');
		return;
	}
	$('option',$('select[name=income_warehouse_id]')).removeAttr('disabled');
	$('option[value=' + value + ']',$('select[name=income_warehouse_id]')).attr('disabled', 'disabled');
};

var disableAllTarget = function () {
	$('option',$('select[name=target_warehouse_id]')).attr('disabled', 'disabled');
    $('option[value=0]',$('select[name=target_warehouse_id]')).removeAttr('disabled');
    $('option[value=0]',$('select[name=target_warehouse_id]')).attr('selected', 'selected');
};

var enableBetween = function () {
	$('option',$('select[name=transaction_type]')).removeAttr('disabled');
	$('option[value=arrival]',$('select[name=transaction_type]')).attr('disabled', 'disabled');
	$('option[value=sale]',$('select[name=transaction_type]')).attr('disabled', 'disabled');
	$('option[value=debit]',$('select[name=transaction_type]')).attr('disabled', 'disabled');
	$('option[value=between]',$('select[name=transaction_type]')).attr('selected', 'selected');
};

var enableArrival = function () {
	$('option',$('select[name=transaction_type]')).removeAttr('disabled');
	$('option[value=between]',$('select[name=transaction_type]')).attr('disabled', 'disabled');
	$('option[value=sale]',$('select[name=transaction_type]')).attr('disabled', 'disabled');
	$('option[value=debit]',$('select[name=transaction_type]')).attr('disabled', 'disabled');
	$('option[value=arrival]',$('select[name=transaction_type]')).attr('selected', 'selected');
};

var enableOutput = function () {
	$('option',$('select[name=transaction_type]')).removeAttr('disabled');
	$('option[value=between]',$('select[name=transaction_type]')).attr('disabled', 'disabled');
	$('option[value=arrival]',$('select[name=transaction_type]')).attr('disabled', 'disabled');
	$('option[value=sale]',$('select[name=transaction_type]')).attr('selected', 'selected');
};