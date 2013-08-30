<div class="form_container">
{if $success_account}
    <h2 id="account_anchor">Благодарим Вас за заявку. Наш специалист свяжется с Вами в ближайшее время. Номер вашей заявки: {$order1C_id}</h2>
{elseif $repeated_account}
    <h2 id="account_anchor">Ваша заявка уже добавлена.</h2>
    <a href="javascript:void(0)" id="show_form">Отредактировать заявку</a>
{elseif $error_accaunt}
    <h2 id="account_anchor">Заявка не добавлена. Попробуйте, пожалуйста, позже.</h2>
    <a href="javascript:void(0)" id="show_form">Отредактировать заявку</a>
{/if}
{if (!$repeated_account && !$error_accaunt && !$success_account) || ($repeated_account || $error_accaunt && !$success_account)}
    {if $repeated_account || $error_accaunt}
        <div style="display:none" id="formshow">
    {/if}
    {if $forms_elements.account_req}
        <h2 id="account_anchor">Заявка на открытие счёта</h2>
        {if $settings.account_text}<div>{$settings.account_text}</div>{/if}
        <div class="form">
            {form name='account_req' id='account_req_form'}
                {if $step > 0}<input type="hidden" name="step" id="step" value="{$step}" />{/if}
            {if $step == 2}
                <table>
                    {foreach from=$forms_elements.account_req item=account_req_elem}
                        {if $account_req_elem.name == 'bank'}
                            {foreach from=$account_req_elem key=bank_key item=bank}
                                {if is_int($bank_key)}
                                    <tr>
                                        <td width="200px">Банк: </td>
                                        <td>
                                            {foreach from=$bank.values key=value_key item=value}
                                                {if $value_key == $bank.value}
                                                    {$value}
                                                {/if}
                                            {/foreach}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="200">Валюта: </td>
                                        <td>
                                            {foreach from=$forms_elements.account_req.currency key=currency_key item=currency}
                                                {if is_int($currency_key) && $currency_key == $bank_key}
                                                    {foreach from=$currency.values key=value_key item=value}
                                                        {if $currency.value == $value_key}
                                                            {$value}
                                                        {/if}
                                                    {/foreach}
                                                {/if}
                                            {/foreach}
                                        </td>
                                    </tr>
                                {/if}
                            {/foreach}
                        {/if}
                    {/foreach}
                    {foreach from=$forms_elements.account_req item=account_req_elem}
                        {if $account_req_elem.name == 'turnover' || $account_req_elem.name == 'country_source' || $account_req_elem.name == 'country_receiver' || $account_req_elem.name == 'sources' || ($account_req_elem.name == 'own_sources' && $smarty.post.own_sources) || (($account_req_elem.name == 'bank_id' || $account_req_elem.name == 'currency_id') && !isset($forms_elements.account_req.bank))}
                            <tr>
                                <td width="200px">{label name=$account_req_elem.name}{if $account_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                <td>
                                    {if is_array($account_req_elem.value)}
                                        {if $account_req_elem.name == 'country_source' || $account_req_elem.name == 'country_receiver'}
                                            {foreach from=$account_req_elem.values key=key item=val_elem}
                                                {foreach from=$account_req_elem.value item=val}
                                                    {if $key == $val}{$val_elem}<br />{/if}
                                                {/foreach}
                                            {/foreach}
                                        {else}
                                            {foreach from=$account_req_elem.value item=val_elem}
                                                {$val_elem}<br>
                                            {/foreach}
                                        {/if}
                                    {else}
                                        {if $account_req_elem.name == 'currency_id' || $account_req_elem.name == 'bank_id'}
                                            {foreach from=$account_req_elem.values key=key item=val_elem}
                                                {if $key == $account_req_elem.value}{$val_elem}{/if}
                                            {/foreach}
                                        {else}
                                            {$account_req_elem.value}
                                        {/if}
                                    {/if}
                                </td>
                            </tr>
                        {/if}
                    {/foreach}
                    <tr>
                        <td width="200px"></td>
                        <td style="padding-top: 20px;">
                            <div class="add_buttons">
                                <input type="submit" name='account_form' class="order_button orange_button checkauth" value="Отредактировать заявку" onclick="$('#step').val('0');" style="height: 32px;">
                            </div>
                        </td>
                    </tr>
                    {foreach from=$forms_elements.account_req item=account_req_elem}
                        {if $account_req_elem.name == 'contact' || $account_req_elem.name == 'mail'}
                            <tr style="height:40px;">
                                <td width="200px">{label name=$account_req_elem.name}{if $account_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                <td>
                                    {foreach from=$errors_entity item=error key=key}
                                        {if $account_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                                    {input name=$account_req_elem.name class=$account_req_elem.name style="display:none;" onblur="$(this).hide();$('.static`$account_req_elem.name`').show();$('.static`$account_req_elem.name`').find('.label').html($(this).val());"}
                                    <span class="static{$account_req_elem.name}">
                                    <div style="float:right"><a href="#" onclick="$('.{$account_req_elem.name}').show();$('.static{$account_req_elem.name}').hide();return false;">изменить</a></div>
                                    <span class="label">{$account_req_elem.value}</span>
                                </span>
                                </td>
                            </tr>
                        {/if}
                    {/foreach}
                    <tr>
                        <td width="200px"></td>
                        <td style="padding-top: 20px;">
                            <div class="add_buttons">
                                <input onclick="yaCounter19010836.reachGoal('account_form'); return true;" type="submit" name='account_form' class="order_button orange_button checkauth" value="отправить заявку">
                            </div>
                        </td>
                    </tr>
                </table>
            {/if}
            {if $step == 2}<div style="display:none">{/if}
            <table>
                {foreach from=$forms_elements.account_req item=account_req_elem}
                    {if $account_req_elem.name != 'contact' && $account_req_elem.name != 'mail' && $account_req_elem.name != 'bank' && $account_req_elem.name != 'currency'}
                        {if in_array($account_req_elem.name, array('sources', 'own_sources'))}
                            {if $account_req_elem.name == 'sources'}
                            <tr>
                                <td style="vertical-align: top;" colspan="2">
                                    <div class="sources" style="margin-bottom: 10px;">
                                        {label name=sources}<span style="color: red;">*</span>
                                    </div>
                                    {if $errors_account.sources}
                                        <div> <span class="error">{$errors_account.sources}</span></div>
                                    {/if}
                                    <div class="own_sources" style="display: none;margin-bottom: 10px;">
                                        {label name=own_sources}<span style="color: red;">*</span>
                                    </div>

                                {*</td>*}
                                {*<td>*}
                                    {foreach from=$errors_entity item=error key=key}
                                        {if $account_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                                    <div class="sources" style="overflow: hidden;">

                                        <select multiple="multiple" name='sources_or[]' ondblclick="Add_v('sources_original', 'sources_added'); return false;" id="sources_original" class="multiselect">
                                            {foreach from=$account_req_elem.values key=k item=v}
                                                <option value="{$v}" title="{$v}">{$v}</option>
                                            {/foreach}
                                        </select>
                                        <div class="fly_buttons">
                                            <button onclick="Add_v('sources_original', 'sources_added'); return false;">>>></button>
                                            <button onclick="Add_d('sources_added'); return false;"><<<</button>
                                        </div>
                                        <select multiple="multiple" name='sources[]' ondblclick="Add_d('sources_added'); return false;" id="sources_added" class="multiselect">
                                            {if $smarty.post.sources}
                                                {foreach from=$smarty.post.sources item=val}
                                                    <option value="{$val}" selected="selected" title="{$val}">{$val}</option>
                                                {/foreach}
                                            {/if}
                                        </select>
                                        <button onclick="Add_dAll('sources_added'); return false;" class="clear_button">Очистить список</button>
                                    </div>
                                    <div><input type="checkbox" id="own_sources"{if $smarty.post.own_sources} checked="checked"{/if} style="display: block;float: left;" ><label style="font-size: 12px; padding: 0 10px 10px 5px;display: block;margin-left: 20px;">Свои источники происхождения ДС</label></div>
                                    <div class="own_sources invisible"{if !$smarty.post.own_sources} style="display: none;"{/if}>
                                        {input name=own_sources class="validate[required]"}
                                    </div>
                                </td>
                            {*                            <td>
                                <div><a href="#" id="own_kind_activities">Свой род деятельности</a></div>
                            </td>*}
                            </tr>


                            {*<tr>*}
                                    {*<td width="200px" style="vertical-align: top;">*}
                                        {*<div class="sources">*}
                                            {*{label name=sources}<span style="color: red;">*</span>*}
                                        {*</div>*}
                                        {*<div class="own_sources" style="display: none;">*}
                                            {*{label name=own_sources}<span style="color: red;">*</span>*}
                                        {*</div>*}

                                    {*</td>*}
                                    {*<td width="400px">*}
                                        {*{foreach from=$errors_account item=error key=key}*}
                                            {*{if $account_req_elem.name == $key}*}
                                                {*<span class="error">{$error}</span><br>*}
                                            {*{/if}*}
                                        {*{/foreach}*}
                                        {*<div class="sources" style="overflow: hidden;">*}
                                            {*{input name=sources class="validate[required]"}*}
                                            {*{section name=checkboxes loop=$account_req_elem.values}*}
                                                {*<div class="subject-tags">{input name=sources class="validate[required]" num=$smarty.section.checkboxes.iteration-1}</div>*}
                                            {*{/section}*}
                                        {*</div>*}
                                        {*<div><input type="checkbox" id="own_sources" style="display: block;float: left;"><label style="font-size: 12px; padding: 0 10px 10px 5px;display: block;margin-left: 20px;">Свои источники происхождения ДС</label></div>*}
                                        {*<div class="own_sources invisible" style="display: none;">*}
                                            {*{input name=own_sources class="validate[required]"}*}
                                            {*<div style="clear:both"></div>*}
                                        {*</div>*}

                                    {*</td>*}
                                    {*<td width="150px">*}
                                        {*<div><a href="#" id="own_sources">Свои источники происхождения ДС</a></div>*}
                                    {*</td>*}
                                {*</tr>*}

                            {/if}
                        {elseif $account_req_elem.name == 'country_source'}
                            <tr>
                                <td>
                                    <div style="margin-bottom: 10px;">
                                        {label name=$account_req_elem.name}{if $account_req_elem.req}<span style="color: red;">*</span>{/if}:
                                    </div>
                                </td>
                                <td style="vertical-align: top;">
                                    <div class="kind_activities">
                                        <select data-placeholder="Выберите страну" data-no_results_text="Не найдено" class="chzn-select" name='country_source[]' multiple="multiple" style="width:350px;">
                                            {foreach from=$account_req_elem.values key=k item=v}
                                                <option value="{$k}" title="{$v}"{if $smarty.post.country_source && in_array($k, $smarty.post.country_source)} selected="selected"{/if}>{$v}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    {foreach from=$errors_entity item=error key=key}
                                        {if $account_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                                </td>
                            {*                            <td>
                                <div><a href="#" id="own_kind_activities">Свой род деятельности</a></div>
                            </td>*}
                            </tr>
                        {elseif $account_req_elem.name == 'country_receiver'}
                            <tr>
                                <td colspan="2" style="font-size: 12px;"><input type="checkbox" id="match">Страны назначения совпадают со странами источниками</td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="margin-bottom: 10px;">
                                        {label name=$account_req_elem.name}{if $account_req_elem.req}<span style="color: red;">*</span>{/if}:
                                    </div>
                                </td>
                                <td style="vertical-align: top;">
                                    <div class="kind_activities">
                                        <select data-placeholder="Выберите страну" data-no_results_text="Не найдено" class="chzn-select1" name='country_receiver[]' multiple="multiple" style="width:350px;">
                                            {foreach from=$account_req_elem.values key=k item=v}
                                                <option value="{$k}" title="{$v}"{if $smarty.post.country_receiver && in_array($k, $smarty.post.country_receiver)} selected="selected"{/if}>{$v}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    {foreach from=$errors_entity item=error key=key}
                                        {if $account_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                                </td>
                            {*                            <td>
                                <div><a href="#" id="own_kind_activities">Свой род деятельности</a></div>
                            </td>*}
                            </tr>
                        {else}
                            {assign var="validators" value="validate["}
                            {if $account_req_elem.req}
                                {assign var="validators" value=$validators|cat:"required"}
                            {/if}
                            {assign var="validators" value=$validators|cat:"]"}
                            {assign var="tmp" value=$account_req_elem.name}
                            {assign var="el_name" value=$tmp|regex_replace:"/\[.*/":""}
                            {if $account_req_elem.name == 'bank_id'}
                                <tr>
                                    <td colspan="2">
                                        {if $smarty.post.bank_id|@count > 1}
                                            {foreach from=$errors_account item=error key=k}
                                                {if $el_name == $k}
                                                    <span class="error">{$error}</span><br>
                                                {/if}
                                            {/foreach}
                                            {foreach from=$smarty.post.bank_id key=key item=bank name=bank}
                                            <table>
                                                <tr>
                                                    <td width="200">{label name=bank_id}{if $account_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                                    <td>{input name="bank_id[$key]" class=$validators number="$key"}</td>
                                                </tr>
                                                <tr>
                                                    <td class="error_fix">{label name=currency_id}: </td>
                                                    <td>
                                                        {input name="currency_id[$key]" class=$validators number="$key"}
                                                        <div style="display: none;color: #f00; font-weight: bold;"><br>{if $settings.set_account_text}{$settings.set_account_text}: {/if}<span id="cur"></span></div>
                                                    </td>
                                                </tr>
                                            </table>
                                                {if !$smarty.foreach.bank.last}<input type="button" class="delinput" value="-"/>{/if}
                                            {/foreach}
                                        {else}
                                            {foreach from=$errors_account item=error key=k}
                                                {if $el_name == $k}
                                                    <span class="error">{$error}</span><br>
                                                {/if}
                                            {/foreach}
                                            <table>
                                                <tr>
                                                    <td width="200">{label name=bank_id}{if $account_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                                    <td>{input name='bank_id' class=$validators }</td>
                                                </tr>
                                                <tr>
                                                    <td class="error_fix">{label name=currency_id}: </td>
                                                    <td>
                                                        {input name='currency_id' class=$validators }
                                                        <div style="display: none;color: #f00; font-weight: bold;"><br>{if $settings.set_account_text}{$settings.set_account_text} {/if}<span id="cur"></span></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        {/if}
                                        <button id="bank_currency">Добавить</button><br>
                                    </td>
                                </tr>
                            {elseif $account_req_elem.name != 'currency_id' && $el_name!='bank_id' && $el_name!='currency_id'}
                                <tr>
                                    <td>{label name=$account_req_elem.name}{if $account_req_elem.req || $account_req_elem.name == 'captcha'}<span style="color: red;">*</span>{/if}: </td>
                                    <td>
                                    {foreach from=$errors_account item=error key=key}
                                        {if $account_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                                    {*{input name=$account_req_elem.name class=$validators }*}

                          {*          {if $account_req_elem.name == 'country_source' || $account_req_elem.name == 'country_receiver'}
                                        <div class="country_source">
                                            {section name=checkboxes loop=$account_req_elem.values}
                                                <div class="subject-tags">{input name=$account_req_elem.name class=$validators num=$smarty.section.checkboxes.iteration-1}</div>
                                            {/section}
                                            <div style="clear:both"></div>
                                        </div>
                                        {else}*}

                                        {input name=$account_req_elem.name class=$validators }

                                    {*{/if}*}
                                {if $account_req_elem.name == 'turnover'}<div id="currency"></div>{/if}
                                </td>
                                {*<td width="150px">*}
                                {*</td>*}
                            </tr>
                            {/if}
                        {/if}
                    {/if}
                {/foreach}
                <tr>
                    <td width="200px"></td>
                    <td style="padding-top: 20px;">
                        <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
                        {if $step == 1}
                            <div style="display: none">
                                {foreach from=$forms_elements.account_req item=account_req_elem}
                                    {if $account_req_elem.name == 'contact' || $account_req_elem.name == 'mail'}
                                        {input name=$account_req_elem.name class=$account_req_elem.name}
                                    {/if}
                                {/foreach}
                            </div>
                        {/if}
                    </td>
                    {*<td width="150px">*}
                    {*</td>*}
                </tr>
                <tr>
                    <td width="200px"></td>
                    <td style="padding-top: 20px;">
                        <div class="add_buttons">
                            <input type="submit" name='account_form' class="order_button orange_button checkauth" value="отправить заявку">
                        </div>
                    </td>
                    {*<td width="150px">*}
                    {*</td>*}
                </tr>
            </table>
            {if $step == 2}</div>{/if}
            <br>
            {literal}
            <script type="text/javascript">
                $('form img[class*=validate]').removeAttr('class');
                $(".chzn-select").chosen().change(function(){
                    ChangeCountries();
                });
                $(".chzn-select1").chosen();
            </script>
            {/literal}

            {closeformgroup}
            </form>
        </div>
        {if $repeated_account || $error_account}
            </div>
        {/if}
    {/if}
{/if}
</div>