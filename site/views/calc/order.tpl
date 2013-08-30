{literal}
    <script type="text/javascript">
        window.order_cities_link = "/calc/cities";
    </script>
{/literal}
<div class="service_cont calc_order">
{if $success}
    <h2 id="alculator_anchor">Страховой калькулятор</h2>
	<div class="calc_outer">
    {if $settings.calculator_text}<div>{$settings.calculator_text}</div>{/if}
    <div class="form">
        <p>Ваша заявка №{$order_id} успешно оформлена!</p>
    </div>
	</div>
{else}
    <h2 id="alculator_anchor">Страховой калькулятор</h2>
	<div class="calc_outer">
	<div class="calc_bc"><a href="/calc/step1">Шаг 1</a> - <a href="/calc/step2">Шаг 2</a> - <span>Шаг 3</span></div>
	{if $settings.calculator_text}<div class="calc_bc"><span>{$settings.calculator_text}</span></div>{/if}
    <div class="form">
        {if $errors_calculator}
            <div> <span class="error">{$errors_calculator}</span></div>
        {/if}
        <form name='calculator_req' id='calculator_req_form' action="/calc/step3" method="post">
	        <input type="hidden" name="step3" value="1">
            <input type="hidden" id="order_number" name="order[NumberOfPreOrder]" value="{if $order.NumberOfPreOrder}{$order.NumberOfPreOrder}{else}0{/if}">
            <input type="hidden" id="order_date" name="order[DateOfPreOrder]" value="{if $order.DateOfPreOrder}{$order.DateOfPreOrder}{else}{/if}">

            <table width="580">
                <tr>
                    <td width="200px"><label for="order_CompanyName">Наименование компании</label></td>
                    <td><input type="text" class="validate[required]" id="order_CompanyName" name="order[CompanyName]" value="{if $order.CompanyName}{$order.CompanyName}{else}{/if}"></td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_Beneficiary">Выгодоприобретатель</label></td>
                    <td><input type="text" class="validate[required]" id="order_Beneficiary" name="order[Beneficiary]" value="{if $order.Beneficiary}{$order.Beneficiary}{else}{/if}"></td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_NumberOfSeat">Груз (товары через запятую)</label></td>
                    <td><textarea class="validate[required]" id="order_NumberOfSeat" name="order[NumberOfSeat]">{if $order.NumberOfSeat}{$order.NumberOfSeat}{else}{/if}</textarea></td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_Consignment">Количество мест</label></td>
                    <td><input type="text" class="validate[required]" id="order_Consignment" name="order[Consignment]" value="{if $order.Consignment}{$order.Consignment}{else}{/if}"></td>
                <tr>
                    <td width="200px"><label for="order_NumberOfSeatMeasure">Единица измерения мест</label></td>
                    <td>
                        <select id="order_NumberOfSeatMeasure" name="order[NumberOfSeatMeasure]">
                            <option value="">Не выбрано</option>
                            {foreach from=$NumberOfSeatMeasure key=k item=v}
                                <option value="{$k}"{if $order.NumberOfSeatMeasure == $k} selected{else}{/if}>{$v}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_Weight">Общий вес</label></td>
                    <td><input type="text" class="validate[required] integer" id="order_Weight" name="order[Weight]" value="{if $order.Weight}{$order.Weight}{else}{/if}"></td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_Documents">Список документов</label></td>
                    <td><textarea class="validate[required]" id="order_Documents" name="order[Documents]">{if $order.Documents}{$order.Documents}{else}{/if}</textarea></td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_StartDate">Начало страхования<span style="color: #FF0000;"> *</span></label></td>
                    <td>
                        <input type="text" name="order[StartDate]" value="{if $order.StartDate}{$order.StartDate}{else}{/if}"/>
                        {literal}
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('input[name="order[StartDate]"]').dynDateTime({
                                        singleClick: true,
                                        align: 'T',
                                        ifFormat: '%Y-%m-%d',
                                        daFormat: '%Y-%m-%d'
                                    });
                                });
                            </script>
                        {/literal}
                    </td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_EndDate">Конец страхования<span style="color: #FF0000;"> *</span></label></td>
                    <td>
                        <input type="text" name="order[EndDate]" value="{if $order.EndDate}{$order.EndDate}{else}{/if}"/>
                        {literal}
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('input[name="order[EndDate]"]').dynDateTime({
                                        singleClick: true,
                                        align: 'T',
                                        ifFormat: '%Y-%m-%d',
                                        daFormat: '%Y-%m-%d'
                                    });
                                });
                            </script>
                        {/literal}
                    </td>
                </tr>
            </table>
            <br/>
            <table id="route_points_table" width="580">
                <thead>
                <tr>
                    <th>Маршрут</th>
                    <th style="padding-left: 110px; font-size: 12px;">
                        <span>
							<a id="route_point_add_button" href="javascript:void(0);">Добавить промежуточную точку маршрута</a>
                        </span>
                    </th>
                </tr>
                </thead>
                <tr style="display: none;" id="route_point" data-route_middle="1">
                    <td class="small_font"><span>Промежут. точка маршрута</span></td>
                    <td>{loadview name="calc/route_point" field=middle iteration="__iteration__"}</td>
                </tr>
                <tr id="route_first_point">
                    <td class="small_font" style="width: 101px;"><span>Начальная точка маршрута<span style="color: #FF0000;"> *</span></span></td>
                    <td>
                        {if $order.route.begin}
                            {assign var=point value=$order.route.begin}
                        {else}
                            {assign var=point value=null}
                        {/if}
                        {loadview name="calc/route_point" field=begin iteration=false point=$point cities=$begin_cities}
                    </td>
                </tr>
                {if $order.route.middle}
                    {foreach from=$order.route.middle key=iter item=point}
                        <tr data-route_middle="1">
                            <td class="small_font"><span>Промежуточная точка маршрута</span></td>
                            <td>{loadview name="calc/route_point" field=middle iteration=$iter point=$point cities=$point.cities}</td>
                        </tr>
                    {/foreach}
                {/if}

                <tr id="route_last_point">
                    <td class="small_font"><span>Конечная точка маршрута<span style="color: #FF0000;"> *</span></span></td>
                    <td>
                        {if $order.route.end}
                            {assign var=point value=$order.route.end}
                        {else}
                            {assign var=point value=null}
                        {/if}
                        {loadview name="calc/route_point" field=end iteration=false point=$point cities=$end_cities}
                    </td>
                </tr>
            </table>
            <table width="580">
                <tr>
                    <td width="200px">
						<br><label for="order_CompanyName">Введите текст с картинки</label><br>
						{math equation='rand()' assign=rand}
						<img style='cursor: pointer;' src="/captcha/?{$rand}"/>
					</td>
                    <td>
                        <div style='position:relative;'>
                            <img style='display:none; position:absolute; top:0; left:0;' src='/public/zf/img/loading.gif' alt=''/>
                        </div><br />
                        <input type="text" name="order[verifyCode]" value=""/>
                    </td>
                </tr>
            </table>
			<div class="add_buttons">
				<a class="pull-left back_link" href="/calc/step2">Вернуться назад</a>
				<input type="submit" name='calculator_form' class="order_button orange_button checkauth pull-right" value="Оформить заявку">
			</div>
			<div style="clear: both;"></div><br>
            <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
        </form>
    </div>
	</div>
{/if}
</div>