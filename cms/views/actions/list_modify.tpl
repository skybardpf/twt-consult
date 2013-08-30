<form action="" method="post">
{if $list_actions.after}
    {foreach from=$list_actions.after item=action}
        <table class="after_actions">
            <tr>
                <td class="left">
                </td>
                <td class="center">
                <a href="{$root_url}{$action.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[link]':$request.link|replace:'[type]':$request.type}/" title="{$action.title}">{$action.title}</a>
				</td>
				
                <td class="right">
                </td>
            </tr>
        </table>
    {/foreach}
	
	<div style="text-align: right;"> 
	<button type="submit">Сохранить изменения</button>
	</div>
	
{/if}
{if $items}
{if $list_actions.multiple}<form name="multiple" action="" method="post">{/if}
<table style="width:100%;" class="pages listTable">
    <tr class="pages-head">
        {if $list_actions.multiple}<th><input type="checkbox" name='' id="multiple_all"></th>{/if}
        <th class="pos" style="width:1%;"></th>
        {foreach from=$titles item=columnTitle key=key name=th}
            <th style='color:#000;font-weight:bold;text-align:left;{if !$smarty.foreach.th.last}border-right:1px solid #003A91;{/if}'>
            	<span style="display:block; float:left;">{putsort field=$key}</span> {$columnTitle} 
            </th>
        {/foreach}
        {if $delete}
            <th class="del"></th>
        {/if}
    </tr>
    <tr>
        {if $list_actions.multiple}<th></th>{/if}
        <td class="pos" style="width:1%;"></td>
        {foreach from=$titles item=columnTitle key=field}
        <td>
            <span>
                {if $fields[$field].values}
                <select name="sort[{$field}]" class="sort_field">
                    <option value="">не выбрано</option>
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
    <tbody class='data'>
    {foreach from=$items item=row name="list"}
    <tr class="m-item-center" {if $smarty.foreach.list.iteration%2==0}style="background-color:#e4e4e4;"{/if} id="row_{$row.id}">
        {if $list_actions.multiple}<td><input type="checkbox" name='multiple_items[]' class="multiple" value={$row.id}></td>{/if}
        <td class="pos">
            {if $usePos}
                <a href="{if $posUp}{$posUp}{else}{$sLink}pos/up/id/{$row.id}/{/if}"><img src="/public/cms/img/icons/uparrow-green.png" /></a>
                <a href="{if $posDown}{$posDown}{else}{$sLink}pos/down/id/{$row.id}/{/if}"><img src="/public/cms/img/icons/downarrow-green.png" /></a>
            {/if}
        </td>
        {foreach from=$titles item=columnTitle key=key name=items}
            <td>  
                {if !empty($list_actions.inline.$key.put) && empty($list_actions.inline.$key.put.pos)}
                    {foreach from=$list_actions.inline.$key.put item=mult_act}
                        <a title="{$mult_act.title}"
                            href="{$root_url}{$mult_act.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[model]':$request.model|replace:'[type]':$request.type}/">
                            {if $mult_act.icon}
                                <img alt="{$mult_act.title}"
                                    src="/public/cms/img/icons/{$mult_act.icon}.png"
                                    style="float: left; margin-right: 4px;"/>
                            {else}
                                {$mult_act.title}
                            {/if}
                        </a>
                    {/foreach}
                {elseif $list_actions.inline.$key.put.pos eq "before"}
                    <a title="{$list_actions.inline.$key.put.title}"
						href="{$root_url}{$list_actions.inline.$key.put.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[model]':$request.model|replace:'[type]':$request.type}/">
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
                    
                    <a{if $aClass} class="{$aClass}"{/if} title="{$aTitle}" href="{$root_url}{$list_actions.inline.$key.link|replace:"[id]":$row.id|replace:"[object_id]":$row.object_id|replace:"[type]":$row.type|replace:"[user_id]":$row.user_id|replace:"[pid]":$request.pid|replace:'[model]':$request.model|replace:'[type]':$request.type}/">
                {/if}
                
				{if $fields.$key.htmltype eq 'checkbox'}
					<select style="width: 60px;" name="{$key}[{$row.id}]">
						{foreach from=$fields.$key.values item=cap key=cval}
						<option value="{$cval}" {if $cval==$row.$key}selected{/if}>{$cap}</option>
						{/foreach}
					</select> 
				{elseif $fields.$key.htmltype eq 'select' && $fields.$key.values}
					<select style="width: 100px;" name="{$key}[{$row.id}]">
						{foreach from=$fields.$key.values item=cap key=cval}
						<option value="{$cval}" {if $cval==$row.$key}selected{/if}>{$cap}</option>
						{/foreach}
					</select> 
				
                {elseif $row.$key == ''}
                	— 
                {elseif $fields.$key.values}  
                    {assign var="arrKey" value=$row.$key} 
                    {$fields[$key].values[$arrKey]}
                {elseif $fields.$key.type eq "pass"}
                    *****
                {elseif $fields.$key.type eq "mail"}
                	<a href="mailto:{$row.$key}">{$row.$key}</a>
                {elseif is_array($row.$key)}  
                    {assign var=title_field_name value=$fields.$key.field_name}
                    {foreach from=$row.$key item=field_value name=field_values}
                        {$field_value.title|default:$field_value.name|default:$field_value.$title_field_name}{if !$smarty.foreach.field_values.last}{if $fields.$key.delim}{$fields.$key.delim}{else}, {/if}{/if}
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
               	{elseif ($fields.$key.type eq 'html' || $fields.$key.type eq 'ckhtml')}
               		{assign var="maxcharslength" value=$fields.$key.truncate|default:40}
               		{assign var="def_val" value=$row.$key|strip_tags:true}
               		{$def_val|cut:$maxcharslength:' ':'...':false}
                {elseif $fields.$key.type eq 'float'}  
                	{$row.$key|number_format}
                {elseif $fields.$key.type eq 'datetime'}
                	{call name="get_listing_value" item=$row key=$key}
                	{if $row.$key == null} 
                		не установлено 
                	{else}
                	    {$row.$key|date_format:"%d.%m.%Y %H:%M"}
                	{/if}
                	{/call}
                {elseif $fields.$key.type eq 'image' AND $row.$key}
                    <img src="{$row.$key|replace:"[dir]":"icon"}" /> 
                {elseif $fields.$key.type eq 'integer' AND $row.$key} 
                    <input style="width: 100px;" name="{$key}[{$row.id}]" type="text" value="{$row.$key}" />
                {else}
                   {call name="get_listing_value" item=$row key=$key}  
                   		{$row.$key}
                   {/call}
                {/if}
                
                {if !empty($list_actions.inline.$key.title)}
                    </a>
                {/if}
                {if $list_actions.inline.$key.put.pos eq "after"}
                    <a title="{$list_actions.inline.$key.put.title}" href="{$root_url}{$list_actions.inline.$key.put.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[model]':$request.model|replace:'[type]':$request.type}/">{if $list_actions.inline.$key.put.icon}<img alt="{$list_actions.inline.$key.put.title}" src="/public/cms/img/icons/{$list_actions.inline.$key.put.icon}.png" />{else}{$list_actions.inline.$key.put.title}{/if}</a>
                {/if}
            </td>
        {/foreach}
        {if $rightFromTable}
            <td class="del">
            
                {foreach from=$rightFromTable key=rKey item=rItem}
                    {if (strpos($rKey, 'delete') !== 0 OR $row.undeletable ne 'yes')}
                        {check_cond action=$rItem item=$row}
                        <a
                            href="{$root_url}{$rItem.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[model]':$request.model|replace:'[type]':$request.type}/"
                            {if $rItem.rel}rel="{$rItem.rel|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[model]':$request.model|replace:'[type]':$request.type}"{/if}
                            {if $rItem.onclick}onclick='{$rItem.onclick}'{/if}
                            title="{$rItem.title}">

                            <img src="/public/cms/img/icons/{$rItem.icon}.png" alt="{$rItem.title}" />
                        </a>
                        {/check_cond}
                    {/if}
                {/foreach}
            </th>
        {/if}
    </tr>
    {/foreach}
    </tbody>
</table>
{if $list_actions.multiple}
<table class="after_actions">
    <tr>
        {foreach from=$list_actions.multiple item=action name=multiple}
            <td class="left"></td>
            <td class="center">
                <a class='multiple' href="{$root_url}{$action.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[link]':$request.link|replace:'[type]':$request.type}/" title="{$action.title}">{$action.title}</a>
            </td>
            <td class="right"></td>
            {if !$smarty.foreach.multiple.last}<td width="20"></td>{/if}
        {/foreach}
    </tr>
</table>
</form>
{/if}
{else}
{$noContent}
<br /><br />
{/if}


<div class="{$paging.css_class|default:"pagging"}">
{sliding_pager
	url_append = $paging.url_append 
	separator  = $paging.separator
	curpage    = $paging.curr_page
	baseurl    = $paging.base_url
	pagecount  = $paging.pages       npps = $paging.npps
	txt_first  = $paging.first       txt_prev = $paging.prev
	txt_next   = $paging.next        txt_last = $paging.last
	txt_skip   = $paging.skip        linknum  = $paging.linkcount
}
</div>


{if $list_actions.after}
    {foreach from=$list_actions.after item=action}
    	<table class="after_actions">
            <tr>
                <td class="left">
                </td>
                <td class="center">
                <a href="{$root_url}{$action.link|replace:"[id]":$row.id|replace:"[pid]":$request.pid|replace:'[link]':$request.link|replace:'[type]':$request.type}/" title="{$action.title}">{$action.title}</a>
                </td>
                <td class="right">
                </td>
            </tr>
        </table>
    {/foreach}
{/if}

<div style="text-align: right;"> 
    <!--<input type="button" id="btnloading" value="В Excel">    -->
    <span id="loading" style="display:none;">загрузка ....</span>&nbsp;
	<button type="submit">Сохранить изменения</button>
	</div>
	
</form>	