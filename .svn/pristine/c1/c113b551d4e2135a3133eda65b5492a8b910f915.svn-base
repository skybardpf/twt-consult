{if $loading_data}
    <h1>Пункты загрузки</h1>
	<table class="listTableTop">
    {foreach from=$loading_data item=ld}
        <tr>
            {foreach from=$loading_titles key=fi item=val}
                <th align="left" valign="top">{$val}</th>
                <td>
                    {$ld.$fi}
                </td>
            {/foreach}
        </tr>
    {/foreach}
    </table>
{/if}
{if $delivery_data}
<h1>Пункты доставки</h1>
<table class="listTableTop">
    {foreach from=$delivery_data item=dd}
        <tr>
            {foreach from=$delivery_titles key=fi item=val}
                <th align="left" valign="top">{$val}</th>
                <td>
                    {$dd.$fi}
                </td>
            {/foreach}
        </tr>
    {/foreach}
</table>
{/if}
