{if $data}
<div class="showDiv">
    {foreach from=$titles key=field item=value}
        <div>
        <b>{$value}</b>:
            {if $fields.$field.values}
                {assign var="key" value=$data.$field}
                {$fields.$field.values[$key]}
            {elseif $fields.$field.type eq "pass"}
                <a href="{$root_url}{$ctrlName}/change_pass/id/{$data.id}/" title="{$all_actions.change_pass.0}">*****</a>
            {elseif is_array($data.$field)}
                {foreach from=$data.$field item=field_value name=field_values}
                    {$field_value.title|default:$field_value.name}{if !$smarty.foreach.field_values.last}, {/if}
                {foreachelse}
                    {$fields.$field.empty|default:"не задано"}
                {/foreach}
            {else}
                {$data.$field}
            {/if}
            <br>
        </div>
    {/foreach}
</div>
{/if}
<br />
<a href="{$root_url}articles/">Назад</a>&nbsp&nbsp&nbsp
<a href="{$root_url}comments/add/type/articles/pid/{$id}/page/articles/item/{$id}">Комментировать</a>
<br /><br /><br />
<table>
{foreach from=$Comments item=node}
    {if $node.level != 0}
    <tr style="height: 25px;">
       <td>
        <div class="comments" style=" margin-left: {math equation='x*16' x=$node.level}px;" >
            <a href ="{$root_url}comments/modify/id/{$node.id}/page/articles/pid/{$id}">
                <img src="/public/cms/img/icons/edit.png" alt="Редактировать" align="left" title="Редактировать">
            </a>
            <a href ="{$root_url}comments/show/id/{$node.id}/page/articles/pid/{$id}">
                <img src="/public/cms/img/icons/show.png" alt="Посмотреть комментарий" align="left" title="Посмотреть комментарий">
            </a>
            <a href ="{$root_url}comments/delete/id/{$node.id}/page/articles/pid/{$id}">
                <img src="/public/cms/img/icons/delete.png" alt="Удалить комментарий" align="left" title="Удалить комментарий">
            </a>
            <a href ="{$root_url}comments/deleteall/id/{$node.id}/page/articles/pid/{$id}">
                <img src="/public/cms/img/icons/delete!.png" alt="Удалить ветку комментария" align="left" title="Удалить ветку комментария">
            </a>
            &nbsp
            <a href="{$root_url}comments/add/type/comments/pid/{$node.id}/page/articles/item/{$id}" title="Комментировать">
                <b>{$node.title}</b> 
            </a>
            <br /><br />{$node.msg}  
        </div>

       </td>
    </tr>
    {/if}
{/foreach}
</table>