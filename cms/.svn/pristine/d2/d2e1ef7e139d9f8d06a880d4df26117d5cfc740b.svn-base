{if !$smarty.cookies.allTree}
<a href="{$root_url}{$ctrlName}/all_tree/on/">Включить фильтр</a>
{else}
<a href="{$root_url}{$ctrlName}/all_tree/off/">Все коллекции</a>
{/if}

{foreach from=$vTree item=node}
	<div class="treeelement" style="padding-left: {math equation='x*7' x=$node.level}px;">
        {if $node.level == 2}
            <a href="{$root_url}catalog/beggining/pos/up/id/{$node.id}/" title="Вверх" style="margin-left: 0px">
                <img align=left alt="Вверх" src="/public/cms/img/icons/arrow_up-active_beggining.png">
            </a>
        {/if}
		<a href="{$root_url}catalog/shift/pos/up/id/{$node.id}/" title="Вверх">
			<img align=left alt="Вверх" src="/public/cms/img/icons/arrow_up-active.png">
		</a>
		<a href="{$root_url}catalog/shift/pos/down/id/{$node.id}/" title="Вниз">
			<img align=left alt="Вниз" src="/public/cms/img/icons/arrow_down-active.png">
		</a>
		&nbsp;
		{if $node.id == $request.pid}
			<b>{$node.title|default:$node.id}</b>
		{else}
			<a href="{$root_url}catalog/list_goods/pid/{$node.id}/" title="Просмотреть">
				{$node.title|default:$node.id}
			</a>
		{/if}
	</div>
{/foreach}