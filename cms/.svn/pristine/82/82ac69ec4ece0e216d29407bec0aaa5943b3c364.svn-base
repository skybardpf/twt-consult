{if $panelTitle}
<h4>{$panelTitle}</h4>
{/if}
{foreach from=$panelItems item=pItem}
<hr>
    <div class="treeelement m-item" style="padding-left: {if $branch}{math equation='x*7+20' x=$branch.level}{else}20{/if}px; background-position: {if $branch}{math equation='x*7' x=$branch.level}{else}0{/if}px;">
    {if $pItem.link}
        {if 
            ($panelCheck AND $panelCheck eq $pItem.check)
        OR
            (!$panelCheck AND strpos($pItem.link, $smarty.server.REQUEST_URI) !== false)
        }
            <span>{$pItem.title}</span>
        {else}
            <a href="{$root_url}{$ctrlName}/{$pItem.link}/">{$pItem.title}</a>
        {/if}
    {else}
        {if $request.pid eq $pItem.id}
            <span>{$pItem.title}</span>
        {else}
            <a href="{$root_url}{$ctrlName}/{$panelAction}/{$panelIdent|default:'pid'}/{$pItem.id}/">{$pItem.title}</a>
        {/if}
    {/if}
    </div>
{/foreach}