{if $items}
<table style="width:100%;" class="pages listTable">
    <tr class="pages-head">
            <th class="pos" style="width:1%;"></th>
        {foreach from=$titles item=columnTitle key=key}
            <th><span style="display:block; float:left;">{putsort field=$key}</span>{$columnTitle}</th>
        {/foreach}
            <th>Содержимое склада</th>
            <th class="del"></th>
    </tr>
    <tbody class="data">
    {foreach from=$items item=row name="list"}
    <tr class="m-item-center" {if $smarty.foreach.list.iteration%2==0}style="background-color:#e4e4e4;"{/if} id="row_{$row.id}">
        
        <td class="pos">
            {if $usePos}
                <a href="{if $posUp}{$posUp}{else}{$sLink}pos/up/id/{$row.id}/{/if}"><img src="/public/cms/img/icons/arrow_up-active.png" /></a>
                <a href="{if $posDown}{$posDown}{else}{$sLink}pos/down/id/{$row.id}/{/if}"><img src="/public/cms/img/icons/arrow_down-active.png" /></a>
            {/if}
        </td>
        {foreach from=$titles item=columnTitle key=key name=items}
            <td>
                {if $fields.$key.values}
                    {assign var="arrKey" value=$row.$key}
                    {$fields[$key].values[$arrKey]}
                {elseif $fields.$key.type eq "pass"}
                    *****
                {elseif is_array($row.$key)}
                    {foreach from=$row.$key item=field_value name=field_values}
                        {$field_value.title|default:$field_value.name}{if !$smarty.foreach.field_values.last}, {/if}
                    {foreachelse}
                        {$fields.$key.empty|default:"не задано"}
                    {/foreach}
                {elseif $fields.$key.type eq 'date'}
                    {$row.$key|date_format:"%d.%m.%Y"}
                {elseif $fields.$key.type eq 'datetime'}
                    {$row.$key|date_format:"%d.%m.%Y %H:%M"}
                {else}
                    {call name="get_listing_value" item=$row key=$key}{$row.$key}{/call}
                {/if}
                
                {if !empty($list_actions.inline.$key.title)}
                    </a>
                {/if}
                {if $list_actions.inline.$key.put.pos eq "after"}
                    <a title="{$list_actions.inline.$key.put.title}" href="{$root_url}{$list_actions.inline.$key.put.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[model]':$request.model}/">{if $list_actions.inline.$key.put.icon}<img alt="{$list_actions.inline.$key.put.title}" src="/public/cms/img/icons/{$list_actions.inline.$key.put.icon}.png" />{else}{$list_actions.inline.$key.put.title}{/if}</a>
                {/if}
            </td>
        {/foreach}
        {if $row.content}
            <td>
                {foreach from=$row.content item=inner}
                    {assign var="arrKey" value=$inner.film_id}
                    <b>{$remains_fields.film_id.values[$arrKey]}:</b> {$inner.amount}<br />
                {/foreach}
            </td>
            <th class="del"></th>
        {else}
            <td>
                Пустой
            </td>
            <th class="del"><a href="/admin/fma/delete_warehouse/id/{$row.id}/"><img src="/public/cms/img/icons/delete.png" alt="Удалить"></a></th>
        {/if}
    </tr>
    {/foreach}
    </tbody>
</table>
{else}
{$noContent}
<br /><br />
{/if}


{if $paging.pages}
<div class="{$paging.css_class}">
{sliding_pager
    url_append = $paging.url_append 
    separator  = $paging.separator
    curpage    = $paging.curr_page
    baseurl    = $paging.base_url
    pagecount  = $paging.pages
    txt_first  = $paging.first       txt_prev = $paging.prev
    txt_next   = $paging.next        txt_last = $paging.last
    txt_skip   = $paging.skip        linknum  = $paging.linkcount
}
</div>
{/if}