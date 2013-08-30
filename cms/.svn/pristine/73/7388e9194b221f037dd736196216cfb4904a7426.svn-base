{if $metas}
    <form name="add_data">
        <select name="Meta" onchange="this.form.submit();">
            {foreach from=$metas item=item key=key}
                <option 
                    {if $selected_meta && $selected_meta eq $key}
                        {assign var="sel_meta" value='true'}
                        selected
                    {else}
                        {if $sel_meta neq 'true'}
                            {assign var="sel_meta" value='false'}
                        {/if}
                    {/if}  value="{$key}">{$item.name}</option>
            {/foreach}
        </select> 
        {if $sel_meta eq 'true'}
            <a href="/admin/geographer/mod_geo/id/{$selected_meta}/type/meta"title="Редактировать этот Мета-тип"><img src="/public/cms/img/icons/edit.png" alt=""></a>
            <a href="/admin/geographer/add_meta/" title="Добавить Мета-тип"><img src="/public/cms/img/icons/add.png"></a>
        {/if}
    {if $datas}
        <br/>
        <select name="Data" onchange="this.form.submit();">
            <option value="null">Выберите</option>
            {foreach from=$datas item=item key=key}
                <option 
                    {if $selected_data && $selected_data eq $item.id}
                        {assign var="sel_data" value='true'}
                        selected
                    {else}
                        {if $sel_data neq 'true'}
                            {assign var="sel_data" value='false'}
                        {/if}
                    {/if} 
                value="{$item.id}">{$item.name}</option>
            {/foreach}
        </select>
        {if $sel_data eq 'true'}
            <a href="/admin/geographer/add_data/id/{$selected_data}" title="Добавить данные"><img src="/public/cms/img/icons/add.png" alt=""></a>
            <a href="/admin/geographer/del_data/id/{$selected_data}" title="удалить данные"><img src="/public/cms/img/icons/delete.png" alt=""></a>
            <a href="/admin/geographer/mod_geo/id/{$selected_data}/type/data" title="Редактировать данные"><img src="/public/cms/img/icons/edit.png" alt=""></a>
        {/if}
    {else}
    {/if}
    </form>
{else}
    Случилось страшное    
{/if}
