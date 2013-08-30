{if $top_content}
{$top_content}
<br /><br />
{/if}
{if $data}
<div class="showDiv">
<table>
    {foreach from=$titles key=field item=value}
        {if is_array($value)}
        	{foreach from=$value key=field2 item=title}
        		{if isset($data.$field.$field2)}
	        	<tr>
        		<td><b>{$title}</b>:</td>
        		<td>{cur arr=$data.$field.$field2}</td>
        		</tr>
        		{/if}
        	{/foreach}
        {elseif $field neq 'images'}
        <tr>
        <td><b>{$value}</b>:</td>
        <td>
            {if $fields.$field.values}
                {assign var="key" value=$data.$field}
                {$fields.$field.values[$key]}
            {elseif $fields.$field.type eq "pass"}
                <a href="{$root_url}{$ctrlName}/change_pass/id/{$data.id}/" title="{$all_actions.change_pass.0}">*****</a>
            {elseif is_array($data.$field)}
                {foreach from=$data.$field item=field_value name=field_values}
                    {$field_value.title|default:$field_value.name}{if !$smarty.foreach.field_values.last}, {/if}
                {foreachelse}
                    {$fields.$field.empty|default:"не задано"}
                {/foreach}
            {else}
                {$data.$field}
            {/if}
        </td>
        {/if}
        </tr>
    {/foreach}
</table>
</div>
{/if}
<br /><br />