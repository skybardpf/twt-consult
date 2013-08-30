Нельзя удалить объект, так как есть еще следующие связи: <br/>
{if $conn}
    Связи вниз:<br/>
{/if}
{foreach from=$conn item=item key=key}
    <a href="/admin/geographer/mod_geo/id/{$key}/type/data">{$item}</a>
    <a href="/admin/geographer/del_data/id/{$key}" title="удалить данные"><img src="/public/cms/img/icons/delete.png" alt=""></a><br/>
{/foreach}