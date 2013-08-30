{loadview name="actions/show"}
<table class="listTable" style="width: 40%; margin-left: 0pt;">
    <tr>
        <th>Наименование</th>
        <th>Количество</th>
    </tr>
    {foreach from=$trans_cont_items item=inner}
        <tr>
            {assign var="arrKey" value=$inner.film_id}
            <td><b>{$trans_cont_fields.film_id.values[$arrKey]}:</b></td>
            <td>{$inner.amount}</td>
        </tr>
    {/foreach}
</table>
<br /><br />