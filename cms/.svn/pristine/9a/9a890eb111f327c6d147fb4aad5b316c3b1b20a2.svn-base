{$beforeShow}
{if $data}
<div class="showDiv">
	<table class="listTableTop">
	{foreach from=$titles key=field item=value}
		<tr>
			<th align="left" valign="top">{$value}</th>
			<td>
		{if $data.$field == ''}
				—
		{elseif $fields.$field.values}
			{if is_array($data.$field)}
				{foreach from=$data.$field item=key key=field_key name=field_values_virt}
					{if is_array($key) and array_key_exists($field_key, $fields.$field.values)}
                        {$fields.$field.values[$field_key]}{if !$smarty.foreach.field_values_virt.last},{/if}
                    {elseif !is_array($key) and array_key_exists($key, $fields.$field.values)}
                        {$fields.$field.values[$key]}{if !$smarty.foreach.field_values_virt.last},{/if}
					{elseif array_key_exists('value', $key) and array_key_exists($key.value, $fields.$field.values)}
						{$fields.$field.values[$key.value]}{if !$smarty.foreach.field_values_virt.last},{/if}
					{/if}

				{/foreach}
			{else}
                {assign var="key" value=$data.$field}
                {$fields.$field.values[$key]}
            {/if}
        {elseif $fields.$field.type eq "doublemultitext"}
        	{foreach from=$data.$field item=field_value name=field_values}
                {$field_value}
                {if ($smarty.foreach.field_values.index-1) % 2 eq 0}<br>{/if}
			{foreachelse}
                {$fields.$field.empty|default:"не задано"}
			{/foreach}
		{elseif $fields.$field.type eq "pass"}
                <a href="{$root_url}{$ctrlName}/change_pass/id/{$request.id}/" title="{$all_actions.change_pass.0}">*****</a>
		{elseif $fields.$field.type eq "image"}
            	{if $data.$field}
            	<a href="{$data.$field|replace:'[dir]':'original'}" target="_blank"><img src="{$data.$field|replace:'[dir]':'icon'}" alt="{$value}"></a>
            	{else}
            		—
            	{/if}
        {elseif $fields.$field.type eq "images"}
        		{foreach from=$data.$field item=image}
        			<a href="{$image.image|replace:'[dir]':'original'}" target="_blank"><img src="{$image.image|replace:'[dir]':'icon'}" alt="{$value}"></a>
        		{/foreach}
		{elseif $fields.$field.type eq "file"}
            	{if $data.$field}
            	<a href="{$data.$field}" target="_blank">Скачать</a>
            	{else}
            		—
            	{/if}
		{elseif $fields.$field.type eq "video"}
		{if $data.$field}
				<div id="mediaspace_{$field}"></div>
	            <script type="text/javascript">
					var so = new SWFObject('/public/zf/mediaplayer/player.swf','mpl','470','320','9');
					so.addParam('allowfullscreen','true');
					so.addParam('allowscriptaccess','always');
					so.addParam('wmode','opaque');
					so.addVariable('file','{$data.$field|replace:"[dir]":"low"|regex_replace:"|\..+$|":".flv"}');
					so.addVariable('image', '{$data.$field|replace:"[dir]":"preview"|regex_replace:"|\..+$|":".jpg"}');
					so.addVariable('plugins','hd-1,viral-2');
					so.addVariable('hd.file', '{$data.$field|replace:"[dir]":"high"|regex_replace:"|\..+$|":".mp4"}');
					so.addVariable('viral.allowmenu', 'true');
					so.addVariable('viral.onpause', 'false');
					so.addVariable('viral.oncomplete', 'true');
					so.write('mediaspace_{$field}');
	            </script>
		{/if}
		{elseif $field eq "videos" and is_array($data.$field)}
			{if $data.$field}
				{foreach from=$data.$field item=video name=video}
					<div id="mediaspace_{$field}_{$smarty.foreach.video.iteration}"></div>
		            <script type="text/javascript">
						var so = new SWFObject('/public/zf/mediaplayer/player.swf','mpl','470','320','9');
						so.addParam('allowfullscreen','true');
						so.addParam('allowscriptaccess','always');
						so.addParam('wmode','opaque');
						so.addVariable('file','{$video.video|replace:"[dir]":"low"|regex_replace:"|\..+$|":".flv"}');
						so.addVariable('image', '{$video.video|replace:"[dir]":"preview"|regex_replace:"|\..+$|":".jpg"}');
						so.addVariable('plugins','hd-1,viral-2');
						/* {if is_file($video.video|replace:"[dir]":"high"|regex_replace:"|\..+$|":".mp4")} */
						so.addVariable('hd.file', '{$video.video|replace:"[dir]":"high"|regex_replace:"|\..+$|":".mp4"}');
						/* {/if} */
						
						so.addVariable('viral.allowmenu', 'true');
						so.addVariable('viral.onpause', 'false');
						so.addVariable('viral.oncomplete', 'true');
						so.write('mediaspace_{$field}_{$smarty.foreach.video.iteration}');
		            </script>
		    	{/foreach}
			{/if}
		{elseif $fields.$field.type eq "audio"}
		{if $data.$field}
            	<div id="audioplayer_{$field}"></div>
            	<script type="text/javascript">
					AudioPlayer.embed('audioplayer_{$field}', {ldelim}soundFile: '{$data.$field|replace:"[dir]":"original"}'{rdelim});  
				</script>
		{/if}
		{elseif $fields.$field.type eq "images"}
			{foreach from=$data.$field item=field_value name=field_values}
                <a href="{$field_value|replace:'[dir]':'original'}" target="_blank"><img src="{$field_value|replace:'[dir]':'icon'}"></a>
			{foreachelse}
                {$fields.$field.empty|default:"не задано"}
			{/foreach}
		{elseif is_array($data.$field)}
			{foreach from=$data.$field item=field_value name=field_values}
                {assign var=title_field value=$fields[$field].title_field}
                {if is_array($field_value)}{$field_value.title|default:$field_value.name|default:$field_value[$title_field]}{else}{$field_value}{/if}
				{if !$smarty.foreach.field_values.last}, {/if}
			{foreachelse}
                {$fields.$field.empty|default:"не задано"}
			{/foreach}
		{elseif $fields.$field.type eq "datetime"}
				{$data.$field|date_format:'%d.%m.%Y %H:%M'}
		{elseif $fields.$field.type eq "date"}
				{$data.$field|date_format:'%d.%m.%Y'}
		{elseif $fields.$field.type eq "time"}
				{$data.$field|date_format:'%H:%M:%s'}
		{elseif $fields.$field.type eq 'float'}
                {$data.$field|number_format}
        {elseif $fields.$field.type eq 'mail'}
        	<a href="mailto:{$data.$field}">{$data.$field}</a>
		{else}
                {if $field == 'content'}
                	<div class="rc10">
                	{$data.$field}
                    </div>
                {else}
                	{$data.$field|nl2br}
                {/if}
		{/if}
        </td>
     </tr>
    {/foreach}
    </table>
</div>
    {if $request.parr[0] == 'show_incoming_invoice'}
<a href="{$root_url}{$ctrlName}/modify_incoming_invoice/id/{$request.id}/">Редактировать</a>
    {elseif $request.parr[0] == 'show_outgoing_invoice'}
<a href="{$root_url}{$ctrlName}/modify_outgoing_invoice/id/{$request.id}/">Редактировать</a>
    {elseif $ctrlName == 'contractors'}
<a href="{$root_url}{$ctrlName}/modify/id/{$request.id}/">Редактировать</a>
    {/if}
{/if}
{if $after_show}
    {$after_show}
{/if}
<br />