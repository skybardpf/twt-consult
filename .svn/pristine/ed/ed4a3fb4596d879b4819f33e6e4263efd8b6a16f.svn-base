<div class="breadcrumbs">
    {foreach from=$bread_crumbs item=m name=bc key=key}
        {if $key == ""}
        <em>{$m}</em>{if !$smarty.foreach.bc.last} / {/if}
            {else}

        <a {if !in_array($key, array('/orders/', '/works/'))}href="{$key}"{/if}>{$m}</a>{if !$smarty.foreach.bc.last} / {/if}

        {/if}
    {/foreach}
</div>