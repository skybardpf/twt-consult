<div class="form_container">
{if $success_transport}
    <h2 id="transport_anchor">Ваша заявка успешно добавлена.</h2>
{elseif $repeated_transport}
    <h2 id="transport_anchor">Ваша заявка уже добавлена.</h2>
{else}
    {if $forms_elements.transport_req}
    <h2 id="transport_anchor">Комплексная заявка на транспортную логистику и таможенное оформление</h2>
    <div class="form">
        {form name='transport_req' id='transport_req_form'}
        <table>
            {foreach from=$forms_elements.transport_req item=transport_req_elem}

                {assign var="tmp" value=$transport_req_elem.name}
                {assign var="el_name" value=$tmp|regex_replace:"/\[.*/":""}
                {if $transport_req_elem.name == 'loading_city'}
                    <tr>
                        <td colspan="2">
                            {if $smarty.post.loading_city|@count > 1}
                                {foreach from=$smarty.post.loading_city key=key item=loading name=loading}
                                    <table>
                                        <tr>
                                            <td width="200px">{label name=loading_city}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                            <td>{input name="loading_city[$key]" class=$validators number="$key"}</td>
                                        </tr>
                                        <tr>
                                            <td>{label name=loading_index}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                            <td>{input name="loading_index[$key]" class=$validators number="$key"}</td>
                                        </tr>
                                    </table>
                                    {if !$smarty.foreach.loading.last}<input type="button" class="delinputload" value="-"/>{/if}
                                {/foreach}
                                {foreach from=$errors_transport item=error key=k}
                                    {if $el_name == $k}
                                        <span class="error">{$error}</span><br>
                                    {/if}
                                {/foreach}
                                {else}
                                <table>
                                    <tr>
                                        <td width="200px">{label name=loading_city}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                        <td>{input name='loading_city' class=$validators }</td>
                                    </tr>
                                    <tr>
                                        <td>{label name=loading_index}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                        <td>{input name='loading_index' class=$validators }</td>
                                    </tr>
                                </table>
                                {foreach from=$errors_transport item=error key=k}
                                    {if $el_name == $k}
                                        <span class="error">{$error}</span><br>
                                    {/if}
                                {/foreach}
                            {/if}
                            <button id="loading">Добавить</button><br>
                        </td>
                    </tr>
                {elseif $transport_req_elem.name == 'delivery_city'}
                    <tr>
                        <td colspan="2">
                            {if $smarty.post.delivery_city|@count > 1}
                                {foreach from=$smarty.post.delivery_city key=key item=delivery name=delivery} {$delivery}
                                    <table>
                                        <tr>
                                            <td width="200px">{label name=delivery_city}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                            <td>{input name="delivery_city[$key]" class=$validators number="$key"}</td>
                                        </tr>
                                        <tr>
                                            <td>{label name=delivery_index}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                            <td>{input name="delivery_index[$key]" class=$validators number="$key"}</td>
                                        </tr>
                                    </table>
                                    {if !$smarty.foreach.delivery.last}<input type="button" class="delinputdelivery" value="-"/>{/if}
                                {/foreach}
                                {foreach from=$errors_transport item=error key=k}
                                    {if $el_name == $k}
                                        <span class="error">{$error}</span><br>
                                    {/if}
                                {/foreach}
                                {else}
                                <table>
                                    <tr>
                                        <td width="200px">{label name=delivery_city}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                        <td>{input name='delivery_city' class=$validators }</td>
                                    </tr>
                                    <tr>
                                        <td>{label name=delivery_index}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                                        <td>{input name='delivery_index' class=$validators }</td>
                                    </tr>
                                </table>
                                {foreach from=$errors_transport item=error key=k}
                                    {if $el_name == $k}
                                        <span class="error">{$error}</span><br>
                                    {/if}
                                {/foreach}
                            {/if}
                            <button id="delivery">Добавить</button><br>
                        </td>
                    </tr>
                {elseif $transport_req_elem.name == 'cost'}
                    <tr>
                        <td width="200px">{label name=$transport_req_elem.name}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                        <td>
                            {foreach from=$errors_transport item=error key=key}
                                {if $transport_req_elem.name == $key}
                                    <span class="error">{$error}</span><br>
                                {/if}
                            {/foreach}
                            {input name=$transport_req_elem.name class=$transport_req_elem.name }
                {elseif $transport_req_elem.name == 'currency'}
                            {input name=$transport_req_elem.name class=$transport_req_elem.name }
                        </td>
                    </tr>
                {elseif $transport_req_elem.name != 'loading_index' && $el_name!='loading_city' && $el_name!='loading_index' && $transport_req_elem.name != 'delivery_index' && $el_name!='delivery_city' && $el_name!='delivery_index' && $transport_req_elem.name != 'currency' && $transport_req_elem.name != 'cost'}
                    {assign var="validators" value="validate["}
                    {if $transport_req_elem.req}
                        {assign var="validators" value=$validators|cat:"required"}
                    {/if}
                    {assign var="validators" value=$validators|cat:"]"}
                    <tr>
                        <td width="200px">{label name=$transport_req_elem.name}{if $transport_req_elem.req}<span style="color: red;">*</span>{/if}: </td>
                        <td>
                            {foreach from=$errors_transport item=error key=key}
                                {if $transport_req_elem.name == $key}
                                    <span class="error">{$error}</span><br>
                                {/if}
                            {/foreach}
                                {input name=$transport_req_elem.name class=$validators }
                        </td>
                    </tr>
                {/if}

            {/foreach}
            <tr>
                <td width="200px"></td>
                <td style="padding-top: 20px;font-size: 13px;">
                    <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
                </td>
            </tr>
            <tr>
                <td width="200px"></td>
                <td style="padding-top: 20px;">
                    <div class="add_buttons">
                        <input type="submit" name='transport_form' class="order_button orange_button" value="отправить заявку">
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
    {/if}
{/if}
</div>
