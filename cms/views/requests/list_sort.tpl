{if !$up}<a href="{$sLink}sort/{$field}/dir/1/" title="Сортировать по возрастанию">{else}<a href="{$sLink}" title="Отменить сортировку">{/if}<img src="/public/cms/img/icons/arrow_up{if $up}-active{/if}.png" /></a>

{if !$down}<a href="{$sLink}sort/{$field}/dir/0/" title="Сортировать по убыванию">{else}<a href="{$sLink}" title="Отменить сортировку">{/if}<img src="/public/cms/img/icons/arrow_down{if $down}-active{/if}.png" /></a>

