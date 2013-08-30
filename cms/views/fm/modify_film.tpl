{if $top_content}
{$top_content}
<br /><br />
{/if}

{if $errors}
{loadview name="page/errors"}
{/if}
{form name='modify'}
{*if $suppl}<div style="text-align: right;">{$suppl}</a></div><br />{/if*}
{loadview name="page/buttons"}
<br /><br />
{foreach from=$forms_elements.modify item=element}
    {if $element.req}* {/if}{label name=$element.name}
    {input name=$element.name}
{/foreach}
{closeformgroup}
{$more}
<br /><br />
{loadview name="page/buttons"}
</form>

{if $price_history_data}
    <br /><b>Цены</b><br /><br />
    <div style="margin-left: 40px; width: 50%;">
    <table class="listTable">
        <tr>
            <th>Дата</th>
            <th>Цена</th>
            <th>Цена закупки </th>
            <th>Закупочная цена в валюте поставщика </th>
        </tr>
        {assign var="date_now" value=$smarty.now}
        {foreach from=$price_history_data item=object key=date}
            {assign var="retail_price_real" value=0}
            {assign var="purchase_price_real" value=0}
            {assign var="purchase_price_supplier_real" value=0}            
            
            {foreach from=$object item=price}
                {if $price.price_type eq "retail_price"}
                    {assign var="retail_price" value=$price.price}
                    {assign var="retail_price_id" value=$price.id}
                    {assign var="retail_price_real" value=1}
                {/if}
                
                {if $price.price_type eq "purchase_price"}
                    {assign var="purchase_price" value=$price.price}
                    {assign var="purchase_price_id" value=$price.id}
                    {assign var="purchase_price_real" value=1}
                {/if}
                
                {if $price.price_type eq "purchase_price_supplier"}
                    {assign var="purchase_price_supplier" value=$price.price}
                    {assign var="purchase_price_supplier_id" value=$price.id}
                    {assign var="purchase_price_supplier_real" value=1}
                {/if}
                
            {/foreach}
            <tr>
                {if $date|strtotime lte $date_now}
                    {assign var="curr_retail_price" value=$retail_price}
                    {assign var="curr_retail_price_id" value=$retail_price_id}
                    {assign var="curr_purchase_price" value=$purchase_price}
                    {assign var="curr_purchase_price_id" value=$purchase_price_id}
                    {assign var="curr_purchase_price_supplier" value=$purchase_price_supplier}
                    {assign var="curr_purchase_price_supplier_id" value=$purchase_price_supplier_id}
                {/if}
                <td>
                    {$date|date_format:"%d %B %Y"|replace:'January':'Января'|replace:'February':'Февраля'|replace:'March':'Марта'|replace:'April':'Апреля'|replace:'May':'Мая'|replace:'June':'Июня'|replace:'July':'Июля'|replace:'August':'Августа'|replace:'September':'Сентября'|replace:'October':'Октября'|replace:'November':'Ноября'|replace:'December':'Декабря'}
                </td>
                <td>{$retail_price}
                    {if $date|strtotime gte $date_now}
                        <a href="{$root_url}{$ctrlName}/modify_future_price/pid/{$id}/type/retail_price/id/{$retail_price_id}/date/{$date}/">
                            <img style="float: right;" src="/public/cms/img/icons/edit.png" alt="">
                        </a>
                        {if $retail_price_real}
                            <a href="{$root_url}{$ctrlName}/delete_price/id/{$retail_price_id}/">
                                <img style="float: right;" src="/public/cms/img/icons/delete.png" alt="">
                            </a>
                        {/if}
                    {/if}
                </td>
                <td>{$purchase_price}
                    {if $date|strtotime gte $date_now}
                        <a href="{$root_url}{$ctrlName}/modify_future_price/pid/{$id}/type/purchase_price/id/{$purchase_price_id}/date/{$date}/">
                            <img style="float: right;" src="/public/cms/img/icons/edit.png" alt="">
                        </a>
                        {if $purchase_price_real}
                            <a href="{$root_url}{$ctrlName}/delete_price/id/{$purchase_price_id}/">
                                <img style="float: right;" src="/public/cms/img/icons/delete.png" alt="">
                            </a>
                        {/if}    
                    {/if}
                </td>
                <td>{$purchase_price_supplier}
                    {if $date|strtotime gte $date_now}
                        <a href="{$root_url}{$ctrlName}/modify_future_price/pid/{$id}/type/purchase_price_supplier/id/{$purchase_price_supplier_id}/date/{$date}/">
                            <img style="float: right;" src="/public/cms/img/icons/edit.png" alt="">
                        </a>
                        {if $purchase_price_supplier_real}
                            <a href="{$root_url}{$ctrlName}/delete_price/id/{$purchase_price_supplier_id}/">
                                <img style="float: right;" src="/public/cms/img/icons/delete.png" alt="">
                            </a>
                        {/if}
                    {/if}
                </td>
            </tr>
        {/foreach}
    </table>
    </div>
    <br />
    <b>Текущие цены:</b><br /><br />
    <div style="margin-left: 40px; width: 50%;">
    <table class="listTable" style="width: 60%;">
        <tr>
            <td>Розничная цена</td>
            <td>{$curr_retail_price}</td>
            <td class="del"><a href="{$root_url}{$ctrlName}/modify_price/pid/{$id}/type/retail_price/id/{$curr_retail_price_id}/"><img src="/public/cms/img/icons/edit.png" alt=""></a></td>
        </tr>
        <tr>
            <td>Цена закупки</td>
            <td>{$curr_purchase_price}</td>
            <td class="del"><a href="{$root_url}{$ctrlName}/modify_price/pid/{$id}/type/purchase_price/id/{$curr_purchase_price_id}/"><img src="/public/cms/img/icons/edit.png" alt=""></a></td>
        </tr>
        <tr>
            <td>Закупочная цена в валюте поставщика</td>
            <td>{$curr_purchase_price_supplier}</td>
            <td class="del"><a href="{$root_url}{$ctrlName}/modify_price/pid/{$id}/type/purchase_price_supplier/id/{$curr_purchase_price_supplier_id}/"><img src="/public/cms/img/icons/edit.png" alt=""></a></td>
        </tr>
    </table>
    </div>
    <a href="{$root_url}{$ctrlName}/add_future_price/pid/{$id}/">Добавить цену на будущее</a><br />
{/if}