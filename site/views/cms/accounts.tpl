{if $acc_data}
    <h1>Счета</h1>
	<table class="listTableTop">
    {foreach from=$acc_data item=ad}
        <tr>
        {foreach from=$acc_titles key=fi item=val}
                <th align="left" valign="top">{$val}</th>
                <td>
                    {if $acc_fields.$fi.values}
                        {assign var="key" value=$ad.$fi}
                            {$acc_fields.$fi.values.$key}
                    {/if}
                </td>
        {/foreach}
        </tr>
    {/foreach}
    </table>
{/if}
