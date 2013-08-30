<div class="service_cont calc">
<h2 id="alculator_anchor">Страховой калькулятор</h2>
	<div class="calc_outer">
	<div class="calc_bc"><a href="/calc/step1">Шаг 1</a> - <span>Шаг 2</span></div>
	<div class="calc_bc"><span>Выберите страховую компанию, на которую вы хотели бы оформить договор<span style="color: #f00;"> *</span>:</span></div>
	{if $settings.calculator_text}<div class="calc_bc"><span>{$settings.calculator_text}</span></div>{/if}
<div class="form">
    {if $errors_calculator}
        <div> <span class="error">{$errors_calculator}</span></div>
    {/if}
    <form name='calculator_req' id='calculator_req_form' action="/calc/step2" method="post">
	    <input type="hidden" name="step2" value="1">
        <input type="hidden" id="order_number" name="order_number" value="{if $insurance.NumberOfPreOrder}{$insurance.NumberOfPreOrder}{else}0{/if}">
        <input type="hidden" id="order_date" name="order_date" value="{if $insurance.DateOfPreOrder}{$insurance.DateOfPreOrder}{else}{/if}">
        {foreach from=$insurance.variants item=var}
            <input type="hidden" id="order_number{$var.number}" name="variants[{$var.number}][company]" value="{$var.company}">
            <input type="hidden" id="order_number{$var.number}" name="variants[{$var.number}][company_title]" value="{$var.company_title}">
            <input type="hidden" id="order_number{$var.number}" name="variants[{$var.number}][ins_type]" value="{$var.ins_type}">
            <input type="hidden" id="order_number{$var.number}" name="variants[{$var.number}][cost]" value="{$var.cost}">
            <input type="hidden" id="order_number{$var.number}" name="variants[{$var.number}][franchise]" value="{$var.franchise}">
            <input type="hidden" id="order_number{$var.number}" name="variants[{$var.number}][guard]" value="{$var.guard}">
            <input type="hidden" id="order_number{$var.number}" name="variants[{$var.number}][currency]" value="{$var.currency}">
            <input type="hidden" id="order_number{$var.number}" name="variants[{$var.number}][number]" value="{$var.number}">
        {/foreach}

    <div style="margin-bottom: 15px;">
        <table class="striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Компания</th>
                    <th>Вид страхования</th>
                    <th>Тариф</th>
                    <th>Франшиза</th>
                    <th>Требуется ли охрана?</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$insurance.variants item=var}
                    {assign var=cur value=$var.currency}
                    <tr>
                        <td><input type="radio" id="variant"{if $var.selected} checked="" {/if} name="variant" value="{$var.number}"></td>
                        <td>{$var.company_title}</td>
                        <td>{$var.ins_type}</td>
                        <td width="13%">{$var.cost|number_format:'0':'':''}{if $var.currency && $currencies.$cur} {$currencies.$cur}{/if}</td>
                        <td>{$var.franchise|number_format:'0':'':''}{if $var.currency && $currencies.$cur} {$currencies.$cur}{/if}</td>
                        <td>{if $var.guard == "true"}Да{else}Нет{/if}</td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
		<div class="add_buttons" style="margin-top: 15px;">
			<a class="pull-left back_link" href="/calc/step1">Вернуться назад</a>
			<input type="submit" name='calculator_form' class="order_button orange_button checkauth pull-right" value="Продолжить оформление">
		</div>
		<div style="clear: both;"></div><br>
    <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
    </form>
</div>
		</div>
	</div>