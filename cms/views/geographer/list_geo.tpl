{if $items}
    <table class="listTable">
        <tr>
        {foreach from=$titles item=title}
            <th>{$title}</th>
        {/foreach}
        {if $delete}
            <th class="del"></th>
        {/if}
        </tr>
        {foreach from=$items item=row key=key1}
            <tr>
                {foreach from=$row item=item key=key2}
                    <td>
                        {if $key2 eq 'name'}
                            <a href="/admin/geographer/mod_geo/id/{$key1}/type/meta" title="Редактировать этот Мета-тип"><img src="/public/cms/img/icons/edit.png" alt=""></a>{$item}
                        {else}    
                        {if $item eq 'yes'}да{elseif $item eq 'no'}нет{else}{$item}{/if}
                        {/if}
                    </td>
                {/foreach}
                <td class="del">
                    <a href="/admin/geographer/del_meta/id/{$key1}" title="Удалить Мету"><img src="/public/cms/img/icons/delete.png" alt=""></a>
                </td>
            </tr>
        {/foreach}
    <table>
{/if}
<a href="/admin/geographer/add_meta/" title="Добавить Мета-тип">Добавить Мета-тип</a>