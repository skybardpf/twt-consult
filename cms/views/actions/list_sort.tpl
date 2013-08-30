<span class="sort_arrows">
{if !$up}<a href="{$sLink}sort/{$field}/dir/1/{$eLink}" title="Сортировать по возрастанию">{else}<a href="{$sLink}{$eLink}" title="Отменить сортировку">{/if}<img src="/public/cms/img/icons/arrow_up{if $up}-active{/if}.png" style="float: none;"/></a>
{if !$down}<a href="{$sLink}sort/{$field}/dir/0/{$eLink}" title="Сортировать по убыванию">{else}<a href="{$sLink}{$eLink}" title="Отменить сортировку">{/if}<img src="/public/cms/img/icons/arrow_down{if $down}-active{/if}.png" style="float: none;"/></a>
</span>
<!--<span class="sort_btn">
	<a href="#" title="Фильтр"><img src="/public/cms/img/icons/filter.png" /></a>
</span>-->