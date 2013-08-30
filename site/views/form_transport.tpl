<div class="form_container">
{if $success_transport}
    <h2 id="transport_anchor">Благодарим Вас за заявку. Наш специалист свяжется с Вами в ближайшее время. Номер вашей заявки: {$order1C_id}</h2>
{elseif $repeated_transport}
    <h2 id="transport_anchor">Ваша заявка уже добавлена.</h2>
    <a href="javascript:void(0)" id="show_form">Отредактировать заявку</a>
{elseif $error_transport}
    <h2 id="transport_anchor">Заявка не добавлена. Попробуйте, пожалуйста, позже.</h2>
    <a href="javascript:void(0)" id="show_form">Отредактировать заявку</a>
{/if}
{if (!$repeated_transport && !$error_transport && !$success_transport) || ($repeated_transport || $error_transport && !$success_transport)}
    {if $repeated_transport || $error_transport}
        <div style="display:none" id="formshow">
    {/if}
    {if $forms_elements.transport_req}
    <h2 id="transport_anchor">Комплексная заявка на транспортную логистику и таможенное оформление</h2>
    {if $settings.transport_text}<div>{$settings.transport_text}</div>{/if}
        <div class="form">
            {form name='transport_req' id='transport_req_form'}
                {if $step > 0}<input type="hidden" name="step" id="step" value="{$step}" />{/if}
            <table>
                {foreach from=$forms_elements.transport_req item=transport_req_elem}
                    {if $transport_req_elem.name != 'contact' && $transport_req_elem.name != 'mail'}
                        {assign var="tmp" value=$transport_req_elem.name}
                        {assign var="el_name" value=$tmp|regex_replace:"/\[.*/":""}
                        {if $transport_req_elem.name == 'cost'}
                            <tr>
                                <td width="200px">{label name=$transport_req_elem.name}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                <td>
                                    {foreach from=$errors_transport item=error key=key}
                                        {if $transport_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                                    {if $step == 2}
                                        {$transport_req_elem.value}
                                        {input name=$transport_req_elem.name class=$transport_req_elem.name style="display:none"}
                                    {else}
                                        {input name=$transport_req_elem.name class=$transport_req_elem.name}
                                    {/if}
                        {elseif $transport_req_elem.name == 'currency'}
                                    {foreach from=$errors_transport item=error key=key}
                                        {if $transport_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                                    {if $step == 2}
                                        {$transport_req_elem.value}
                                        {input name=$transport_req_elem.name class=$transport_req_elem.name style="display:none"}
                                    {else}
                                        {input name=$transport_req_elem.name class=$transport_req_elem.name}
                                    {/if}
                                </td>
                            </tr>
                        {elseif $transport_req_elem.name != 'currency' && $transport_req_elem.name != 'cost'}
                            {assign var="validators" value="validate["}
                            {if $transport_req_elem.req}
                                {assign var="validators" value=$validators|cat:"required"}
                            {/if}
                            {assign var="validators" value=$validators|cat:"]"}
                            <tr>
                                <td width="200px"{if $transport_req_elem.name == 'services'} style="vertical-align: top;"{elseif $transport_req_elem.name == 'captcha'} style="vertical-align: top;"{/if}>
                                    {if $transport_req_elem.name == 'captcha'}
                                        {if $step == 1}
                                           {label name=$transport_req_elem.name}<span style="color: red;">*</span>:
                                        {/if}
                                    {else}
                                        {label name=$transport_req_elem.name}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}:
                                    {/if}
                                </td>
                                <td>
                                    {foreach from=$errors_transport item=error key=key}
                                        {if $transport_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                        {if $transport_req_elem.name == 'services'}
                            <div id="services">
                                {if $step == 2}
                                    <div style="display: none">
                                        {section name=checkboxes loop=$transport_req_elem.values}
                                            {input name=$transport_req_elem.name class=$validators num=$smarty.section.checkboxes.iteration-1}
                                        {/section}
                                    </div>
                                    {foreach from=$transport_req_elem.values key=key item=val_elem}
                                        {foreach from=$transport_req_elem.value item=val}
                                            {if $key == $val}
                                                {$val_elem}<br />
                                            {/if}
                                        {/foreach}
                                    {/foreach}
                                {else}
                                    {section name=checkboxes loop=$transport_req_elem.values}
                                        <div class="subject-tags">
                                            {input name=$transport_req_elem.name class=$validators num=$smarty.section.checkboxes.iteration-1}
                                        </div>
                                    {/section}
                                {/if}
                                <div style="clear:both"></div>
                            </div>
                        {elseif $transport_req_elem.name == 'captcha'}
                            {if $step == 1}
                                {input name=$transport_req_elem.name class=$validators }
                            {/if}
                        {else}
                            {if $step == 2}
                                {$transport_req_elem.value}
                                {input name=$transport_req_elem.name class=$validators style="display:none"}
                            {else}
                                {input name=$transport_req_elem.name class=$validators}
                            {/if}
                        {/if}
                                </td>
                            </tr>
                        {/if}
                    {/if}
                {/foreach}
                {if $step == 1}
                    <tr>
                        <td width="200px"></td>
                        <td style="padding-top: 20px;font-size: 13px;">
                            <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
                            <div style="display: none">
                                {foreach from=$forms_elements.transport_req item=transport_req_elem}
                                    {if $transport_req_elem.name == 'contact' || $transport_req_elem.name == 'mail'}
                                        {input name=$transport_req_elem.name class=$transport_req_elem.name}
                                    {/if}
                                {/foreach}
                            </div>
                        </td>
                    </tr>
                {/if}
                {if $step == 2}
                    <tr>
                        <td width="200px"></td>
                        <td style="padding-top: 20px;">
                            <div class="add_buttons">
                                <input type="submit" name='transport_form' class="order_button orange_button checkauth" value="Отредактировать заявку" onclick="$('#step').val('0');" style="height: 32px;">
                            </div>
                        </td>
                    </tr>
                    {foreach from=$forms_elements.transport_req item=transport_req_elem}
                        {if $transport_req_elem.name == 'contact' || $transport_req_elem.name == 'mail'}
                            <tr style="height:40px;">
                                <td width="200px">{label name=$transport_req_elem.name}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                <td>
                                    {foreach from=$errors_transport item=error key=key}
                                        {if $transport_req_elem.name == $key}
                                            <span class="error">{$error}</span><br>
                                        {/if}
                                    {/foreach}
                                    {input name=$transport_req_elem.name class=$transport_req_elem.name style="display:none;" onblur="$(this).hide();$('.static`$transport_req_elem.name`').show();$('.static`$transport_req_elem.name`').find('.label').html($(this).val());"}
                                    <span class="static{$transport_req_elem.name}">
                                        <div style="float:right"><a href="#" onclick="$('.{$transport_req_elem.name}').show();$('.static{$transport_req_elem.name}').hide();return false;">изменить</a></div>
                                        <span class="label">{$transport_req_elem.value}</span>
                                    </span>
                                </td>
                            </tr>
                        {/if}
                    {/foreach}
                {/if}
                <tr>
                    <td width="200px"></td>
                    <td style="padding-top: 20px;">
                        <div class="add_buttons">
                            <input {if $step == 2}onclick="yaCounter19010836.reachGoal('transport_form'); return true;"{/if} type="submit" name='transport_form' class="order_button orange_button checkauth" value="отправить заявку">
                        </div>
                    </td>
                </tr>
            </table>

            <br>

            <script type="text/javascript">
                $('form img[class*=validate]').removeAttr('class');
            </script>


            {closeformgroup}
            </form>
        </div>
        {if $repeated_transport || $error_transport}
            </div>
        {/if}
    {/if}
{/if}
</div>
