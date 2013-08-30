{foreach from=$vTree item=titem}
<a href="/admin/projects/modify/id/{$titem.id}" title="{$titem.title}"><img src="{$titem.photo}" alt=""/></a>
{/foreach}