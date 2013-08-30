{foreach from=$vTree item=branch}
<hr>
    <div class="treeelement m-item" style="padding-left: {math equation='x*7+20' x=$branch.level}px; background-position: {math equation='x*7' x=$branch.level}px;">
        {if $branch.id eq $request.pid}
            <b>{$branch.title}</b>
        {else}
            <a href="{$root_url}menu/list/pid/{$branch.id}/" title="Просмотреть">
                {$branch.title}
            </a>
        {/if}
    </div>
        {if $branch.count > 0}
            {loadview name="menu/tree" vTree=$branch.children}
        {/if}
{/foreach}