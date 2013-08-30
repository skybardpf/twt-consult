{if $items}
<table style="width:100%;" class="pages listTable">
    <tr class="pages-head">
            <th class="pos" style="width:1%;"></th>
        {foreach from=$titles item=columnTitle key=key}
            {if $key neq 'type_default_value'}
            <th {if $key eq 'product'}style="width: 20pt;" {$key}{/if}><span style="display:block; float:left;">{putsort field=$key}</span>{$columnTitle}</th>
            {/if}
        {/foreach}
        {if $delete}
            <th class="del"></th>
        {/if}
    </tr>
    <tr>
        <td class="pos" style="width:1%;"></td>
        {foreach from=$titles item=columnTitle key=field}
        <td>
            <span>
                {if $fields[$field].values}
                <select name="sort[{$field}]" class="sort_field">
                    <option value="">не выбранно</option>
                    {foreach from=$fields[$field].values key=v item=n}
                    	<option value="{$v}" {if $v==$request.post.sort.$field}selected="selected"{/if}>{$n}</option>
                    {/foreach}
                </select>
                {else}
                	<input type="text" name="sort[{$field}]" value="{$request.post.sort.$field}" class="sort_field">
                {/if}
            </span>
        </td>
        {/foreach}
        {if $delete}
            <th class="del"></th>
        {/if}
    </tr>
    <tbody class="data">
    {foreach from=$items item=row name="list"}
    <tr class="m-item-center" {if $smarty.foreach.list.iteration%2==0}style="background-color:#e4e4e4;"{/if} id="row_{$row.id}">
        
        <td class="pos">
            {if $usePos}
                <a href="{if $posUp}{$posUp}{else}{$sLink}pos/up/id/{$row.id}/{/if}"><img src="/public/cms/img/icons/uparrow-green.png" /></a>
                <a href="{if $posDown}{$posDown}{else}{$sLink}pos/down/id/{$row.id}/{/if}"><img src="/public/cms/img/icons/downarrow-green.png" /></a>
            {/if}
        </td>
        {foreach from=$titles item=columnTitle key=key name=items}
            <td {if $key}{$key}{/if}>
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
                    
                    {if is_array($list_actions.inline.$key.class)}
                        {assign var="aClassArr" value=$list_actions.inline.$key.class}
                        {assign var="rKey" value=$row.$key}
                        {assign var="aClass" value=$aClassArr.$rKey}
                    {elseif $list_actions.inline.$key.class}
                        {assign var="aClass" value=$list_actions.inline.$key.class}
                    {else}
                    	{assign var="aClass" value=""}
                    {/if}
                    
                    <a{if $aClass} class="{$aClass}"{/if} title="{$aTitle}" href="{$root_url}{$list_actions.inline.$key.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[model]':$request.model}/">
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
                {elseif $fields.$key.type eq 'image' AND $row.$key}
                    <img src="{$row.$key|replace:"[dir]":"icon"}" />
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
    {foreach from=$list_actions.after item=action}
    	<table class="after_actions">
            <tr>
                <td class="left">
                </td>
                <td class="center">
                <a href="{$root_url}{$action.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[link]':$request.link}/" title="{$action.title}">{$action.title}</a>
                </td>
                <td class="right">
                </td>
            </tr>
        </table>
    {/foreach}
{/if}

<br /><br />

{if $deleted_items}
<table class="listTable">
    <tr>
        <th class="pos"></th>
        {foreach from=$deleted_titles item=title}
            <th>{$title}</th>
        {/foreach}
        <th class="del"></th>
    </tr>
    {foreach from=$deleted_items item=row}
        <tr>
            <th class="pos"></th>
            {foreach from=$row item=item key=key}
                {if $key neq 'id'}
                    <td>{$item}</td>
                {/if}
            {/foreach}
            <th class="del"><a href="/admin/fm/revert/id/{$row.id}">Восстановаить</a></th>
        </tr>
    {/foreach}
</table>
{/if}