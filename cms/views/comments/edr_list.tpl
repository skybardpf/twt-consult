{if $comments_list}
<table>
{foreach from=$comments_list item=node}
    {if $node.level != 0}
    <tr style="height: 25px;">
       <td>
        <div class="comments" style=" margin-left: {math equation='x*16' x=$node.level}px;" >
            <a href ="{$root_url}{$ctrlName}/modify_comment/id/{$node.id}">
                <img src="/public/cms/img/icons/edit.png" alt="Редактировать" align="left">
            </a>
            <a href ="{$root_url}{$ctrlName}/delete_comment/id/{$node.id}">
                <img src="/public/cms/img/icons/delete.png" alt="Удалить комментарий" align="left">
            </a>
            <a href ="{$root_url}{$ctrlName}/delete_all_comments/id/{$node.id}">
                <img src="/public/cms/img/icons/delete!.png" alt="Удалить этот и все комментарии к нему" align="left">
            </a>{$node.date} рейтинг: {$node.rating}
            <br /><br />
            <a href="abs#" title="Комментировать" class='change_comment' type='no' comm_id="{$node.id}">
                <b>{if $node.usr_id}{$node.usr_name}{else}{$node.name}{/if}</b> 
            </a>
            {if $node.usr_id}{$node.usr_mail}{else}{$node.mail}{/if}
            <br /><br />{$node.msg}  
        </div>

       </td>
    </tr>
    {/if}
{/foreach}
</table>
<br />
{/if}