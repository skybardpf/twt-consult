{if $type_counts}<ul>
    {foreach from=$type_counts item=counter key=obj}
        <li style="margin-bottom: 10px;">
        {if $obj eq 1} <a href="{$root_url}moderation/list/type/1/">Квартиры</a>
            {foreach from=$counter item=quant key=type}
                {if $type eq 'lease'} на <a href="{$root_url}moderation/list/type/1/pid/lease/">аренду</a>: {$quant}
                {elseif $type eq 'sale'} на <a href="{$root_url}moderation/list/type/1/pid/sale/">продажу</a>: {$quant}
                {/if}
            {/foreach}
        {elseif $obj eq 2} <a href="{$root_url}moderation/list/type/2/">Коммерческая недвижимость</a>
            {foreach from=$counter item=quant key=type}
                {if $type eq 'lease'} на <a href="{$root_url}moderation/list/type/2/pid/lease/">аренду</a>: {$quant}
                {elseif $type eq 'sale'} на <a href="{$root_url}moderation/list/type/2/pid/sale/">продажу</a>: {$quant}
                {/if}
            {/foreach}
        {elseif $obj eq 3} <a href="{$root_url}moderation/list/type/3/">Загородная недвижимость</a> 
            {foreach from=$counter item=quant key=type}
                {if $type eq 'lease'} на <a href="{$root_url}moderation/list/type/3/pid/lease/">аренду</a>: {$quant}
                {elseif $type eq 'sale'} на <a href="{$root_url}moderation/list/type/3/pid/sale/">продажу</a>: {$quant}
                {/if}
            {/foreach}
        {/if}
        </li>
    {/foreach}
{else}
    Объектов на премодерацию нету.
{/if}
</ul>