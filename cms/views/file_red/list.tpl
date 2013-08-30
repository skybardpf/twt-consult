{if $files_list}
<table>
    {foreach from=$files_list key=file_alt item=item}
    <tr>
        <td width="30"><a href="{$root_url}file_red/modify/id/{$file_alt}/" title="{$modify_title}"><img src="/public/cms/img/icons/_edit.png"></a></td>
        <td><a href="{$root_url}file_red/show/id/{$file_alt}/" title="{$show_title}">{$item.title}</a></td>
    </tr>
    {/foreach}
</table>
{else}

{/if}