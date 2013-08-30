<table style="float: left;">
    {if $objOld}
        <tr>
            <td></td>
            <td align="center">Было</td>
            <td align="center">Стало</td>
        </tr>
    {else}
        <tr>
            <td></td>
            <td>{if $obj.realtor_action eq 'del'}На удаление{/if}
                {if $obj.realtor_action eq 'new'}На добавление{/if}</td>
        </tr>
    {/if}
    {if $objOld}
        {foreach from=$fields item=field key=key}
            <tr{if $objOld[$key] neq $obj[$key]} bgcolor="red"{/if}>
                {if $field.title}                    
                    <td>{$field.title}</td>
                    {if $field.values}
                        <td>{foreach from=$field.values item=v key=k}{if $k eq $objOld[$key]}{$v}{/if}{/foreach}</td>
                        <td>{foreach from=$field.values item=v key=k}{if $k eq $obj[$key]}{$v}{/if}{/foreach}</td>
                    {else}
                        <td>{$objOld[$key]}</td>
                        <td>{$obj[$key]}</td>
                    {/if}
                {/if}
            </tr>   
        {/foreach}
    {else}
        {foreach from=$fields item=field key=key}
            <tr>
                {if $field.title}                    
                    <td>{$field.title}</td>
                    {if $field.values}
                        <td>{foreach from=$field.values item=v key=k}{if $k eq $obj[$key]}{$v}{/if}{/foreach}</td>
                    {else}
                        <td>{$obj[$key]}</td>
                    {/if}
                {/if}
            </tr>
        {/foreach}
    {/if}
</table>
<div style="float: right;">
    <form name="deny_comment">
        <input type="text">
    </form>
</div>
<br /><br />