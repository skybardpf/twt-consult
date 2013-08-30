<div class="form_container">
{if $success_entity}
    <h2 id="entity_anchor">Благодарим Вас за заявку. Наш специалист свяжется с Вами в ближайшее время. Номер вашей заявки: {$order1C_id}</h2>
{elseif $repeated_entity}
    <h2 id="entity_anchor">Ваша заявка уже добавлена.</h2>
    <a href="javascript:void(0)" id="show_form">Отредактировать заявку</a>
{elseif $error_urid}
    <h2 id="entity_anchor">Заявка не добавлена. Попробуйте, пожалуйста, позже.</h2>
    <a href="javascript:void(0)" id="show_form">Отредактировать заявку</a>
{/if}
{if (!$repeated_entity && !$error_urid && !$success_entity) || ($repeated_entity || $error_urid && !$success_entity)}
    {if $repeated_entity || $error_urid}
        <div style="display:none" id="formshow">
    {/if}
    {if $forms_elements.entity_req}
        <h2 id="entity_anchor">Заявка на регистрацию компании</h2>
        {if $settings.entity_text}<div>{$settings.entity_text}</div>{/if}
        <div class="form">
            {form name='entity_req' id='entity_req_form'}
                {if $step > 0}<input type="hidden" name="step" id="step" value="{$step}" />{/if}
            {if $step == 2}
            <table>
                {foreach from=$forms_elements.entity_req item=entity_req_elem}
                    {if $entity_req_elem.name != 'contact' && $entity_req_elem.name != 'mail' && $entity_req_elem.name != 'captcha' && ($entity_req_elem.name != 'own_kind_activities' || $smarty.post.own_kind_activities)}
                        <tr>
                            <td width="200px">{label name=$entity_req_elem.name}{if $entity_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                            <td>
                                {if is_array($entity_req_elem.value)}
                                    {if $entity_req_elem.name == 'country_source' || $entity_req_elem.name == 'country_receiver'}
                                        {foreach from=$entity_req_elem.values key=key item=val_elem}
                                            {foreach from=$entity_req_elem.value item=val}
                                                {if $key == $val}{$val_elem}<br />{/if}
                                            {/foreach}
                                        {/foreach}
                                    {else}
                                    {foreach from=$entity_req_elem.value item=val_elem}
                                        {$val_elem}<br>
                                    {/foreach}
                                    {/if}
                                {else}
                                    {if $entity_req_elem.name == 'currency_id' || $entity_req_elem.name == 'jur_country_id'}
                                        {foreach from=$entity_req_elem.values key=key item=val_elem}
                                            {if $key == $entity_req_elem.value}{$val_elem}{/if}
                                        {/foreach}
                                    {else}
                                        {$entity_req_elem.value}
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
                            <input type="submit" name='entity_form' class="order_button orange_button checkauth" value="Отредактировать заявку" onclick="$('#step').val('0');" style="height: 32px;">
                        </div>
                    </td>
                </tr>
                {foreach from=$forms_elements.entity_req item=entity_req_elem}
                    {if $entity_req_elem.name == 'contact' || $entity_req_elem.name == 'mail'}
                        <tr style="height:40px;">
                            <td width="200px">{label name=$entity_req_elem.name}{if $entity_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                            <td>
                                {foreach from=$errors_entity item=error key=key}
                                    {if $entity_req_elem.name == $key}
                                        <span class="error">{$error}</span><br>
                                    {/if}
                                {/foreach}
                                {input name=$entity_req_elem.name class=$entity_req_elem.name style="display:none;" onblur="$(this).hide();$('.static`$entity_req_elem.name`').show();$('.static`$entity_req_elem.name`').find('.label').html($(this).val());"}
                                <span class="static{$entity_req_elem.name}">
                                    <div style="float:right"><a href="#" onclick="$('.{$entity_req_elem.name}').show();$('.static{$entity_req_elem.name}').hide();return false;">изменить</a></div>
                                    <span class="label">{$entity_req_elem.value}</span>
                                </span>
                            </td>
                        </tr>
                    {/if}
                {/foreach}
                <tr>
                    <td width="200px"></td>
                    <td style="padding-top: 20px;">
                        <div class="add_buttons">
                            <input onclick="yaCounter19010836.reachGoal('entity_form'); return true;" type="submit" name='entity_form' class="order_button orange_button checkauth" value="отправить заявку">
                        </div>
                    </td>
                </tr>
            </table>
            {/if}
            {if $step == 2}<div style="display:none">{/if}
            <table>
                {foreach from=$forms_elements.entity_req item=entity_req_elem}
                    {if $entity_req_elem.name != 'contact' && $entity_req_elem.name != 'mail'}
                        {if in_array($entity_req_elem.name, array('kind_activities', 'own_kind_activities'))}
                            {if $entity_req_elem.name == 'kind_activities'}
                                <tr>
                                    <td colspan="2" style="vertical-align: top;">
                                        <div class="kind_activities" style="margin-bottom: 10px;">
                                            {label name=kind_activities}<span style="color: red;">*</span>
                                        </div>
                                        <div class="own_kind_activities" style="display: none;">
                                            {label name=own_kind_activities}<span style="color: red;">*</span>
                                        </div>

                                    {*</td>*}
                                    {*<td>*}
                                        {foreach from=$errors_entity item=error key=key}
                                            {if $entity_req_elem.name == $key}
                                                <span class="error">{$error}</span><br>
                                            {/if}
                                        {/foreach}
                                        <div class="kind_activities" style="overflow: hidden;">
                                            <select multiple="multiple" name='kind_activities_or[]' ondblclick="Add_v('kind_activities_original', 'kind_activities_added'); return false;" id="kind_activities_original" class="multiselect">
                                                {foreach from=$entity_req_elem.values key=k item=v}
                                                    <option value="{$v}" title="{$v}">{$v}</option>
                                                {/foreach}
                                            </select>
                                            <div class="fly_buttons">
                                                <button onclick="Add_v('kind_activities_original', 'kind_activities_added'); return false;">>>></button>
                                                <button onclick="Add_d('kind_activities_added'); return false;"><<<</button>
                                            </div>

                                            <select multiple="multiple" name='kind_activities[]' ondblclick="Add_d('kind_activities_added'); return false;" id="kind_activities_added" class="multiselect">
                                                {if $smarty.post.kind_activities}
                                                    {foreach from=$smarty.post.kind_activities item=val}
                                                        <option value="{$val}" selected="selected" title="{$val}">{$val}</option>
                                                    {/foreach}
                                                {/if}
                                            </select>
                                            <button onclick="Add_dAll('kind_activities_added'); return false;" class="clear_button">Очистить список</button>
                                        </div>
                                        <div><input type="checkbox" id="own_kind_activities"{if $smarty.post.own_kind_activities} checked="checked"{/if} style="display: block;float: left;" ><label style="font-size: 12px; padding: 0 10px 10px 5px;display: block;margin-left: 20px;">Свой род деятельности</label></div>
                                        <div class="own_kind_activities invisible"{if !$smarty.post.own_kind_activities} style="display: none;"{/if}>
                                            {input name=own_kind_activities class="validate[required]"}
                                        </div>
                                    </td>
        {*                            <td>
                                        <div><a href="#" id="own_kind_activities">Свой род деятельности</a></div>
                                    </td>*}
                                </tr>
                            {/if}
                        {elseif $entity_req_elem.name == 'country_source'}
                            <tr>
                                <td>
                                    <div style="margin-bottom: 10px;">
                                        {label name=$entity_req_elem.name}{if $entity_req_elem.req}<span style="color: red;">*</span>{/if}:
                                    </div>
                                </td>
                                <td style="vertical-align: top;">
                                    <div class="kind_activities">
                                        <select data-placeholder="Выберите страну" data-no_results_text="Не найдено" class="chzn-select" name='country_source[]' multiple="multiple" style="width:350px;">
                                        <!--<select multiple="multiple" name='country_source_or[]' ondblclick="Add_v('country_source_original', 'country_source_added'); return false;" id="country_source_original" class="multiselect">-->
                                            {foreach from=$entity_req_elem.values key=k item=v}
                                                <option value="{$k}" title="{$v}"{if $smarty.post.country_source && in_array($k, $smarty.post.country_source)} selected="selected"{/if}>{$v}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    {foreach from=$errors_entity item=error key=key}
                                        {if $entity_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                                </td>
        {*                            <td>
                                    <div><a href="#" id="own_kind_activities">Свой род деятельности</a></div>
                                </td>*}
                            </tr>
                        {elseif $entity_req_elem.name == 'country_receiver'}
                        <tr>
                            <td colspan="2" style="font-size: 12px;">
                                <input type="checkbox" id="match">Страны назначения совпадают со странами источниками
                            </td>
                        </tr>
                            <tr>
                                <td>
                                    <div style="margin-bottom: 10px;">
                                        {label name=$entity_req_elem.name}{if $entity_req_elem.req}<span style="color: red;">*</span>{/if}:
                                    </div>
                                </td>
                                <td style="vertical-align: top;">
                                    <div class="kind_activities">
                                        <select data-placeholder="Выберите страну" data-no_results_text="Не найдено" class="chzn-select1" name='country_receiver[]' multiple="multiple" style="width:350px;">
                                            {foreach from=$entity_req_elem.values key=k item=v}
                                                <option value="{$k}" title="{$v}"{if $smarty.post.country_receiver && in_array($k, $smarty.post.country_receiver)} selected="selected"{/if}>{$v}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    {foreach from=$errors_entity item=error key=key}
                                        {if $entity_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                                </td>
        {*                            <td>
                                    <div><a href="#" id="own_kind_activities">Свой род деятельности</a></div>
                                </td>*}
                            </tr>
                        {elseif $entity_req_elem.name == 'jur_country_id'}
                            <tr>
                                <td width="170px" class="error_fix">{label name=$entity_req_elem.name}{if $entity_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                 <td>
                                    {foreach from=$errors_entity item=error key=key}
                                        {if $entity_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                                    {input name=$entity_req_elem.name class=$validators }
                                    <br>
                                     <div id="div" style="display: none; text-align: left; width:388px; margin-top: 5px; color: #f00; font-weight: bold;">{if $settings.settings_entity_text}{$settings.settings_entity_text} {/if}<span id="cur"></span></div>
                                </td>
                            </tr>
                        {else}
                            {assign var="validators" value="validate["}
                            {if $entity_req_elem.req}
                                {assign var="validators" value=$validators|cat:"required"}
                            {/if}
                            {assign var="validators" value=$validators|cat:"]"}
                            <tr>
                                <td width="170px">{label name=$entity_req_elem.name}{if $entity_req_elem.req || $entity_req_elem.name == 'captcha'}<span style="color: red;">*</span>{/if}: </td>
                                <td>
                                    {foreach from=$errors_entity item=error key=key}
                                        {if $entity_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}

                                    {*{if $entity_req_elem.name == 'country_source' || $entity_req_elem.name == 'country_receiver'}
                                        <div class="country_source">11
                                            {section name=checkboxes loop=$entity_req_elem.values}
                                                <div class="subject-tags">22{input name=$entity_req_elem.name class=$validators num=$smarty.section.checkboxes.iteration-1}</div>
                                            {/section}
                                            <div style="clear:both"></div>
                                        </div>
                                        {else}*}
                                        {input name=$entity_req_elem.name class=$validators }
                                    {*{/if}*}

                                    {*{input name=$entity_req_elem.name class=$validators }*}
                                </td>
                            {*<td width="150px">
                                </td>*}
                            </tr>
                        {/if}
                    {/if}
                {/foreach}
                <tr>
                    <td width="170px"></td>
                    <td style="padding-top: 20px;">
                        <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
                        {if $step == 1}
                            <div style="display: none">
                                {foreach from=$forms_elements.entity_req item=entity_req_elem}
                                    {if $entity_req_elem.name == 'contact' || $entity_req_elem.name == 'mail'}
                                        {input name=$entity_req_elem.name class=$entity_req_elem.name}
                                    {/if}
                                {/foreach}
                            </div>
                        {/if}
                    </td>
                {*<td width="150px">
                    </td>*}
                </tr>
                <tr>
                    <td width="170px"></td>
                    <td style="padding-top: 20px;">
                        <div class="add_buttons">
                            <input type="submit" name='entity_form' class="order_button orange_button checkauth" value="отправить заявку">
                        </div>
                    </td>
                {*<td width="150px">
                    </td>*}
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
        {if $repeated_entity || $error_urid}
            </div>
        {/if}
    {/if}
{/if}
</div>
