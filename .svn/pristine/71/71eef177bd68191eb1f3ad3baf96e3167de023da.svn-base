<div class="service_cont calc">
	{if $forms_elements.calculator_req}
	    <h2 id="alculator_anchor">Страховой калькулятор</h2>
		<div class="calc_outer">
		<div class="calc_bc"><span>Шаг 1</span></div>
	    {if $settings.calculator_text}<div class="calc_bc"><span>{$settings.calculator_text}</span></div>{/if}
	    <div class="form">
	        {if $errors_calculator}
	            <div> <span class="error">{$errors_calculator}</span></div>
	        {/if}
	    {form name='calculator_req' id='calculator_req_form'}
		    <input type="hidden" name="step1" value="1">
	        <div class="label celled">Способ выбора товаров<span style="color: #f00;"> *</span>:</div>
	        <div class="inputs celled_r">
	            <input type="radio" value="yes" class="zf_radio" data-tnved_selection="1"{if !$smarty.post || $smarty.post.tnved == 'yes'} checked=""{/if} name="tnved" id="calculator_req_tnved_1"><label for="calculator_req_tnved_1"> &mdash; По кодам ТНВЭД</label><br>
	            <input type="radio" value="no" data-tnved_selection="1" class="zf_radio"{if $smarty.post.tnved == 'no'} checked=""{/if} name="tnved" id="calculator_req_tnved_2"><label for="calculator_req_tnved_2"> &mdash; По кодам категорий</label>
	        </div>

	        <div class="label celled" style="margin-top: 10px;">Валюта<span style="color: #f00;"> *</span>:</div>
	        <div class="inputs celled_r">
	            {input name=currency}
	        </div>

	        <div style="clear: both;"></div>
	        <div class="inputs">
	            <table style="width: 100%;">
	                <thead>
	                <tr>
	                    <th>Код ТНВЭД/Код категории</th>
	                    <th>&nbsp;&nbsp;Стоимость</th>
	                </tr>
	                </thead>
	                <tbody>
	                <tr style="display: none;" id="calc_clone_row" data-new_row="1" data-one_row="1">
	                    <td style="width: 435px;max-width: 435px;">
	                        <input
	                                type="hidden"
	                                name="data[new][code]"
	                                data-placeholder="Код ТНВЭД или наименование категории"
	                                data-tnved="1"
	                                data-init_on_clone="1"
	                                data-minimum_input_length="4"
	                                data-allow_clear="1"
	                                data-ajax="1"
	                                data-ajax_url="/calc/tnved">
	                    </td>
	                    <td class="span3">
							&nbsp;&nbsp;<input type="text" name="data[new][summ]" placeholder="Стоимость" class="integer">&nbsp;&nbsp;<span data-type="currency">{$cur_currency_title}</span>
						</td>
	                </tr>
	                {if $values}{assign var=i value=0}
	                    {foreach from=$values item=val}
	                        <tr data-one_row="1" data-new_row="0">
	                            <td style="width: 435px;max-width: 435px;">
	                                <input
	                                        type="hidden"
	                                        name="data[old_{$i}][code]"
	                                        data-placeholder="Код ТНВЭД или наименование категории"
	                                        data-tnved="1"
	                                        data-minimum_input_length="4"
	                                        data-allow_clear="1"
	                                        data-ajax="1"
	                                        data-ajax_url="/calc/tnved"
	                                        value="{$val.code}">
	                            </td>
	                            <td>
									&nbsp;&nbsp;<input type="text" name="data[old_{$i}][summ]" value="{$val.summ}" placeholder="Стоимость" class="integer">&nbsp;&nbsp;<span data-type="currency">{$cur_currency_title}</span>
								</td>
	                        </tr>
	                        {assign var=i value=$i+1}
	                    {/foreach}
	                {/if}
	                <tr data-one_row="1" data-new_row="1">
	                    <td style="width: 435px;max-width: 435px;">
	                        <input
	                                type="hidden"
	                                name="data[0][code]"
	                                data-placeholder="Код ТНВЭД или наименование категории"
	                                data-tnved="1"
	                                data-minimum_input_length="4"
	                                data-allow_clear="1"
	                                data-ajax="1"
	                                data-ajax_url="/calc/tnved">
	                    </td>
	                    <td class="span3">
							&nbsp;&nbsp;<input type="text" name="data[0][summ]" placeholder="Стоимость" class="integer">&nbsp;&nbsp;<span data-type="currency">{$cur_currency_title}</span>
						</td>
	                </tr>
	                </tbody>
	            </table>
	        </div>
			<div class="add_buttons">
				<input type="submit" name='calculator_form' class="order_button orange_button checkauth pull-right" value="Продолжить оформление">
			</div>
			<div style="clear: both;"></div><br>
	        <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
	    {closeformgroup}
	    </form>
	    </div>
	</div>
	{else}
	    <p>Форма отсутствует</p>
	{/if}

</div>
{*
<iframe src="http://twt-erp.artektiv.ru/legal/calc" width="600" onload="FrameManager.registerFrame(this)" frameborder="0" scrolling="no" height="600" align="left" name="calcframe" id="calcframe">
    Ваш браузер не поддерживает плавающие фреймы!
</iframe>*}
