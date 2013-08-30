{if $request.pid}
Действия над категорией: <a href="{$root_url}{$ctrlName}/add/pid/{$request.pid}/" title="Добавить подкатегорию"><img
	alt="Добавить подкатегорию" src="/public/cms/img/icons/add.png" style="margin-bottom: -4px; margin-right: 4px;"></a><a href="{$root_url}{$ctrlName}/modify/id/{$request.pid}/" title="Редактировать"><img
	alt="Редактировать" src="/public/cms/img/icons/edit.png" style="margin-bottom: -4px; margin-right: 4px;"></a><a href="{$root_url}{$ctrlName}/delete/id/{$request.pid}/" title="Удалить"><img
	alt="Удалить" src="/public/cms/img/icons/delete.png" style="margin-bottom: -4px; margin-right: 4px;"></a><a href="{$root_url}images/list/model/catalog_tree/pid/{$request.pid}/" title="Фотогалерея"><img
	alt="Фотогалерея" src="/public/cms/img/icons/gallery.gif" style="margin-bottom: -4px; margin-right: 4px;"></a>
<a href="{$root_url}{$ctrlName}/puzzle/pid/{$request.pid}/" title="Пазл"><img
	alt="Фотогалерея" src="/public/cms/img/icons/arrow_compass.gif" style="margin-bottom: -4px; margin-right: 4px;"
></a>
<br><br><br>

{if $items}
<form action="{$root_url}{$ctrlName}/move/pid/{$request.pid}/" method="post">
<table class="listTable">
    <tr>
            <th class="pos"></th>
        {foreach from=$titles item=columnTitle key=key}
            <th><span style="float: right;">{putsort field=$key}</span>{$columnTitle}</th>
        {/foreach}
        {if $delete}
            <th class="del"></th>
        {/if}
    </tr>
    <tbody class='data'>
    {foreach from=$items item=row name="list"}
    <tr class="{if $smarty.foreach.list.index % 2 eq 1}odd{/if}{if $row.id eq $request.id} hightlight{/if}" id="row_{$row.id}">
        
        <td class="pos">
            {if $usePos}
            	<input type="checkbox" name="item4order[]" value="{$row.id}">
            {/if}
        </td>
        {foreach from=$titles item=columnTitle key=key name=items}
            <td>
                {if $list_actions.inline.$key.put.pos eq "before"}
                    <a title="{$list_actions.inline.$key.put.title}"
						href="{$root_url}{$list_actions.inline.$key.put.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[model]':$request.model}/">
						{if $list_actions.inline.$key.put.icon}
							<img alt="{$list_actions.inline.$key.put.title}"
								src="/public/cms/img/icons/{$list_actions.inline.$key.put.icon}.png"
								style="float: left; margin-right: 4px;"/>
						{else}
							{$list_actions.inline.$key.put.title}
						{/if}
					</a>
                {/if}
                {if !empty($list_actions.inline.$key.title)}
                    {if is_array($list_actions.inline.$key.title)}
                        {assign var="aTitleArr" value=$list_actions.inline.$key.title}
                        {assign var="rKey" value=$row.$key}
                        {assign var="aTitle" value=$aTitleArr.$rKey}
                    {else}
                        {assign var="aTitle" value=$list_actions.inline.$key.title}
                    {/if}
                    <a title="{$aTitle}" href="{$root_url}{$list_actions.inline.$key.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[model]':$request.model}/">
                {/if}
                
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
                {elseif $fields.$key.type eq 'file'}
                	{if $row.$key eq ''}
                		файл не загружен
                	{else}
                    	<a href="{$row.$key}">открыть</a>
                    {/if}
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
        {if $rightFromTable}
            <td class="del">
            
                {foreach from=$rightFromTable key=rKey item=rItem}
                    {if (strpos($rKey, 'delete') !== 0 OR $row.undeletable ne 'yes')}
                        {check_cond action=$rItem item=$row}
                        <a href="{$root_url}{$rItem.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[model]':$request.model}/" title="{$rItem.title}"><img src="/public/cms/img/icons/{$rItem.icon}.png" alt="{$rItem.title}" /></a>
                        {/check_cond}
                    {/if}
                {/foreach}
            </th>
        {/if}
    </tr>
    {/foreach}
    </tbody>
</table>
<input type="submit" name="to_top" value="Перенести наверх">
{*<input type="submit" name="to_replaced" value="Перенести перед перенесенными">*}
</form>
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


{if $list_actions.after}
    <ul class="after_actions">
    {foreach from=$list_actions.after item=action}
        <li><a href="{$root_url}{$action.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[link]':$request.link}/" title="{$action.title}">{$action.title}</a></li>
    {/foreach}
    </ul>
{/if}
{else}
Выберите категорию.
{/if}