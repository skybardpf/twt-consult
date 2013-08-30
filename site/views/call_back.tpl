{if $success}
    <div class="success_callback">
        <p>Ваша заявка принята.</p>
        <p>Благодарим Вас за обращение в нашу компанию.<br>
        Мы свяжемся с Вами в выбранное для звонка время.</p>
    </div>
{elseif $repeated}
    <div class="success_callback">
        Ваша заявка уже принята
    </div>
{else}
    {form name='callback' id='callback_form'}
        <div class="inputs">
        {foreach from=$forms_elements.callback item=callback_elem}

            {assign var="validators" value="validate["}
            {if $callback_elem.req}
                {assign var="validators" value=$validators|cat:"required"}
            {/if}
            {assign var="validators" value=$validators|cat:"]"}

                <div>{label name=$callback_elem.name}{if $callback_elem.req}<span style="color: red;">*</span>{/if}: </div>
                <div>
                    {foreach from=$calerrors item=error key=key}
                        {if $callback_elem.name == $key}
                            <span class="error">{$error}</span><br>
                        {/if}
                    {/foreach}
                    {input name=$callback_elem.name class=$validators }
                </div>

        {/foreach}
        </div>
    <div style="font-size: 12px; margin: 5px 0;">Все поля, отмеченные <span style="color: red;">*</span>, обязательны для заполнения.</div>
    <br>

    <script type="text/javascript">
        $('form img[class*=validate]').removeAttr('class');
    </script>

    <div class="add_buttons">
        <a href="#" onclick="yaCounter19010836.reachGoal('final_call_back'); return true;" class="order_button orange_button" id="final_call_back">Заказать</a>
        {*<input type="submit" class="order_button orange_button" value="заказать" style="float: right;margin-right: 78px;" id="final_call_back">*}
    </div>
        {closeformgroup}
    </form>
{/if}