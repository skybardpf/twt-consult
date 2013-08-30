<table>
{* Выбор заголовков по realtor_action - действие риэлтора над объектом*}
    {if $data.realtor_action eq 'mod'}
        <tr><td></td>
        <td><h1>Было</h1></td>
        <td><h1>Стало</h1></td>
        </tr> 
    {elseif $data.realtor_action eq 'new'}
        <tr><td></td>
        <td><h1>На добавление</h1></td> 
        </tr>
    {elseif $data.realtor_action eq 'del'}
        <tr><td></td>
        <td><h1>На удаление</h1></td> 
        </tr>
    {/if}

    {foreach from=$titles key=field item=value} 
        {*Поле объекта - массив значений*}
        {if is_array($value)}
            {foreach from=$value key=field2 item=title}
                {*Если изменение - отображать два объетка*}
                {if $data.realtor_action eq 'mod'}
                    {if isset($object.$field.$field2)}
                        <tr {if $object_old.$field.$field2 != $object.$field.$field2} style="background-color: red;" {/if}>
                        <td>{$title}</td>
                        <td>{cur arr=$object_old.$field.$field2}</td>
                        <td>{cur arr=$object.$field.$field2}</td>
                        </tr>
                    {/if}
                {*Иначе - один*}
                {else}
                    {if isset($object.$field.$field2)}
                        <tr>
                        <td>{$title}</td>
                        <td>{cur arr=$object.$field.$field2}</td>
                        </tr>
                    {/if}
                {/if}
            {/foreach}
        {*Просто значение*}
        {else}
            {*Если изменение - отображать два объетка*}
            {if $data.realtor_action eq 'mod'}
                <tr {if $object_old.$field != $object.$field}style="background-color: red;" {/if}>
                <td>{$value}</td>
                    {if $fields.$field.values}
                        {assign var="arrKey" value=$object_old.$field}
                        <td>{$fields[$field].values[$arrKey]}</td>
                        {assign var="arrKey" value=$object.$field}
                        <td>{$fields[$field].values[$arrKey]}</td>
                    {else}
                        <td>{$object_old.$field}</td>
                        <td>{$object.$field}</td>
                    {/if}
                </tr>
            {*Иначе - один*}
            {else}
                <tr>
                <td>{$value}</td>
                {if $fields.$field.values}
                        {assign var="arrKey" value=$object.$field}
                        <td>{$fields[$field].values[$arrKey]}</td>
                    {else}
                        <td>{$object.$field}</td>
                {/if}
                </tr>
            {/if}
        {/if}
    {/foreach}
{*Кнопочки принять и отклонить*}
    <tr></tr>
    <tr>
        <td></td>
        <td><a href="{$root_url}moderation/accept/id/{$object.id}{if $data.realtor_action eq 'del'}/type/old/{else}/type/mod/{/if}" title="Принять">Принять</a>&nbsp&nbsp&nbsp
        <a id="button_for_comment" href="{$root_url}moderation/deny/id/{$object.id}{if $data.realtor_action eq 'del'}/type/old/{else}/type/mod/{/if}" title="Отказать">Отказать</a></td>
    </tr>
    </table> 
<br />
{*Форма комментария при отказе*}
<div id = "comment_form">
   {form name='deny_form'}
        {foreach from=$forms_elements.deny_form item=element}
            {label name=$element.name}
            {input name=$element.name}
        {/foreach}
   {closeformgroup}
   <input type="submit" value="Сохранить отказ." style="width: 100%;">
   </form>
</div>