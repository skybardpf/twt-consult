{if $data}
<div class="showDiv">
    {foreach from=$titles key=field item=value}
        <div>
        <b>{$value}</b>:
            {if $fields.$field.values}
                {assign var="key" value=$data.$field}
                {$fields.$field.values[$key]}
            {elseif $fields.$field.type eq "pass"}
                <a href="{$root_url}{$ctrlName}/change_pass/id/{$request.id}/" title="{$all_actions.change_pass.0}">*****</a>
            {elseif $fields.$field.type eq "image"}
            	{if $data.$field}
            	<img src="{$data.$field|replace:'[dir]':'icon'}" alt="{$value}">
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
            {elseif $fields.$field.type eq "audio"}
            {if $data.$field}
            	<div id="audioplayer_{$field}"></div>
            	<script type="text/javascript">
					AudioPlayer.embed('audioplayer_{$field}', {ldelim}soundFile: '{$data.$field|replace:"[dir]":"original"}'{rdelim});  
				</script>
			{/if}
            {elseif is_array($data.$field)}
                {foreach from=$data.$field item=field_value name=field_values}
                    {$field_value.title|default:$field_value.name}{if !$smarty.foreach.field_values.last}, {/if}
                {foreachelse}
                    {$fields.$field.empty|default:"не задано"}
                {/foreach}
            {else}
                {$data.$field}
            {/if}
            <br>
        </div>
        {if $field eq 'packing_z'}
        <div>
        {assign var="x" value=$data.packing_x}
        {assign var="y" value=$data.packing_y}
        {assign var="z" value=$data.packing_z}
        <b>Объем, м3</b>: {math equation="height * width * division / 1000000" height=$x width=$y division=$z}
        </div>
        {/if}
    {/foreach}
</div>
    {if $request.parr[0] == 'show_incoming_invoice'}
        <a href="{$root_url}{$ctrlName}/modify_incoming_invoice/id/{$request.id}/">Редактировать</a>
    {elseif $request.parr[0] == 'show_outgoing_invoice'}
        <a href="{$root_url}{$ctrlName}/modify_outgoing_invoice/id/{$request.id}/">Редактировать</a>
    {elseif $ctrlName == 'contractors'}
    	<a href="{$root_url}{$ctrlName}/modify/id/{$request.id}/">Редактировать</a>
    {/if}
{/if}
<br />