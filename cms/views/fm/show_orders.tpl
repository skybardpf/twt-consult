{loadview name="actions/show"}
{if $order_content_data}
    <b>Содержимое заказа</b>
    <br /><br />
    <table class="pages listTable">
    <tr class="pages-head">
    {foreach from=$order_content_titles item=ru_field key=en_field}
        <th style="border-right:1px solid #003A91;">{$ru_field}</th>
    {/foreach}
        <th style="border-right:1px solid #003A91;">Цена</th>
        <th>Стоимость</th>
        <th>Цена со скидкой ({$discount}%)</th>
        <th>Стоимость со скидкой ({$discount}%)</th>
    </tr>
    {foreach from=$order_content_data item=row key=key name=list}
        <tr class="m-item-center" {if $smarty.foreach.list.iteration%2==0}style="background-color:#e4e4e4;"{/if}>
        {foreach from=$order_content_titles item=ru_field key=en_field}
            <td>
                {if $order_content_fields.$en_field.values}
                    {assign var="curr" value=$row.$en_field}
                    {$order_content_fields.$en_field.values.$curr}
                {else}
                    {$row.$en_field}
                {/if}
            </td>
        {/foreach}
        <td>{$data.content.$key.price_of_one} р.</td>
        <td>{$data.content.$key.price_of_stack} р.</td>
        <td>{math equation="price*(100 - discount)/100" price=$data.content.$key.price_of_one discount=$discount} р.</td>
        <td>{math equation="price*(100 - discount)/100" price=$data.content.$key.price_of_stack discount=$discount} р.</td>
        </tr>
    {/foreach}
    </table>
    <br /><br />
    <p style="font-weight:bold;font-size:14px;">Итого &mdash; {$data.total} р.</p>
    <p style="font-weight:bold;font-size:14px;">Итого со скидкой &mdash; {math equation="total*(100 - discount)/100" total=$data.total discount=$discount} р.</p>
{/if}